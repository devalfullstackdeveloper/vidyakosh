@extends('backend.layouts.app')

@section('title', __('labels.backend.venues.title').' | '.app_name())
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
{{ html()->form('POST', route('admin.section.store'))->acceptsFiles()->class('form-horizontal')->open() }}
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.sectionofficers.create')</h3>
        <div class="float-right">
            <a href="{{ route('admin.section.index') }}"
               class="btn btn-success">@lang('labels.backend.sectionofficers.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">   
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.sectionofficers.fields.department_id'), ['class' => 'control-label']) !!}
                        {!! Form::select('department_id', $department, old('department'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.sectionofficers.fields.officer_id'), ['class' => 'control-label']) !!}
                        {!! Form::select('officer_id', $users, old('users'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>





                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0">Save</option>
                            <option value="1">Save & Publish</option>
                        </select>
                        </select>
                    </div>
                </div><!--form-group-->	


                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.section.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>
</div>
{{ html()->form()->close() }}

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="ministry_id"]').on('change', function() {
            var ministryID = $(this).val();
            //alert(ministryID); exit;
            if(ministryID) {
                $.ajax({
                    url: 'department-ajax/'+ministryID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        
                        $('select[name="department_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="department_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="department_id"]').empty();
            }
        });
				
		
        $('select[name="department_id"]').on('change', function() {
            var departmentID = $(this).val();
            //alert(departmentID); exit;
            if(departmentID) {
                $.ajax({
                    url: 'office-ajax/'+departmentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        
                        $('select[name="office_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="office_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="office_id"]').empty();
            }
        });	
			
		
    });
</script>
@endsection
