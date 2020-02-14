@extends('backend.layouts.app')
@section('title', __('labels.backend.designations.title').' | '.app_name())
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
{{ html()->modelForm($designations, 'PATCH', route('admin.designations.update', $designations->id))->class('form-horizontal')->acceptsFiles()->open() }}

<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.designations.edit')</h3>
        <div class="float-right">
            <a href="{{ route('admin.designations.index') }}"
               class="btn btn-success">@lang('labels.backend.designations.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <?//php print_r($designation);die;?>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('department_id',trans('labels.backend.designations.fields.department_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('department_id', $departments, $designations->department_id, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                     <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('department_id',trans('labels.backend.designations.fields.parent_designation_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('parent_designation_id', $parentArr, $designations->parent_designation_id, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div> 

                    <?//php print($designation);die;?>
                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.designations.fields.designation'))->class('form-control-label require')->for('designation') }}
                        {{ html()->text('designation')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.designations.fields.designation'))
                        ->attribute('maxlength', 500)
                        ->required()
                        ->autofocus() }} 

                    </div> 
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0" {{old('status',$designations->status)=="0"? 'selected':''}}>Save</option>
                            <option value="1" {{old('status',$designations->status)=="1"? 'selected':''}}>Save & Publish</option>
                        </select>
                    </div>
                </div><!--form-group-->


                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.designations.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.update')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        var APP_URL = {!! json_encode(url('/')) !!};
        $('select[name="department_id"]').on('change', function() {
            var departmentID = $(this).val();
            if(departmentID) {
                $.ajax({
//                    url: 'designation_ajax/'+departmentID,
                    url: APP_URL+'/user/designations/designation_ajax/'+departmentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        var parent = '<option value="">Please select</option>';
//                        $('select[name="parent_designation_id"]').empty();
                        $.each(data, function(key, value) {
                            parent +='<option value="'+ key +'">'+ value +'</option>';
//                            $('select[name="parent_designation_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        $('select[name="parent_designation_id"]').html(parent);
                    }
                });
            }else{
                $('select[name="parent_designation_id"]').empty();
            }
        });
    });
</script>
{{ html()->closeModelForm() }}
@endsection
