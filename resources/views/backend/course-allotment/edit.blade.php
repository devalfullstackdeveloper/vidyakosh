@extends('backend.layouts.app')
@section('title', __('labels.backend.course-allotment.title').' | '.app_name())
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

{!! Form::model($course_allotment, ['method' => 'PUT', 'route' => ['admin.course_allotment.update', $course_allotment->id], 'files' => true,]) !!}

<div class="card">
    <div class="card-header">
        <h3 class="page-title float-left mb-0">@lang('labels.backend.course-allotment.edit')</h3>
        <div class="float-right">
            <a href="{{ route('admin.course_allotment.index') }}"
               class="btn btn-success">@lang('labels.backend.course-allotment.view')</a>
        </div>
    </div>

    <div class="card-body">

        @if (Auth::user()->isAdmin())
        <div class="row">
            <div class="col-12">
                <div class="form-group row"> 
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">@lang('labels.backend.departments.fields.department_name')</label>
                        {!! Form::select('department_id', $departments, $deptArr , ['class' => 'form-control select2', 'multiple' => false, 'required']) !!}
                    </div>

					<div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">@lang('labels.backend.tracks.fields.name')</label>
                        {!! Form::select('track_id', $tracks, $trackArr , ['class' => 'form-control select2', 'multiple' => false, 'required']) !!}
                    </div>
                    
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('category_id',trans('labels.backend.courses.fields.category'), ['class' => 'control-label require']) !!}
                        {!! Form::select('category_id', $categories, $catArr, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">@lang('labels.backend.courses.fields.subcategory')</label>
                        {!! Form::select('sub_cat_id', $subcategories, $course_allotment->sub_cat_id, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">Course Level</label>
                        {!! Form::select('difficulty_id', $difficulty, $course_allotment->difficulty_id, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">Course</label>
                        {!! Form::select('course_type_id[]', $courses, $course_type_arr, ['class' => 'form-control select2 js-example-placeholder-multiple', 'multiple' => true, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">Assigned To</label>
                        {!! Form::select('assign_to', $assign_to, $course_allotment->assign_to, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    @if($course_allotment->assign_to == 'individual')
                    <div class="col-12 col-lg-6 form-group" id="assign_to_div_user">
                        <label class="control-label">Users</label>
                        <select class="form-control chosen-select"  id="dept_user_id" name="dept_user_id[]" multiple="multiple">
                             <option value="">Please Select</option>
                             @foreach($deptusers as $id => $user)
                      			<option  @if( in_array($id,$alloted_dusers_arr) ) selected="selected" @else '' @endif value="{{$id}}">{{$user}}</option>
                      		 @endforeach
                        </select>
                    </div>
                    @endif
                    @if($course_allotment->assign_to == 'group')
                    <div class="col-12 col-lg-6 form-group" id="assign_to_div_deal">
                        <label class="control-label">Designation</label>
                        <select class="form-control chosen-select"  id="dept_deal_id" name="dept_deal_id[]" multiple="multiple">
                             @foreach($designations as $id => $designation)
                      			<option  @if( in_array($id,$alloted_designations_arr) ) selected="selected" @else '' @endif value="{{$id}}">{{$designation}}</option>
                      		 @endforeach
                        </select>
                    </div>
                    @endif
                   <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('completion_date', trans('labels.backend.course-allotment.completion_date').' (yyyy-mm-dd)', ['class' => 'control-label']) !!}
                    {!! Form::text('completion_date', $course_allotment->completion_date, ['class' => 'form-control date', 'pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.course-allotment.completion_date').' (Ex . 2019-01-01)']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('completion_date'))
                    <p class="help-block">
                        {{ $errors->first('completion_date') }}
                    </p>
                    @endif
		            </div>
                </div><!--form-group--> 
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-12  text-center form-group">
                {!! Form::submit(trans('strings.backend.general.app_update'), ['class' => 'btn btn-danger']) !!}
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
@stop

@push('after-scripts')
<script>

    $(document).ready(function () {
        $('#completion_date').datepicker({
            autoclose: true,
            minDate:0,
            dateFormat: "{{ config('app.date_format_js') }}"
        });

        $(".js-example-placeholder-single").select2({
            placeholder: "{{trans('labels.backend.courses.select_category')}}",
        });

        $(".js-example-placeholder-multiple").select2({
            placeholder: "{{trans('labels.backend.courses.select_teachers')}}",
        });
    });
</script>
@endpush