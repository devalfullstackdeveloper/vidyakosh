@extends('backend.layouts.app')

@section('title', __('labels.backend.organization_departments.title').' | '.app_name())
@push('after-styles')
<link rel="stylesheet" href="{{asset('assets/plugins/YearPicker/style.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/YearPicker/yearpicker.css')}}" />

<link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
<script src="{{asset('plugins/bootstrap-tagsinput/jquery.min.js')}}"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
{{ html()->form('POST', route('admin.organization_departments.store'))->acceptsFiles()->class('form-horizontal division_form')->open() }}
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.organization_departments.create')</h3>
        <div class="float-right">
            <a href="{{ route('admin.organization_departments.index') }}"
               class="btn btn-success">@lang('labels.backend.organization_departments.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">

                <div class="form-group row">  
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.organization_departments.fields.department_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('department_id', $department, old('department'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.organization_departments.fields.department_name'), ['class' => 'control-label require']) !!}
                        {{ html()->text('department_name')
                                ->class('form-control restrict')
                                ->placeholder(__('labels.backend.organization_departments.fields.department_name'))
                                ->attribute('maxlength', 100)
                                ->required()
                                ->autofocus() }}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.organization_departments.fields.is_group'), ['class' => 'control-label']) !!}
                        <select class="form-control select2"  name="is_group">
                            <option value="">Please select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-6 form-group group d-none">
                        {!! Form::label('z',trans('labels.backend.organization_departments.fields.parent_id'), ['class' => 'control-label']) !!}
                        <select class="form-control select2"  name="parent_id">
                            <option value="">Please Select</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.organization_departments.fields.status'), ['class' => 'control-label']) !!}
                        <select class="form-control select2"  name="status">
                            <option value="0">Save</option>
                            <option value="1">Save & Publish</option>
                        </select>
                    </div>
                </div><!--form-group-->	


                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.organization_departments.index'), __('buttons.general.cancel')) }}
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
        
        $(".division_form").submit(function(e) {
            var isGroup = $('select[name="is_group"]').val();
            var parentId = $('select[name="parent_id"]').val();
            if(isGroup == 1 && parentId == ""){
                jQuery('.division_form').before('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>The Group must be Require.<br></div>');
                return false;
            }else{
                $('select[name="parent_id"]').addClass('border-danger');
                return true;    
            }
        });
        
        $('select[name="parent_id"]').on('change', function() {
            $(':input[type="submit"]').prop('disabled', false);
        });
        
        $('select[name="is_group"]').on('change', function() {
            var group = $(this).val();
            
            if(group == 1){
                $(".group").removeClass('d-none');
            }else{
                $(".group").addClass('d-none');
            }
            
        });
        	
        $('select[name="department_id"]').on('change', function() {
            var departmentID = $(this).val();
            //alert(departmentID);
            if(departmentID) {
                $.ajax({
                    url: 'office-ajax/'+departmentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        var groupHtml = '<option value="">Please select</option>';
                            $.each(data, function(key, value) {
                                    groupHtml += '<option value="'+ key +'">'+ value +'</option>';
                            });
                         $('select[name="parent_id"]').html(groupHtml);

                    }
                });
            }
        });
	
        
    });
</script>
<script>
	$(function() {//<-- wrapped here
  $('.restrict').on('input', function() {
    this.value = this.value.replace(/[^a-zA-Z@\s]/g, ''); //<-- replace all other than given set of values
  });
});
	</script>
@endsection
