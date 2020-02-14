@extends('backend.layouts.app')

@section('title', __('labels.backend.crts.title').' | '.app_name())
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
    
    fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
        box-shadow:  0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }

</style>

@endpush

@section('content')
{{ html()->form('POST', route('admin.crt.store'))->acceptsFiles()->class('form-horizontal crt_form')->open() }}
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.crts.create')</h3>
        <div class="float-right">
            <a href="{{ route('admin.crt.index') }}"
               class="btn btn-success">@lang('labels.backend.crts.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">   
                    <div class="col-12 col-lg-6 form-group">
                        <input type="hidden" id="login_user_id" value="{{$logged_in_user->id}}">
                        <input type="hidden" id="created_by" name="created_by" value="{{$logged_in_user->id}}">
                        {!! Form::label('z',trans('labels.backend.crts.fields.department_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('department_id', $department, old('department'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.track_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('track_id', $tracks, old('tracks'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.category_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('category_id', $category, old('tracks'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.year_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('year_id', $years, old('years'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.state_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('state_id', $states, old('states'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.city_id'), ['class' => 'control-label require']) !!}
                        <select class="form-control select2 js-example-placeholder-single select2-hidden-accessible" name="city_id" tabindex="-1" aria-hidden="true" required>
                            <option value="" selected="selected">Please select</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.venue_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('venue_id', $venues, old('venues'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.designation'), ['class' => 'control-label require']) !!}
                        {!! Form::select('designation_id[]', $designations, old('designations'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => true, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.title'), ['class' => 'control-label require']) !!}
                        {!! Form::text('title', old('title'), ['class' => 'form-control','placeholder' => trans('Enter Title'), 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.description'), ['class' => 'control-label require']) !!}
                        {!! Form::textarea('description', old('description'), ['class' => 'form-control','rows' => 4, 'cols' => 54, 'placeholder' => trans('Enter Description'), 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <h4 class="page-title d-inline">{!! Form::label('z',trans('labels.backend.crts.fields.coordinator'), ['class' => 'control-label']) !!}</h4>
                        <br>
                        <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Internal Coordinator</legend>
                                <div class="employee_code">
                                    {!! Form::label('z',trans('labels.backend.crts.fields.empcode'), ['class' => 'control-label']) !!}
                                    {!! Form::text('cooInternal[]', old('empcode'), ['class' => 'form-control','placeholder' => trans('labels.backend.crts.lessons.empcode')]) !!}
                                    <button class="btn btn-light pull-right add_emp_code" type="button">+</button>
                                    <button class="btn btn-light pull-right rem_emp_code" type="button">-</button>
                                </div>
                        </fieldset>
                        <br>
                        <fieldset class="scheduler-border">
                                <legend class="scheduler-border">External Coordinator</legend>
                                <div class="employee_inst_faculty">
                                    {!! Form::label('z',trans('labels.backend.crts.fields.instituteIndustry'), ['class' => 'control-label']) !!}
                                    {!! Form::select('cooExternal[\'instituteIndustry\'][]', $instituteIndustry, old('instituteIndustry'), ['class' => 'form-control js-example-placeholder-single', 'multiple' => false]) !!}
        <!--                            <br>-->
                                    {!! Form::label('z',trans('labels.backend.crts.fields.faculty'), ['class' => 'control-label']) !!}
                                    {!! Form::select('cooExternal[\'faculty\'][]', $faculty, old('faculty'), ['class' => 'form-control js-example-placeholder-single faculty_co', 'multiple' => false]) !!}

                                    <button class="btn btn-light pull-right add_emp_inst_faculty" type="button">+</button>
                                    <button class="btn btn-light pull-right rem_emp_inst_faculty" type="button">-</button>
                                </div>
                        </fieldset>
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <h4 class="page-title d-inline">{!! Form::label('z',trans('labels.backend.crts.fields.resourceperson'), ['class' => 'control-label']) !!}
                        </h4>
                        <br>
                        <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Internal Resource Person</legend>
                                <div class="employee_code_resource">
                                    {!! Form::label('z',trans('labels.backend.crts.fields.empcode'), ['class' => 'control-label']) !!}
                                    {!! Form::text('resourceInternal[]', old('empcode'), ['class' => 'form-control','placeholder' => trans('labels.backend.crts.lessons.empcode')]) !!}
                                    <button class="btn btn-light pull-right add_emp_code_resource" type="button">+</button>
                                    <button class="btn btn-light pull-right rem_emp_code_resource" type="button">-</button>
                                </div>
                        </fieldset>
                        <br>
                        <fieldset class="scheduler-border">
                                <legend class="scheduler-border">External Resource Person</legend>
                                <div class="employee_inst_faculty_resource">
                                    {!! Form::label('z',trans('labels.backend.crts.fields.instituteIndustry'), ['class' => 'control-label']) !!}
                                    {!! Form::select('resourceExternal[\'instituteIndustry\'][]', $instituteIndustry, old('instituteIndustry'), ['class' => 'form-control js-example-placeholder-single', 'multiple' => false]) !!}
                                    {!! Form::label('z',trans('labels.backend.crts.fields.faculty'), ['class' => 'control-label']) !!}
                                    {!! Form::select('resourceExternal[\'faculty\'][]', $faculty, old('faculty'), ['class' => 'form-control js-example-placeholder-single', 'multiple' => false]) !!}
                                    <button class="btn btn-light pull-right add_emp_inst_faculty_resource" type="button">+</button>
                                    <button class="btn btn-light pull-right rem_emp_inst_faculty_resource" type="button">-</button>
                                </div>
                        </fieldset>
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.timing'), ['class' => 'control-label']) !!}
                        <select name= "timing" class= "form-control select2 js-example-placeholder-single" required>
                            <option value ="Full Day">Full Day</option>
                            <option value ="Half Day">Half Day</option>
                        </select>
                        <br><br>
                        <div id="slot" class="d-none">
                            {!! Form::label('z',trans('labels.backend.crts.fields.slot'), ['class' => 'control-label']) !!}
                            <select name= "slot" class= "form-control select2 js-example-placeholder-single time_slot">
                                <option value ="">Choose</option>
                                <option value ="9:00 AM">9:00 AM</option>
                                <option value ="9:30 AM">9:30 AM</option>
                                <option value ="10:00 AM">10:00 AM</option>
                                <option value ="10:30 AM">10:30 AM</option>
                                <option value ="11:00 AM">11:00 AM</option>
                                <option value ="11:30 AM">11:30 AM</option>
                                <option value ="2:00 AM">2:00 AM</option>
                                <option value ="2:30 AM">2:30 AM</option>
                                <option value ="3:00 AM">3:00 AM</option>
                                <option value ="3:30 AM">3:30 AM</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.training_for'), ['class' => 'control-label']) !!}
                        <select name= "training_for" class= "form-control select2 js-example-placeholder-single" required>
                            <option value ="">Please Select</option>
                        </select>
                        <br><br>
                        {!! Form::label('z',trans('labels.backend.crts.fields.training_type'), ['class' => 'control-label']) !!}
                        {!! Form::select('training_type', $training_types, old('training_type'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    
                    <div class="col-12 col-lg-6 form-group">
                        <h4 class="page-title d-inline">{!! Form::label('z',trans('labels.backend.crts.fields.duration'), ['class' => 'control-label']) !!}</h4>
                        <br>
                        {!! Form::label('z',trans('labels.backend.crts.fields.startdate'), ['class' => 'control-label']) !!}
                        {!! Form::text('start_date', old('start_date'), ['class' => 'form-control date startDate',  'placeholder' => trans('labels.backend.courses.fields.start_date').' (Ex . 2019-01-01)', 'autocomplete' => 'off', 'required']) !!}
                        <br>
                        {!! Form::label('z',trans('labels.backend.crts.fields.enddate'), ['class' => 'control-label']) !!}
                        {!! Form::text('end_date', old('start_date'), ['class' => 'form-control date endDate', 'placeholder' => trans('labels.backend.courses.fields.start_date').' (Ex . 2019-01-01)', 'autocomplete' => 'off', 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        <br>
                        {!! Form::label('z',trans('labels.backend.crts.fields.lastnominne'), ['class' => 'control-label']) !!}
                        {!! Form::text('lastnominne', old('lastnominne'), ['class' => 'form-control date last_nomination', 'placeholder' => trans('labels.backend.courses.fields.start_date').' (Ex . 2019-01-01)', 'autocomplete' => 'off', 'required']) !!}
                        <br>
                        {!! Form::label('z',trans('labels.backend.crts.fields.nomintation_from_office'), ['class' => 'control-label']) !!}
                        {!! Form::select('nomintation_from_office[]', $office_location, old('office_location'), ['class' => 'form-control select2 js-example-placeholder-single nomintation_from_office', 'multiple' => true, 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.feedback'), ['class' => 'control-label']) !!}
                        {{ Form::checkbox('feedback', 'Good', ['class' => 'form-control ', 'required']) }}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2" name="status">
                            <option value="0">Save</option>
                            <option value="1">Save & Publish</option>
                        </select>
                    </div>
                </div><!--form-group-->	


                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.crt.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>
</div>
{{ html()->form()->close() }}

<script type="text/javascript">
    $(document).ready(function () {
        
        if($(".last_nomination").val() == ""){
            $('.startDate').prop('disabled', true);
            $('.endDate').prop('disabled', true);
        }else{
            $('.startDate').prop('disabled', false);
            $('.endDate').prop('disabled', false);
        }
        
        $(".crt_form").submit(function(e) {
            var title = $("input[name='title']").val();
            if(/^[a-zA-Z0-9- ]*$/.test(title) == false) {
                jQuery('.crt_form').before('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">X</span></button>Special Character are not allowed in Title.<br></div>');
                $("input[name='title']").focus();
                return false;
            }
            var description = $("textarea[name='description']").val();
            if(/^[a-zA-Z0-9- ]*$/.test(description) == false) {
                jQuery('.crt_form').before('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">X</span></button>Special Character are not allowed in Description.<br></div>');
                $("textarea[name='description']").focus();
                return false;
            }
            /*For Coordinator Validation*/
            var cooInternal = $("input[name='cooInternal[]']").map(function(){return $(this).val();}).get();
            var cooInstInd = $('select[name="cooExternal[\'instituteIndustry\'][]"]').map(function(){return $(this).val();}).get();
            var cooFaculty = $('select[name="cooExternal[\'faculty\'][]"]').map(function(){return $(this).val();}).get();
            
            var cooIntCnt = 0;
            $.each(cooInternal, function(cooInternalKey, cooInternalVal) {
                if(cooInternalVal == ""){
                    cooIntCnt = cooIntCnt + 1;
                }
            });
            var cooInstCnt = 0;
            $.each(cooInstInd, function(cooInstKey, cooInstVal) {
                if(cooInstVal == ""){
                    cooInstCnt = cooInstCnt + 1;
                }
            });
            var cooFacCnt = 0;
            $.each(cooFaculty, function(cooFacKey, cooFacVal) {
                if(cooFacVal == ""){
                    cooFacCnt = cooFacCnt + 1;
                }
            });
            
            if(cooIntCnt != 0 && cooInstCnt != 0 && cooFacCnt != 0){
                jQuery('.crt_form').before('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">X</span></button>Internal or External Coordinator must be require.<br></div>');
                return false;
            }
            
            
            /*For Resourse Person Validation*/
            var resInternal = $("input[name='resourceInternal[]']").map(function(){return $(this).val();}).get();
            var resInstInd = $('select[name="resourceExternal[\'instituteIndustry\'][]"]').map(function(){return $(this).val();}).get();
            var resFaculty = $('select[name="resourceExternal[\'faculty\'][]"]').map(function(){return $(this).val();}).get();
            
            var resIntCnt = 0;
            $.each(resInternal, function(resInternalKey, resInternalVal) {
                if(resInternalVal == ""){
                    resIntCnt = resIntCnt + 1;
                }
            });
            var resInstCnt = 0;
            $.each(resInstInd, function(resInstKey, resInstVal) {
                if(resInstVal == ""){
                    resInstCnt = resInstCnt + 1;
                }
            });
            var resFacCnt = 0;
            $.each(resFaculty, function(resFacKey, resFacVal) {
                if(resFacVal == ""){
                    resFacCnt = resFacCnt + 1;
                }
            });
            
            if(resIntCnt != 0 && resInstCnt != 0 && resFacCnt != 0){
                jQuery('.crt_form').before('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">X</span></button>Internal or External Resource Person must be require.<br></div>');
                return false;
            }
            
            
            /*Coordinator*/
            var cooInternal = $("input[name='cooInternal[]']").map(function(){return $(this).val();}).get();
            var cooArray = cooInternal.sort();
            var cooDuplicate = [];
            for (var i = 0; i < cooArray.length - 1; i++) {
                if (cooArray[i + 1] == cooArray[i]) {
                    cooDuplicate.push(cooArray[i]);
                }
            }
            if(cooDuplicate.length > 0){
                jQuery('.crt_form').before('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">X</span></button>The Employee Code must be unique.<br></div>');
                return false;
            }
            /*Resource Person*/
            var resourceInternal = $("input[name='resourceInternal[]']").map(function(){return $(this).val();}).get();
            var resourceArray = resourceInternal.sort();
            var resourceDuplicate = [];
            for (var i = 0; i < resourceArray.length - 1; i++) {
                if (resourceArray[i + 1] == resourceArray[i]) {
                    resourceDuplicate.push(resourceArray[i]);
                }
            }   
            if(resourceDuplicate.length > 0){
                jQuery('.crt_form').before('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>The Employee Code must be unique.<br></div>');
                return false;
            }
        });
        
        $("input[name='cooInternal[]']").keyup(function(){
            $(':input[type="submit"]').prop('disabled', false);
        });
        $("input[name='resourceInternal[]']").keyup(function(){
            $(':input[type="submit"]').prop('disabled', false);
        });
         $("input[name='title']").keyup(function(){
            $(':input[type="submit"]').prop('disabled', false);
        });
        $("textarea[name='description']").keyup(function(){
            $(':input[type="submit"]').prop('disabled', false);
        });
        
//        $('.date').datepicker({
//            autoclose: true,
//            dateFormat: "{{ config('app.date_format_js') }}"
//        }); 
        $('.last_nomination').datepicker({
            autoclose: true,
            minDate: 0,
            dateFormat: "{{ config('app.date_format_js') }}",
            onSelect: function(selected) {
                $('.startDate').prop('disabled', false);
                $('.endDate').prop('disabled', false);
                var dateObject=new Date(selected);
                dateObject.setDate(dateObject.getDate()+1);
                
                var day = dateObject.getDate();
                var month = dateObject.getMonth() + 1;
                var year = dateObject.getFullYear();
                var dt = year+"-"+month+"-"+day;
                
                $(".startDate").datepicker("option","minDate", dt)
                $(".endDate").datepicker("option","minDate", dt)
            }
        }); 
        
        $(".startDate").datepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}",
            numberOfMonths: 2,
            onSelect: function(selected) {
                $(".endDate").datepicker("option","minDate", selected)
            }
        });
        $(".endDate").datepicker({ 
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}",
            numberOfMonths: 2,
            onSelect: function(selected) {
            $(".startDate").datepicker("option","maxDate", selected)
            }
        });
        
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        
        $('select[name="nomintation_from_office[]"]').select2().on('change', function() {
            var officeArr = $(this).val();
            if(officeArr.length > 0){
                if(officeArr[0] == 0){
                    $(".nomintation_from_office > option").each(function() {
                        if(this.value != 0){
                            $(this).attr('disabled', 'disabled');
                        }
                    });
                }
                if(officeArr[0] != '0'){
                    $(".nomintation_from_office > option").each(function() {
                        if(this.value == 0){
                            $(this).attr('disabled', 'disabled');
                        }
                    });
                }
            }else{
                $(".nomintation_from_office > option").each(function() {
                        $(this).removeAttr("disabled");
                });
            }
            
//            $('.nomintation_from_office').select2({allowClear: false});
            
            setTimeout(function () {
                $('.nomintation_from_office').select2({allowClear: false});
            });
        });
        /*For Coordinator*/
        $('select[name="cooExternal[\'instituteIndustry\'][]"]').on('change', function() {
            
            $(':input[type="submit"]').prop('disabled', false);
            var insIndId = $(this).val();
            
            var test =$(this).next().next();
            if(insIndId) {
                $.ajax({
                    url: 'faculty-ajax/'+insIndId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        var facultyHtml = '<option value="">Please select</option>'; 
                        $.each(data, function(key, val) {
                            facultyHtml += '<option value="'+ key +'">'+ val +'</option>';
                        });
                        test.html(facultyHtml);
                        test.prop('required',true);
                    }
                });
            }
        });
        /*For Resource Person*/
        $('select[name="resourceExternal[\'instituteIndustry\'][]"]').on('change', function() {
            var insIndId = $(this).val();
            $(':input[type="submit"]').prop('disabled', false);
            var test =$(this).next().next();
            if(insIndId) {
                $.ajax({
                    url: 'faculty-ajax/'+insIndId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        var facultyHtml = '<option value="">Please select</option>'; 
                        $.each(data, function(key, val) {
                            facultyHtml += '<option value="'+ key +'">'+ val +'</option>';
                        });
                        test.html(facultyHtml);
                        test.prop('required',true);
                    }
                });
            }
        });
        
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
                        var trackHtml = '<option value="">Please select</option>';
                        var yearHtml = '<option value="">Please select</option>';
                        var venuesHtml = '<option value="">Please select</option>';
                        var levelHtml = '<option value="">Please select</option>';
                        var institute_industryHtml = '<option value="">Please select</option>';
//                        var facultyHtml = '<option value="">Please select</option>';
                        var training_typesHtml = '<option value="">Please select</option>';
                        var office_locationHtml = '<option value="">Please select</option>';
                        //                        $('select[name="office_id"]').empty();
                        $.each(data, function(stdkey, stdValue) {
                            $.each(stdValue, function(key, val) {
                                if(stdkey == "tracks"){
                                    trackHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                                if(stdkey == "years"){
                                    yearHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                                if(stdkey == "venues"){
                                    venuesHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                                if(stdkey == "level"){
                                    levelHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                                if(stdkey == "institute_industry"){
                                    institute_industryHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                                if(stdkey == "faculty"){
//                                    facultyHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                                if(stdkey == "training_types"){
                                    training_typesHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                                if(stdkey == "office_location"){
                                    office_locationHtml += '<option value="'+ key +'" class="nomination_office">'+ val +'</option>';
                                }
                            });
                            
                        });
                        $('select[name="track_id"]').html(trackHtml);
                        $('select[name="year_id"]').html(yearHtml);
                        $('select[name="venue_id"]').html(venuesHtml);
                        $('select[name="designation_id[]"]').html(levelHtml);
                        $('select[name="cooExternal[\'instituteIndustry\'][]"]').html(institute_industryHtml);
//                        $('select[name="cooExternal[\'faculty\'][]"]').html(facultyHtml);
                        $('select[name="resourceExternal[\'instituteIndustry\'][]"]').html(institute_industryHtml);
//                        $('select[name="resourceExternal[\'faculty\'][]"]').html(facultyHtml);
                        $('select[name="training_type"]').html(training_typesHtml);
                        $('select[name="nomintation_from_office[]"]').html(office_locationHtml);


                    }
                });
            }else{
                $('select[name="office_id"]').empty();
            }
        });

        $('select[name="track_id"]').on('change', function() {
            var trackID = $(this).val();
            if(trackID) {
                $.ajax({
                    url: 'category-ajax/'+trackID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        var categoryHtml = '<option value="">Please select</option>';
                            $.each(data, function(key, val) {
                                categoryHtml += '<option value="'+ key +'">'+ val +'</option>';
                            });
                        $('select[name="category_id"]').html(categoryHtml);
                    }
                });
            }
        });
        
        $('select[name="state_id"]').on('change', function() {
            var stateID = $(this).val();
            if(stateID) {
                $.ajax({
                    url: 'city-ajax/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        var cityHtml = '<option value="">Please select</option>';
                            $.each(data, function(key, val) {
                                cityHtml += '<option value="'+ key +'">'+ val +'</option>';
                            });
                        $('select[name="city_id"]').html(cityHtml);
                    }
                });
            }
        });
        
        $('select[name="timing"]').on('change', function() {
            var timing = $(this).val();
            if(timing == "Half Day"){
                $(".time_slot").attr("required", "true");
                $("#slot").removeClass('d-none');
            }else{
                $(".time_slot").removeAttr("required");
                $("#slot").addClass('d-none');                
            }
        });
        
        /*Coordinator*/
        $(".add_emp_code").on('click', function(){
            var ele = $(this).closest('.employee_code').clone(true);
            $(this).closest('.employee_code').after(ele);
            
            if($('.employee_code').length == 1){
                $(".rem_emp_code").addClass('d-none')
            }else{
                $(".rem_emp_code").removeClass('d-none')
            }
        });
        $(".add_emp_inst_faculty").on('click', function(){
            var ele = $(this).closest('.employee_inst_faculty').clone(true);
            $(this).closest('.employee_inst_faculty').after(ele);
            
            if($('.employee_inst_faculty').length == 1){
                $(".rem_emp_inst_faculty").addClass('d-none')
            }else{
                $(".rem_emp_inst_faculty").removeClass('d-none')
            }
            
        });
        $(".rem_emp_code").on('click', function(){ 
            $(this).closest('.employee_code').remove();
            
            if($('.employee_code').length == 1){
                $(".rem_emp_code").addClass('d-none')
            }else{
                $(".rem_emp_code").removeClass('d-none')
            }
        });
        $(".rem_emp_inst_faculty").on('click', function(){
            $(this).closest('.employee_inst_faculty').remove();
            
            if($('.employee_inst_faculty').length == 1){
                $(".rem_emp_inst_faculty").addClass('d-none')
            }else{
                $(".rem_emp_inst_faculty").removeClass('d-none')
            }
        });
        /*Resource*/
        $(".add_emp_code_resource").on('click', function(){
            var ele = $(this).closest('.employee_code_resource').clone(true);
            $(this).closest('.employee_code_resource').after(ele);
            
            if($('.employee_code_resource').length == 1){
                $(".rem_emp_code_resource").addClass('d-none')
            }else{
                $(".rem_emp_code_resource").removeClass('d-none')
            }
        });
        $(".add_emp_inst_faculty_resource").on('click', function(){
            var ele = $(this).closest('.employee_inst_faculty_resource').clone(true);
            $(this).closest('.employee_inst_faculty_resource').after(ele);
            
            if($('.employee_inst_faculty_resource').length == 1){
                $(".rem_emp_inst_faculty_resource").addClass('d-none')
            }else{
                $(".rem_emp_inst_faculty_resource").removeClass('d-none')
            }
        });
        $(".rem_emp_code_resource").on('click', function(){
            $(this).closest('.employee_code_resource').remove();
            
            if($('.employee_code_resource').length == 1){
                $(".rem_emp_code_resource").addClass('d-none')
            }else{
                $(".rem_emp_code_resource").removeClass('d-none')
            }
        });
        $(".rem_emp_inst_faculty_resource").on('click', function(){
            $(this).closest('.employee_inst_faculty_resource').remove();
            
            if($('.employee_inst_faculty_resource').length == 1){
                $(".rem_emp_inst_faculty_resource").addClass('d-none')
            }else{
                $(".rem_emp_inst_faculty_resource").removeClass('d-none')
            }
        });
        
        var login_user_id = $("#login_user_id").val();
            if(login_user_id) {
                $.ajax({
                    url: 'training_for-ajax/'+login_user_id,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        var typeForHtml = '<option value="">Please select</option>';
                            $.each(data, function(key, val) {
                                typeForHtml += '<option value="'+ val +'">'+ val +'</option>';
                            });
                        $('select[name="training_for"]').html(typeForHtml);
                    }
                });
            }
	if($('.employee_code').length == 1){
            $(".rem_emp_code").addClass('d-none')
        }else{
            $(".rem_emp_code").removeClass('d-none')
        }
	
	if($('.employee_code_resource').length == 1){
            $(".rem_emp_code_resource").addClass('d-none')
        }else{
            $(".rem_emp_code_resource").removeClass('d-none')
        }	
	if($('.employee_inst_faculty').length == 1){
            $(".rem_emp_inst_faculty").addClass('d-none')
        }else{
            $(".rem_emp_inst_faculty").removeClass('d-none')
        }	
	if($('.employee_inst_faculty_resource').length == 1){
            $(".rem_emp_inst_faculty_resource").addClass('d-none')
        }else{
            $(".rem_emp_inst_faculty_resource").removeClass('d-none')
        }	
    });
    
</script>
@endsection
