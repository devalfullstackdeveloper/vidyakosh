@extends('backend.layouts.app')
@section('title', __('labels.backend.faculty.title').' | '.app_name())

@section('content')
{{ html()->modelForm($faculty, 'PATCH', route('admin.faculty.update', $faculty->id))->class('form-horizontal')->acceptsFiles()->open() }}
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
        <h3 class="page-title d-inline">@lang('labels.backend.faculty.edit')</h3>
        <div class="float-right">
            <a href="{{ route('admin.faculty.index') }}"
               class="btn btn-success">@lang('labels.backend.faculty.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.faculty.fields.department_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('department_id', $department, $faculty->deptid, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div> 
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.faculty.fields.institute_industry_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('institute_industry_id', $institute_industry, $faculty->institute_industry_id, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.faculty.fields.name'), ['class' => 'control-label require']) !!}
                        {{ html()->text('name')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.faculty.fields.name'))
                                ->attribute('maxlength', 100)
                                ->required()
                                ->autofocus() }}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.faculty.fields.designation'), ['class' => 'control-label require']) !!}
                        {{ html()->text('designation')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.faculty.fields.designation'))
                        ->attribute('maxlength', 500)
                        ->required()
                        ->autofocus() }}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.faculty.fields.mobile'), ['class' => 'control-label require']) !!}
                        {{ html()->text('mobile')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.faculty.fields.mobile'))
                        ->attribute('maxlength', 10)
                        ->attribute('minlength', 10)
                        ->attribute('pattern', '\d*')
                        ->required()
                        ->autofocus() }}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.faculty.fields.email'), ['class' => 'control-label require']) !!}
                        {{ html()->email('email')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.faculty.fields.email'))
                        ->attribute('maxlength', 500)
                        ->required()
                        ->autofocus() }}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.faculty.fields.address'), ['class' => 'control-label require']) !!}
                        {{ html()->text('address')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.faculty.fields.address'))
                        ->attribute('maxlength', 500)
                        ->required()
                        ->autofocus() }}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.faculty.fields.subject'), ['class' => 'control-label require']) !!}
                        {!! Form::select('subject_id[]', $subject, $faculty_subject, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => true, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0" {{old('status',$faculty->status)=="0"? 'selected':''}}>Save</option>
                            <option value="1" {{old('status',$faculty->status)=="1"? 'selected':''}}>Save & Publish</option>
                        </select>
                    </div>
                </div><!--form-group-->


                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.faculty.index'), __('buttons.general.cancel')) }}
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
            //alert(departmentID);
            if(departmentID) {
                $.ajax({
                    url: '/nic-lms/public/user/faculty/office-ajax/'+departmentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        
//                        $('select[name="office_id"]').empty();
                        var train_ind_html = '<option value="">Please select</option>';
                        $.each(data, function(key, value) {
                            train_ind_html += '<option value="'+ key +'">'+ value +'</option>';
                        });
                         $('select[name="institute_industry_id"]').html(train_ind_html);

                    }
                });
            }else{
                $('select[name="office_id"]').empty();
            }
        });	
        
    });
</script>
@endsection