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
{{ html()->modelForm($crttrainings, 'PATCH', route('admin.crt.update', $crttrainings->id))->class('form-horizontal crt_form')->acceptsFiles()->open() }}
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.crts.edit')</h3>
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
                        <?php $selectedID = 3;
                        ?>
                        <input type="hidden" id="login_user_id" value="{{$logged_in_user->id}}">
                        <input type="hidden" id="main_id" value="{{$crttrainings->id}}">
                        <input type="hidden" id="category_id" value="{{$crttrainings->categoryId}}">
                        <input type="hidden" id="training_for_id" value="{{$crttrainings->training_for}}">
                        <input type="hidden" id="training_type_id" value="{{$crttrainings->training_type}}">


                        {!! Form::label('z',trans('labels.backend.crts.fields.department_id'), ['class' => 'control-label require']) !!} 
                        <div>
                            {!! Form::select('department_id', $department,$crttrainings->deptid,['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                        </div>

                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.track_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('track_id', $tracks,$crttrainings->trackid, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.category_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('category_id',$category, $crttrainings->categoryid, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.year_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('year_id', $years,$crttrainings->yearid,['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.state_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('state_id', $states,$crttrainings->stateid, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.city_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('city_id', $cities,$crttrainings->cityid,  ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.venue_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('venue_id', $venues,$crttrainings->venuid, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.designation'), ['class' => 'control-label require']) !!}
                        {!! Form::select('designation_id[]', $designations,$crt_designation, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => true, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.title'), ['class' => 'control-label require']) !!}
                        {!! Form::text('title',$crttrainings->title, ['class' => 'form-control','placeholder' => trans('labels.backend.lessons.slug_placeholder'), 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.description'), ['class' => 'control-label require']) !!}
                        {!! Form::textarea('description', $crttrainings->description,  ['class' => 'form-control','rows' => 4, 'cols' => 54, 'placeholder' => trans('labels.backend.lessons.slug_placeholder'), 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        <h4 class="page-title d-inline">{!! Form::label('z',trans('labels.backend.crts.fields.coordinator'), ['class' => 'control-label']) !!}</h4>
                        <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Internal Coordinator</legend>
                                @foreach ($coordinator as $cd)
                                @if ($cd->internalexternal == 0)
                                <div class="employee_code">
                                    {!! Form::label('z',trans('labels.backend.crts.fields.empcode'), ['class' => 'control-label']) !!}
                                    <input class="form-control" placeholder="Enter Employee Code" name="cooInternal[]" type="text" value="{{ $cd->emp_code }}">
                                    <button class="btn btn-light pull-right add_emp_code" type="button">+</button>
                                    <button class="btn btn-light pull-right rem_emp_code" type="button">-</button>
                                </div>
                                @endif
                                @endforeach
                        </fieldset>
                        <fieldset class="scheduler-border">
                                <legend class="scheduler-border">External Coordinator</legend>
                                @foreach ($coordinator as $cd)
                                @if ($cd->internalexternal == 1)
                                <div class="employee_inst_faculty ">
                                    {!! Form::label('z',trans('labels.backend.crts.fields.instituteIndustry'), ['class' => 'control-label']) !!}
                                    {!! Form::select("cooExternal['instituteIndustry'][]", $instituteIndustry ,$cd->inst_ind_id, ['class' => 'form-control js-example-placeholder-single', 'multiple' => false]) !!}
        <!--                            <br>-->
                                    {!! Form::label('z',trans('labels.backend.crts.fields.faculty'), ['class' => 'control-label']) !!}
                                    @if($cd->inst_ind_id != "")
                                    {!! Form::select("cooExternal['faculty'][]", $cooFacultyArr[$cd->inst_ind_id] ,$cd->faculty_id, ['class' => 'form-control js-example-placeholder-single', 'multiple' => false ,'required']) !!}
                                    @else
                                    {!! Form::select("cooExternal['faculty'][]", $cooFacultyArr[$cd->inst_ind_id] ,$cd->faculty_id, ['class' => 'form-control js-example-placeholder-single', 'multiple' => false]) !!}
                                    @endif
                                    <button class="btn btn-light pull-right add_emp_inst_faculty" type="button">+</button>
                                    <button class="btn btn-light pull-right rem_emp_inst_faculty" type="button">-</button>
                                </div>
                                @endif
                                @endforeach
                        </fieldset>
                        
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <h4 class="page-title d-inline">{!! Form::label('z',trans('labels.backend.crts.fields.resourceperson'), ['class' => 'control-label']) !!}
                        </h4>
                        <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Internal Resource Person</legend>
                                @foreach ($resource as $rc)
                                @if ($rc->internalexternal == 0)
                                <div class="employee_code_resource">
                                    {!! Form::label('z',trans('labels.backend.crts.fields.empcode'), ['class' => 'control-label']) !!}
                                    <input class="form-control" placeholder="Enter Employee Code" name="resourceInternal[]" type="text" value="{{ $rc->emp_code }}" >
                                    <button class="btn btn-light pull-right add_emp_code_resource" type="button">+</button>
                                    <button class="btn btn-light pull-right rem_emp_code_resource" type="button">-</button>
                                </div>
                                @endif
                                @endforeach
                        </fieldset>
                        <fieldset class="scheduler-border">
                                <legend class="scheduler-border">External Resource Person</legend>
                                @foreach ($resource as $rc)
                                @if ($rc->internalexternal == 1)
                                <div class="employee_inst_faculty_resource">
                                    {!! Form::label('z',trans('labels.backend.crts.fields.instituteIndustry'), ['class' => 'control-label']) !!}
                                    {!! Form::select("resourceExternal['instituteIndustry'][]", $instituteIndustry ,$rc->inst_ind_id, ['class' => 'form-control js-example-placeholder-single', 'multiple' => false]) !!}
                                    {!! Form::label('z',trans('labels.backend.crts.fields.faculty'), ['class' => 'control-label']) !!}
                                    @if($rc->inst_ind_id != "")
                                    {!! Form::select("resourceExternal['faculty'][]", $recFacultyArr[$rc->inst_ind_id] ,$rc->faculty_id, ['class' => 'form-control js-example-placeholder-single', 'multiple' => false,'required']) !!}
                                    @else
                                    {!! Form::select("resourceExternal['faculty'][]", $recFacultyArr[$rc->inst_ind_id] ,$rc->faculty_id, ['class' => 'form-control js-example-placeholder-single', 'multiple' => false]) !!}
                                    @endif
                                    <button class="btn btn-light pull-right add_emp_inst_faculty_resource" type="button">+</button>
                                    <button class="btn btn-light pull-right rem_emp_inst_faculty_resource" type="button">-</button>
                                </div>
                                @endif
                                @endforeach
                        </fieldset>
                        
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.timing'), ['class' => 'control-label']) !!}

                        <select name= "timing" class= "form-control select2 js-example-placeholder-single" required>
                            <option {{old('timing',$crttrainings->timing)=="Half Day"? 'selected':''}}  value="Half Day">Half Day</option>
                            <option {{old('timing',$crttrainings->timing)=="Full Day"? 'selected':''}} value="Full Day">Full Day</option>
                        </select>
                        <br><br>
                        <div id="slot" class="d-none">
                            {!! Form::label('z',trans('labels.backend.crts.fields.slot'), ['class' => 'control-label']) !!}
                            <select name= "slot" class= "form-control select2 js-example-placeholder-single time_slot" required>
                                <option value ="">Choose</option>
                                <option value ="9:00 AM" {{old('slot',$crttrainings->slot)=="9:00 AM"? 'selected':''}} >9:00 AM</option>
                                <option value ="9:30 AM" {{old('slot',$crttrainings->slot)=="9:30 AM"? 'selected':''}}>9:30 AM</option>
                                <option value ="10:00 AM" {{old('slot',$crttrainings->slot)=="10:00 AM"? 'selected':''}}>10:00 AM</option>
                                <option value ="10:30 AM" {{old('slot',$crttrainings->slot)=="10:30 AM"? 'selected':''}}>10:30 AM</option>
                                <option value ="11:00 AM" {{old('slot',$crttrainings->slot)=="11:00 AM"? 'selected':''}}>11:00 AM</option>
                                <option value ="11:30 AM" {{old('slot',$crttrainings->slot)=="11:30 AM"? 'selected':''}}>11:30 AM</option>
                                <option value ="2:00 AM" {{old('slot',$crttrainings->slot)=="2:00 AM"? 'selected':''}}>2:00 AM</option>
                                <option value ="2:30 AM" {{old('slot',$crttrainings->slot)=="2:30 AM"? 'selected':''}}>2:30 AM</option>
                                <option value ="3:00 AM" {{old('slot',$crttrainings->slot)=="3:00 AM"? 'selected':''}}>3:00 AM</option>
                                <option value ="3:30 AM" {{old('slot',$crttrainings->slot)=="3:30 AM"? 'selected':''}}>3:30 AM</option>
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
                        {!! Form::select('training_type', $training_types, $crttrainings->training_type, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false , 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        <h4 class="page-title d-inline">{!! Form::label('z',trans('labels.backend.crts.fields.duration'), ['class' => 'control-label']) !!}</h4>
                        <br>
                        {!! Form::label('z',trans('labels.backend.crts.fields.startdate'), ['class' => 'control-label']) !!}
                        {!! Form::text('start_date', $crttrainings->startdate, ['class' => 'form-control date startDate','pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.courses.fields.start_date').' (Ex . 2019-01-01)', 'autocomplete' => 'off', 'required']) !!}
                        <br>
                        {!! Form::label('z',trans('labels.backend.crts.fields.enddate'), ['class' => 'control-label']) !!}
                        {!! Form::text('end_date',$crttrainings->enddate,['class' => 'form-control date endDate','pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.courses.fields.start_date').' (Ex . 2019-01-01)', 'autocomplete' => 'off', 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.lastnominne'), ['class' => 'control-label']) !!}
                        {!! Form::text('lastnominne', $crttrainings->lastnominne, ['class' => 'form-control date last_nomination','pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.courses.fields.start_date').' (Ex . 2019-01-01)', 'autocomplete' => 'off', 'required', 'required']) !!}
                        <br>
                        {!! Form::label('z',trans('labels.backend.crts.fields.nomintation_from_office'), ['class' => 'control-label']) !!}
                        
                        
                        <select class="form-control select2 js-example-placeholder-single nomintation_from_office select2-hidden-accessible" multiple="" required="" name="nomintation_from_office[]" tabindex="-1" aria-hidden="true">
                            @foreach($office_location as $key=>$item)
                                <?php
                                $select = '';
                                if(in_array($key, $nomination_office)){
                                    $select = 'selected="selected"';
                                }
                                if(in_array("0", $nomination_office)){
                                    if($key != 0){
                                        $disabled = 'disabled="disabled"';
                                    }else{
                                        $disabled = '';
                                    }
                                }else{
                                    if($key == 0){
                                        $disabled = 'disabled="disabled"';
                                    }else{
                                        $disabled = '';
                                    }
                                }
                                
                                ?>
                                <option value="{{$key}}" {{$select}} {{$disabled}}>{{$item}}</option>
                            @endforeach
                        </select>
                        
                        
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.crts.fields.feedback'), ['class' => 'control-label']) !!}
                        {{ Form::checkbox('feedback', 'Good', ['class' => 'form-control ']) }}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0" {{old('status',$crttrainings->status)=="0"? 'selected':''}}>Save</option>
                            <option value="1" {{old('status',$crttrainings->status)=="1"? 'selected':''}}>Save & Publish</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-12 form-group">
                        <div class="form-group row justify-content-center">
                            <div class="col-4">
                                {{ form_cancel(route('admin.crt.index'), __('buttons.general.cancel')) }}
                                {{ form_submit(__('buttons.general.crud.update')) }}
                            </div>
                        </div><!--col-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        
//        var office = $("input[name='nomintation_from_office[]']").map(function(){return $(this).val();}).get();
        if($("#slot").hasClass("d-none")){
           var timing = $('select[name="timing"]').val();
            if(timing == "Half Day"){
                $(".time_slot").attr("required", "true");
                $("#slot").removeClass('d-none');
            }else{
                    $(".time_slot").removeAttr("required");
                    $("#slot").addClass('d-none');                
            }
        }
        
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
            minDate: new Date($(".last_nomination").val()),
            dateFormat: "{{ config('app.date_format_js') }}",
            numberOfMonths: 2,
            onSelect: function(selected) {
                $(".endDate").datepicker("option","minDate", selected)
            }
        });
        $(".endDate").datepicker({ 
            autoclose: true,
            minDate: new Date($(".last_nomination").val()),
            dateFormat: "{{ config('app.date_format_js') }}",
            numberOfMonths: 2,
            onSelect: function(selected) {
                $(".startDate").datepicker("option","maxDate", selected)
            }
        });
        
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var APP_URL = {!! json_encode(url('/')) !!};        
        
        $('select[name="nomintation_from_office[]"]').on('change', function() {
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
            
            setTimeout(function () {
                $('.nomintation_from_office').select2({allowClear: false});
            });
        });
        
        /*For Coordinator*/
        $('select[name="cooExternal[\'instituteIndustry\'][]"]').on('change', function() {
            var insIndId = $(this).val();
            $(':input[type="submit"]').prop('disabled', false);
            var test =$(this).next().next();
            if(insIndId) {
                $.ajax({
                    url: APP_URL+'/user/crt/faculty-ajax/'+insIndId,
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
                    url: APP_URL+'/user/crt/faculty-ajax/'+insIndId,
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
        $('select[name="department_id"]').on('change', function() {
            var departmentID = $(this).val();
            //alert(departmentID); exit;
            if(departmentID) {
                $.ajax({
                    url: APP_URL+'/user/crt/office-ajax/'+departmentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        var trackHtml = '<option value="">Please select</option>';
                        var yearHtml = '<option value="">Please select</option>';
                        var venuesHtml = '<option value="">Please select</option>';
                        var levelHtml = '<option value="">Please select</option>';
                        var institute_industryHtml = '<option value="">Please select</option>';
                        var facultyHtml = '<option value="">Please select</option>';
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
                                    facultyHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                                if(stdkey == "training_types"){
                                    training_typesHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                                if(stdkey == "office_location"){
                                    office_locationHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                            });

                        });
                        $('select[name="track_id"]').html(trackHtml);
                        $('select[name="year_id"]').html(yearHtml);
                        $('select[name="venue_id"]').html(venuesHtml);
                        $('select[name="designation_id"]').html(levelHtml);
                        $('select[name="cooExternal[\'instituteIndustry\'][]"]').html(institute_industryHtml);
                        $('select[name="cooExternal[\'faculty\'][]"]').html(facultyHtml);
                        $('select[name="resourceExternal[\'instituteIndustry\'][]"]').html(institute_industryHtml);
                        $('select[name="resourceExternal[\'faculty\'][]"]').html(facultyHtml);
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
                    //                        url: 'category-ajax/'+trackID,
                    url: APP_URL+'/user/crt/category-ajax/'+trackID,
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
            
        /*For Category*/
        var trackID = $('select[name="track_id"]').val();
        if(trackID) {
            $.ajax({
                //                        url: 'category-ajax/'+trackID,
                url: APP_URL+'/user/crt/category-ajax/'+trackID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    //  alert(data); exit;
                    var catId = $("#category_id").val();
                    var categoryHtml = '<option value="">Please select</option>';
                    $.each(data, function(key, val) {
                        selected = "";
                        if(key == catId){
                            var selected = 'selected="selected"';
                        }
                        categoryHtml += '<option value="'+ key +'" '+ selected +'>'+ val +'</option>';
                    });
                    $('select[name="category_id"]').html(categoryHtml);
                }
            });
        }
        
        $('select[name="state_id"]').on('change', function() {
            var stateID = $(this).val();
            if(stateID) {
                $.ajax({
                    //                    url: 'city-ajax/'+stateID,
                    url: APP_URL+'/user/crt/city-ajax/'+stateID,
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
        
        var login_user_id = $("#login_user_id").val();
        if(login_user_id) {
            $.ajax({
                //                    url: 'training_for-ajax/'+login_user_id,
                url: APP_URL+'/user/crt/training_for-ajax/'+login_user_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    //  alert(data); exit;
                    var typeForHtml = '<option value="">Please select</option>';
                    $.each(data, function(key, val) {
                        var tf = $("#training_for_id").val();
                        var selected = "";
                        if(val == tf){
                            var selected = "selected='selected'";
                        }
                        typeForHtml += '<option value="'+ val +'" '+ selected +'>'+ val +'</option>';
                    });
                    $('select[name="training_for"]').html(typeForHtml);
                }
            });
        }
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
        
        /*For Slot*/
        
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
        var timing1 = $('select[name="timing"]').val();
        if(timing1 == "Half Day"){
            $("#slot").removeClass('d-none');
        }else{
            $("#slot").addClass('d-none');                
        }
        
    });
</script>
{{ html()->closeModelForm() }}
@endsection
