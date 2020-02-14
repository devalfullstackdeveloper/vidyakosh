@extends('backend.layouts.app')
@section('title', __('labels.backend.courses.title').' | '.app_name())
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

{!! Form::open(['method' => 'POST', 'route' => ['admin.courses.store'], 'files' => true]) !!}

<div class="card">
    <div class="card-header">
        <h3 class="page-title float-left">@lang('labels.backend.courses.create')</h3>
        <div class="float-right">
            <a href="{{ route('admin.courses.index') }}"
               class="btn btn-success">@lang('labels.backend.courses.view')</a>
        </div>
    </div>

    <div class="card-body">
        @if (Auth::user()->isAdmin())
        <div class="row">
            <div class="col-12">
                <!-- <div class="col-10 form-group">
                     {!! Form::label('teachers',trans('labels.backend.courses.fields.teachers'), ['class' => 'control-label']) !!}
                     {!! Form::select('teachers[]', $teachers, old('teachers'), ['class' => 'form-control select2 js-example-placeholder-multiple', 'multiple' => 'multiple']) !!}
                 </div>-->
                <div class="form-group row"> 
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('ministry_id', trans('labels.backend.ministry.fields.ministry_name'), ['class' => 'control-label']) !!}
                        {!! Form::select('ministry_id', $ministry,  (request('ministry_id')) ? request('ministry_id') : old('ministry_id'), ['class' => 'form-control select2', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">@lang('labels.backend.departments.fields.department_name')</label>
                        <select class="form-control select2"  name="department_id" required>
                            <option value="">Please Select</option>  
                        </select>
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('category_id',trans('labels.backend.courses.fields.category'), ['class' => 'control-label']) !!}
                        {!! Form::select('category_id', $categories, old('category_id'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">@lang('labels.backend.courses.fields.subcategory')</label>
                        <select class="form-control select2"  name="sub_cat_id" required>
                            <option value="">Please Select</option>

                        </select>
                    </div>
					

                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Course Difficulty</label>
                        <select class="form-control select2"  name="difficulty_id" required>
                            <option value="">Please Select</option>
                            @foreach($difficulty as $difficulty => $value)
                            <option value=<?= $value->id; ?>><?= ucwords($value->name); ?></option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Course Type</label>
                        <select class="form-control select2"  name="course_type_id" required>
                            <option value="">Please Select</option>
                            @foreach($course_type as $course_type => $value)
                            <option value=<?= $value->id; ?>><?= ucwords($value->name); ?></option>
                            @endforeach
                        </select>
                    </div>
					<div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Designation</label>
                        <select class="form-control select2"  name="crt_designation_id[]" id="crt_designation_id" multiple="true">
                            <option value="">Please Select</option>
                        </select>
                    </div>
					
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Course Enrollment Type</label>
                        <select class="form-control select2"  name="course_enrollment_type_id" required>
                            <option value="">Please Select</option>
                            @foreach($course_enrollment_type as $course_enrollment_type => $value)
                            <option value=<?= $value->id; ?>><?= ucwords($value->name); ?></option>
                            @endforeach
                        </select>
					</div>
					<div class="col-12 col-lg-6 form-group">
                        {!! Form::label('moodle_course_ref_id', trans('labels.backend.courses.fields.moodle_course_ref_id').' *', ['class' => 'control-label']) !!}
                        {!! Form::text('moodle_course_ref_id', old('title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.moodle_course_ref_id'), 'required' => false, 'required']) !!}
                    </div>
					
					

                </div><!--form-group--> 

            </div>
        </div>
        @endif

        <!--<div class="row">
            <div class="col-10 form-group">
                {!! Form::label('category_id',trans('labels.backend.courses.fields.category'), ['class' => 'control-label']) !!}
                {!! Form::select('category_id', $categories, old('category_id'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false]) !!}
            </div>
            <div class="col-2 d-flex form-group flex-column">
                OR <a target="_blank" class="btn btn-primary mt-auto"
                      href="{{route('admin.categories.index').'?create'}}">{{trans('labels.backend.courses.add_categories')}}</a>
            </div>
        </div>-->

        <div class="row">
            <div class="col-12 col-lg-6 form-group">
                {!! Form::label('title', trans('labels.backend.courses.fields.title').' *', ['class' => 'control-label']) !!}
                {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.title'), 'required' => false, 							'required']) !!}
            </div>
			<div class="col-12 col-lg-6 form-group">
                {!! Form::label('sort_name', trans('labels.backend.courses.fields.sort_name').' *', ['class' => 'control-label']) !!}
                {!! Form::text('short_name', old('short_name'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.sort_name'), 'required' => false, 							'required']) !!}
            </div>
            <div class="col-12 col-lg-6 form-group">
                {!! Form::label('slug',  trans('labels.backend.courses.fields.slug'), ['class' => 'control-label']) !!}
                {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' =>  trans('labels.backend.courses.slug_placeholder'), 'required']) !!}

            </div>
        </div>
        <div class="row">

            <div class="col-12 form-group">
                {!! Form::label('description',  trans('labels.backend.courses.fields.description'), ['class' => 'control-label']) !!}
                {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => trans('labels.backend.courses.fields.description'), 'required']) !!}

            </div>
        </div>
        <div class="row">
            <!--<div class="col-12 col-lg-4 form-group">
                 {!! Form::label('price',  trans('labels.backend.courses.fields.price').' (in '.$appCurrency["symbol"].')', ['class' => 'control-label']) !!}
                 {!! Form::number('price', old('price'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.price'), 'pattern' => "[0-9]"]) !!}
             </div> -->
            <div class="col-12 col-lg-4 form-group">
                {!! Form::label('course_image',  trans('labels.backend.courses.fields.course_image'), ['class' => 'control-label']) !!}
                {!! Form::file('course_image',  ['class' => 'form-control', 'accept' => 'image/jpeg,image/gif,image/png', 'required']) !!}
                {!! Form::hidden('course_image_max_size', 8) !!}
                {!! Form::hidden('course_image_max_width', 4000) !!}
                {!! Form::hidden('course_image_max_height', 4000) !!}

            </div>
            <div class="col-12 col-lg-4  form-group">
                {!! Form::label('start_date', trans('labels.backend.courses.fields.start_date').' (yyyy-mm-dd)', ['class' => 'control-label']) !!}
                {!! Form::text('start_date', old('start_date'), ['class' => 'form-control date','pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.courses.fields.start_date').' (Ex . 2019-01-01)', 'autocomplete' => 'off', 'required']) !!}

            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                {!! Form::label('add_video', trans('labels.backend.lessons.fields.add_video'), ['class' => 'control-label']) !!}

                {!! Form::select('media_type', ['youtube' => 'Youtube','vimeo' => 'Vimeo','upload' => 'Upload','embed' => 'Embed'],null,['class' => 'form-control', 'placeholder' => 'Select One','id'=>'media_type' , 'required']) !!}

                {!! Form::text('video', old('video'), ['class' => 'form-control mt-3 d-none', 'placeholder' => trans('labels.backend.lessons.enter_video_url'),'id'=>'video' , 'required' ]) !!}


                {!! Form::file('video_file', ['class' => 'form-control mt-3 d-none', 'placeholder' => trans('labels.backend.lessons.enter_video_url'),'id'=>'video_file' , 'required' ]) !!}

                @lang('labels.backend.lessons.video_guide')

            </div>
        </div>

        <div class="row">
            <div class="col-12 form-group">
                <div class="checkbox d-inline mr-3">
                    {!! Form::hidden('published', 0) !!}
                    {!! Form::checkbox('published', 1, false, []) !!}
                    {!! Form::label('published',  trans('labels.backend.courses.fields.published'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                </div>

                <div class="checkbox d-inline mr-3">
                    {!! Form::hidden('featured', 0) !!}
                    {!! Form::checkbox('featured', 1, false, []) !!}
                    {!! Form::label('featured',  trans('labels.backend.courses.fields.featured'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                </div>

                <div class="checkbox d-inline mr-3">
                    {!! Form::hidden('trending', 0) !!}
                    {!! Form::checkbox('trending', 1, false, []) !!}
                    {!! Form::label('trending',  trans('labels.backend.courses.fields.trending'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                </div>

                <div class="checkbox d-inline mr-3">
                    {!! Form::hidden('popular', 0) !!}
                    {!! Form::checkbox('popular', 1, false, []) !!}
                    {!! Form::label('popular',  trans('labels.backend.courses.fields.popular'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                </div>

                <!--  <div class="checkbox d-inline mr-3">
                     {!! Form::hidden('free', 0) !!}
                     {!! Form::checkbox('free', 1, false, []) !!}
                     {!! Form::label('free',  trans('labels.backend.courses.fields.free'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                 </div> -->


            </div>

        </div>

        <div class="row">
            <div class="col-12 form-group">
                {!! Form::label('meta_title',trans('labels.backend.courses.fields.meta_title'), ['class' => 'control-label']) !!}
                {!! Form::text('meta_title', old('meta_title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.meta_title'), 'required']) !!}

            </div>
            <div class="col-12 form-group">
                {!! Form::label('meta_description',trans('labels.backend.courses.fields.meta_description'), ['class' => 'control-label']) !!}
                {!! Form::textarea('meta_description', old('meta_description'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.meta_description'), 'required']) !!}
            </div>
            <div class="col-12 form-group">
                {!! Form::label('meta_keywords',trans('labels.backend.courses.fields.meta_keywords'), ['class' => 'control-label']) !!}
                {!! Form::textarea('meta_keywords', old('meta_keywords'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.meta_keywords'), 'required']) !!}
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
        $('#start_date').datepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}"
        });

        $(".js-example-placeholder-single").select2({
            placeholder: "{{trans('labels.backend.courses.select_category')}}",
        });

        $(".js-example-placeholder-multiple").select2({
            placeholder: "{{trans('labels.backend.courses.select_teachers')}}",
        });
    });

    var uploadField = $('input[type="file"]');

    $(document).on('change', 'input[type="file"]', function () {
        var $this = $(this);
        $(this.files).each(function (key, value) {
            if (value.size > 5000000) {
                alert('"' + value.name + '"' + 'exceeds limit of maximum file upload size')
                $this.val("");
            }
        })
    })


    $(document).on('change', '#media_type', function () {
        if ($(this).val()) {
            if ($(this).val() != 'upload') {
                $('#video').removeClass('d-none').attr('required', true)
                $('#video_file').addClass('d-none').attr('required', false)
            } else if ($(this).val() == 'upload') {
                $('#video').addClass('d-none').attr('required', false)
                $('#video_file').removeClass('d-none').attr('required', true)
            }
        } else {
            $('#video_file').addClass('d-none').attr('required', false)
            $('#video').addClass('d-none').attr('required', false)
        }
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
                        //console.log(data);
                        $('select[name="sub_cat_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="sub_cat_id"]').append('<option value="'+key+'">'+value+'</option>');
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
		});
		 <!---------------------------------------------------filter for designation-------------------------------->
			$(document).ready(function() {
        $('select[name="department_id"]').on('change', function() {
            var departmentid = $(this).val();
			//alert(departmentid);
            // alert(ministryID); exit;
            if(departmentid) {
                $.ajax({
                    url: 'designation-ajax/'+departmentid,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
						//$('#crt_designation_id').select2('distroy');
						console.log(data);
                        
                        $('#crt_designation_id').empty().append('<option value="">Select Designation</option>');
                        $.each(data, function(key, value) {
                            $('#crt_designation_id').append('<option value="'+ key +'">'+ value +'</option>');
                        });
						//$('#crt_designation_id').select2();
						$('#crt_designation_id').select2();

                    }
                });
            }else{
                $('#crt_designation_id').empty();
            }
        });
    });
   
</script>


@endpush