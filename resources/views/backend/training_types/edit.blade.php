@extends('backend.layouts.app')
@section('title', __('labels.backend.training-type.title').' | '.app_name())

@push('after-styles')
<link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
<style>
    .select2-container--default .select2-selection--single {
        height: 35px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 35px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 35px;
    }

    .bootstrap-tagsinput {
        width: 100% !important;
        display: inline-block;
    }

    .bootstrap-tagsinput .tag {
        line-height: 1;
        margin-right: 2px;
        background-color: #2f353a;
        color: white;
        padding: 3px;
        border-radius: 3px;
    }

</style>

@endpush

@section('content')
{{ html()->modelForm($training_types, 'PATCH', route('admin.training_types.update', $training_types->id))->class('form-horizontal')->acceptsFiles()->open() }}

<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.training-type.edit')</h3>
        <div class="float-right">
            <a href="{{ route('admin.training_types.index') }}"
               class="btn btn-success">@lang('labels.backend.training-type.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('department_id', trans('labels.backend.departments.fields.department_name'), ['class' => 'control-label require']) !!}
                        {!! Form::select('department_id', $departments, $training_types->department_id, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>


                    <div class="col-12 col-lg-6 form-group">
                        <label class="form-control-label require">Title</label> 
                        {{ html()->text('title')
                        ->class('form-control')
                        ->placeholder(__('Title'))
                        ->attribute('maxlength', 191)
                        ->required()
                        ->autofocus() }}       
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0" {{old('status',$training_types->status)=="0"? 'selected':''}}>Save</option>
                            <option value="1" {{old('status',$training_types->status)=="1"? 'selected':''}}>Save & Publish</option>
                        </select>
                    </div>



                </div>








                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.cities.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.update')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>

</div>
{{ html()->closeModelForm() }}

@endsection
<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var APP_URL = {!! json_encode(url('/')) !!};
        $('select[name="state"]').on('change', function() {
            var stateID = $(this).val();
			
            if(stateID != '')
            {
                if(stateID) {
                    $.ajax({
                        url: APP_URL+'/user/training_types/statecity-ajax/'+stateID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            console.log(data);
                            $('select[name="city"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="city"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });


                        }
                    });
                }else{
                    $('select[name="city_id').empty();
                }
            }
            else
            {
                //Please Select Has been Selected
            }
			
            
        });
		
	
    });
</script>

