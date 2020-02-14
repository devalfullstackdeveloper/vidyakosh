@extends('backend.layouts.app')
@section('title', __('labels.backend.organization_departments.title').' | '.app_name())

@section('content')
{{ html()->modelForm($organization_departments, 'PATCH', route('admin.organization_departments.update', $organization_departments->id))->class('form-horizontal division_form')->acceptsFiles()->open() }}
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
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.organization_departments.edit')</h3>
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
                        {!! Form::select('department_id', $department, $organization_departments->deptid, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.organization_departments.fields.department_name'), ['class' => 'control-label require']) !!}
                        {{ html()->text('department_name')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.organization_departments.fields.department_name'))
                                ->attribute('maxlength', 100)
                                ->required()
                                ->autofocus() }}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.organization_departments.fields.is_group'), ['class' => 'control-label']) !!}
                        <select class="form-control select2"  name="is_group">
                            <option value="">Please select</option>
                            <option value="1" {{old('status',$organization_departments->is_group)=="1"? 'selected':''}}>Yes</option>
                            <option value="0" {{old('status',$organization_departments->is_group)=="0"? 'selected':''}}>No</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-6 form-group group d-none">
                        {!! Form::label('z',trans('labels.backend.organization_departments.fields.parent_id'), ['class' => 'control-label']) !!}
                        {!! Form::select('parent_id', $groupArr, $organization_departments->parent_id, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false]) !!}
                    </div>
                    
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0" {{old('status',$organization_departments->status)=="0"? 'selected':''}}>Save</option>
                            <option value="1" {{old('status',$organization_departments->status)=="1"? 'selected':''}}>Save & Publish</option>
                        </select>
                    </div>
                </div><!--form-group-->	


                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.organization_departments.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.update')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>
</div>
{{ html()->closeModelForm() }}
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
        
        var APP_URL = {!! json_encode(url('/')) !!}; 
        
        var gId = $('select[name="is_group"]').val();
        if(gId == 1){
            $(".group").removeClass('d-none');
        }else{
            $(".group").addClass('d-none');
        }
            
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
                    url: APP_URL+'/user/organization_departments/office-ajax/'+departmentID,
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
@endsection