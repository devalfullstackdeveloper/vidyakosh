@extends('backend.layouts.app')

@section('title', __('labels.backend.signings.title').' | '.app_name())
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
{{ html()->form('POST', route('admin.signing.store'))->acceptsFiles()->class('form-horizontal')->open() }}
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.signings.create')</h3>
        <div class="float-right">
            <a href="{{ route('admin.section.index') }}"
               class="btn btn-success">@lang('labels.backend.signings.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">

                <div class="form-group row">  
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.signings.fields.department_id'), ['class' => 'control-label']) !!}
                        {!! Form::select('department_id', $department, old('department'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.signings.fields.office_id'), ['class' => 'control-label']) !!}
                        {!! Form::select('office_id', $office, old('office'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.signings.fields.officer_id'), ['class' => 'control-label']) !!}
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
                        {{ form_cancel(route('admin.signing.index'), __('buttons.general.cancel')) }}
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
                    url: 'department-ajax/'+departmentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        var office_html = '<option value="">Please Select</option>';
                        $.each(data, function(key, value) {
                            office_html += '<option value="'+ key +'">'+ value +'</option>';
                        });
                        $('select[name="office_id"]').html(office_html);
                    }
                });
            }else{
                $('select[name="office_id"]').empty();
            }
        });	
        $('select[name="office_id"]').on('change', function() {
            var officeID = $(this).val();
            //alert(departmentID); exit;
            if(officeID) {
                $.ajax({
                    url: 'office-ajax/'+officeID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        var officer_html = '<option value="">Please Select</option>';
                        $.each(data, function(key, value) {
                            console.log(value.id)
                            console.log(value.officer_name)
                            officer_html += '<option value="'+ value.id +'">'+ value.emp_code + ' | ' + value.officer_name + ' | ' + value.designation + '</option>';
                        });
                        $('select[name="officer_id"]').html(officer_html);
                    }
                });
            }else{
                $('select[name="office_id"]').empty();
            }
        });	
			
		
    });
</script>
@endsection
