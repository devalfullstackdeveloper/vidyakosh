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

{!! Form::open(['method' => 'POST', 'route' => ['admin.course_allotment.store'], 'files' => true]) !!}

<div class="card">
    <div class="card-header">
        <h3 class="page-title float-left">@lang('labels.backend.course-allotment.create')</h3>
        <div class="float-right">
            <a href="{{ route('admin.courses.index') }}"
               class="btn btn-success">@lang('labels.backend.course-allotment.view')</a>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row"> 
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('department_id', trans('labels.backend.departments.fields.department_name'), ['class' => 'control-label require']) !!}
                        {!! Form::select('department_id', $departments,  (request('department_id')) ? request('department_id') : old('department_id'), ['class' => 'form-control select2', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">@lang('labels.backend.tracks.fields.name')</label>
                        <select class="form-control select2"  name="track_id" required>
                            <option value="">Please Select</option>  
                        </select>
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">@lang('labels.backend.courses.fields.category')</label>
                        <select class="form-control select2"  name="category_id" required>
                            <option value="">Please Select</option>  
                        </select>
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">@lang('labels.backend.courses.fields.subcategory')</label>
                        <select class="form-control select2"  name="sub_cat_id" required>
                            <option value="">Please Select</option>
                        </select>
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">Course Level</label>
                        <select class="form-control select2"  name="difficulty_id" required>
                            <option value="">Please Select</option>
                            @foreach($difficulty as $difficulty => $value)
                            <option value=<?= $value->id; ?>><?= ucwords($value->name); ?></option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">Course</label>
                        <select class="form-control chosen-select"  id="course_type_id" name="course_type_id[]" required multiple="multiple">
                            <!--<option value="">Please Select</option>
                            @foreach($course_type as $course_type => $value)
                            @endforeach-->
                             <option value="">Please Select</option>
                        </select>
                    </div>
 					<div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">Assigned To</label>
                        <select class="form-control select2"  name="assign_to" required>
                            <option value="">Please Select</option>
                            <option value="individual">Individual</option>
                            <option value="group">Group</option>
                        </select>
                    </div>
                     <div class="col-12 col-lg-6 form-group" id="assign_to_div_user" style="display:none;">
                        <label class="control-label">Users</label>
                        <select class="form-control chosen-select"  id="dept_user_id" name="dept_user_id[]" multiple="multiple">
                             <option value="">Please Select</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-6 form-group" id="assign_to_div_deal" style="display:none;">
                        <label class="control-label">Designation</label>
                        <select class="form-control chosen-select"  id="dept_deal_id" name="dept_deal_id[]" multiple="multiple">
                             <option value="">Please Select</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-4  form-group">
                        {!! Form::label('completion_date', trans('labels.backend.course-allotment.completion_date').' (yyyy-mm-dd)', ['class' => 'control-label require']) !!}
                        {!! Form::text('completion_date', old('completion_date'), ['class' => 'form-control date','pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.course-allotment.completion_date').' (Ex . 2019-01-01)', 'autocomplete' => 'off', 'required']) !!}
        
                    </div>
                </div><!--form-group--> 

            </div>
        </div>
        <div class="row">
            <div class="col-12  text-center form-group">

                {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-lg btn-danger']) !!}
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
    });

    $(document).ready(function() {
        $('select[name="category_id"]').on('change', function() {
            var categoryID = $(this).val();
            // alert(categoryID);
            if(categoryID) {
                $.ajax({
                    url: 'subcat-ajax/'+categoryID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        
                        $('select[name="sub_cat_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="sub_cat_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="sub_cat_id"]').empty();
            }
        });
    });
		
    <!-------------------------------------------------------------------------------->filter
    $(document).ready(function() {
        $('select[name="ministry_id"]').on('change', function() {
            var ministryID = $(this).val();
            // alert(ministryID); exit;
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
            // alert(ministryID); exit;
            if(departmentID) {
                $.ajax({
                    url: 'track-ajax/'+departmentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        
                        $('select[name="track_id"]').empty();
						$('select[name="track_id"]').append('<option value="">Please Select</option> ');
                        $.each(data, function(key, value) {
                            $('select[name="track_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="track_id"]').empty();
				$('select[name="track_id"]').append('<option value="">Please Select</option> ');
            }
        });
		$('select[name="track_id"]').on('change', function() {
            var trackID = $(this).val();
            // alert(ministryID); exit;
            if(trackID) {
                $.ajax({
                    url: 'category-ajax/'+trackID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        
                        $('select[name="category_id"]').empty();
						$('select[name="category_id"]').append('<option value="">Please Select</option> ');
                        $.each(data, function(key, value) {
                            $('select[name="category_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="category_id"]').empty();
				$('select[name="category_id"]').append('<option value="">Please Select</option> ');
            }
        });
		$('select[name="difficulty_id"]').on('change', function() {
            var levelID      = $(this).val();
			var categoryID   = $('select[name="category_id"]').val();
			var departmentID = $('select[name="department_id"]').val();
			var trackID      = $('select[name="track_id"]').val();
			var subcatID     = $('select[name="sub_cat_id"]').val();
            if(levelID) {
                $.ajax({
                    url: 'course-ajax/'+departmentID+'/'+trackID+'/'+categoryID+'/'+subcatID+'/'+levelID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        console.log(data); 
                        $('select[id="course_type_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[id="course_type_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="course_type_id"]').empty();
				$('select[name="course_type_id"]').append('<option value="">Please Select</option>');
            }
        });
		$('select[name="assign_to"]').on('change', function() {
            var assign_to = $(this).val();
			var departmentID = $('select[name="department_id"]').val();
			$("div#assign_to_div_deal").hide();
			$("div#assign_to_div_user").hide();
            // alert(ministryID); exit;
            if(assign_to) {
				if( assign_to == "individual" ) {
					$.ajax({
						url: 'dept-users-ajax/'+departmentID,
						type: "GET",
						dataType: "json",
						success:function(data) {
							$("div#assign_to_div_user").show();
							$('select[id="dept_user_id"]').empty();
							$.each(data, function(key, value) {
								$('select[id="dept_user_id"]').append('<option value="'+ key +'">'+ value +'</option>');
							});
	
	
						}
					});
				}
				if( assign_to == "group" ) {
					$.ajax({
						url: 'dept-designation-ajax/'+departmentID,
						type: "GET",
						dataType: "json",
						success:function(data) {
							$("div#assign_to_div_deal").show();
							$('select[id="dept_deal_id"]').empty();
							$.each(data, function(key, value) {
								$('select[id="dept_deal_id"]').append('<option value="'+ key +'">'+ value +'</option>');
							});
	
	
						}
					});
				}
            }else{
                $('select[id="dept_user_id"]').empty();
				$('select[id="dept_deal_id"]').empty();
				$("div#assign_to_div_user").hide();
				$("div#assign_to_div_deal").hide();
            }
        });
    });

    <!----------------------------------------------------------------------------------->
</script>


@endpush