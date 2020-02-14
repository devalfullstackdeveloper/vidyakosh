@extends('backend.layouts.app')
@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.create'))
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

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
	<div class="col">
	    <div class="form-group row">
	    	<div class="col-12 col-lg-6 form-group">
            {!! Form::label('ministry_id',trans('labels.backend.access.users.tabs.content.profile.fname'), ['class' => 'control-label']) !!}
            <div>
               {{ html()->text('first_name')
                ->class('form-control')
                ->placeholder(__('labels.backend.access.users.tabs.content.profile.fname'))
                ->attribute('maxlength', 191)
                ->value($result->first_name)
                ->readonly()
                }}
            </div>
        </div>
        <div class="col-12 col-lg-6 form-group">
            {!! Form::label('ministry_id',trans('labels.backend.access.users.tabs.content.profile.lname'), ['class' => 'control-label']) !!}
            <div>
               {{ html()->text('last_name')
                ->class('form-control')
                ->placeholder(__('labels.backend.access.users.tabs.content.profile.lname'))
                ->attribute('maxlength', 191)
                ->value($result->last_name)
                ->readonly()
                }}
            </div>
        </div>
        <div class="col-12 col-lg-6 form-group">
            {!! Form::label('ministry_id',trans('labels.backend.access.users.tabs.content.profile.email'), ['class' => 'control-label']) !!}
            <div>
               {{ html()->text('email')
                ->class('form-control')
                ->placeholder(__('labels.backend.access.users.tabs.content.profile.lname'))
                ->attribute('maxlength', 191)
                ->value($result->email)
                ->readonly()
                }}
            </div>
        </div>
	    </div>
	</div>
{{ html()->form('POST', route('admin.auth.user.updateuser'))->class('form-horizontal')->open() }}
<div class="col">
    <div class="form-group row">
        <div class="col-12 col-lg-6 form-group">
            {!! Form::label('ministry_id',trans('labels.backend.designations.fields.ministry_id'), ['class' => 'control-label']) !!}
            {!! Form::select('ministry_id', $ministry, old('ministry'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false]) !!}
        </div>
        <div class="col-12 col-lg-6 form-group">
            <label class="control-label">@lang('labels.backend.designations.fields.department_id')</label>
            <select class="form-control select2"  name="department_id">
                <option value="">Please Select</option>
            </select>
        </div>
        <div class="col-12 col-lg-6 form-group">
            <label class="control-label">@lang('labels.backend.designations.fields.office_id')</label>
            <select class="form-control select2" name="office_id">
                <option value="">Please Select</option>  
            </select>
            
        </div>
         <div class="col-12 col-lg-6 form-group">
                <label class="control-label">@lang('labels.backend.designations.fields.designation')</label>
                <select class="form-control select2"  name="designation_id">
                    <option value="">Please Select</option>  
                </select>
         </div> 
         <div class="col-12 col-lg-6 form-group">
            {!! Form::label('reportingmanager_id',trans('labels.backend.designations.fields.reportingmanager_id'), ['class' => 'control-label']) !!}
            <select class="form-control select2"  name="reportingmanager_id">
                <option value="">Please Select</option>  
            </select>
            
        </div>
        <div class="col-12 col-lg-6 form-group">
            {!! Form::label('organisationaldept_id',trans('labels.backend.designations.fields.organisationaldept_id'), ['class' => 'control-label']) !!}
            <select class="form-control select2"  name="organisationaldept_id">
                <option value="">Please Select</option>  
            </select>
            
        </div>  
        <div class="col-12 col-lg-6 form-group">
            {!! Form::label('organisationaldept_role',trans('labels.backend.designations.fields.organisationaldept_role'), ['class' => 'control-label']) !!}
            <select class="form-control select2"  name="organisationaldept_role">
                <option value="">Please Select</option>  
            </select>
            
        </div>
             
    </div>
    <div class="card-footer clearfix">
                <div class="row">
                    <div class="col">
                        
                    </div><!--col-->

                    <div class="col text-align-center">
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div><!--col-->
                </div><!--row-->
            </div>
    </div><!--card-->
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
                          //alert(data); exit;
                          //console.log(data);
                        $('select[name="department_id"]').empty();
                        $("<option value='-1'>Please select</option>").appendTo('select[name="department_id"]');
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
                        console.log(data);
                          //alert(data.tracks); 
                        var trackHtml = '<option value="">Please select</option>';
                        var locationsHtml = '<option value="">Please select</option>';
                        var orgdeptHtml = '<option value="">Please select</option>';
                        var orgroleHtml = '<option value="">Please select</option>';
                        var designationHtml = '<option value="">Please select</option>';
                        $('select[name="office_id"]').empty();
                        $('select[name="track_id[]"]').empty();
                        $('select[name="organisationaldept_id"]').empty();
                        $('select[name="organisationaldept_id"]').empty();
                        $('select[name="designation_id"]').empty();
                        $.each(data, function(stdkey, stdValue) {
                            $.each(stdValue, function(key, val) {
                                
                                if(stdkey == "locations"){
                                    locationsHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                                if(stdkey == "tracks"){
                                    trackHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                                 if(stdkey == "deptorg"){
                                    orgdeptHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                                if(stdkey == "deptrole"){
                                    orgroleHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                                if(stdkey == "designation"){
                                    designationHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                            });
                        });
                        
                        $('select[name="office_id"]').html(locationsHtml);
                        $('select[name="track_id[]"]').html(trackHtml);
                        $('select[name="organisationaldept_id"]').html(orgdeptHtml);
                        $('select[name="organisationaldept_role"]').html(orgroleHtml);
                        $('select[name="designation_id"]').html(designationHtml);

                    }
                });
            }else{
                $('select[name="office_id"]').empty();
                $('select[name="track_id[]"]').empty();
                $('select[name="organisationaldept_id"]').empty();
                $('select[name="organisationaldept_role"]').empty();
                $('select[name="designation_id"]').empty();
            }
        });	
		
		
		  $('select[name="office_id"]').on('change', function() {
            var officeID = $(this).val();
			var departmentID = $('select[name="department_id"]').val();
            //alert(departmentID); exit;
            if(officeID) {
                $.ajax({
                    url: 'designation-ajax/'+officeID+"/"+departmentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        var designationHtml = '<option value="">Please select</option>';
                        var userHtml = '<option value="">Please select</option>';
                        //$('select[name="designation_id"]').empty();
                        $('select[name="reportingmanager_id"]').empty();
                        $.each(data, function(stdkey, stdValue) {
                            $.each(stdValue, function(key, val) {
                                
                                if(stdkey == "designation"){
                                    designationHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                                if(stdkey == "user"){
                                    userHtml += '<option value="'+ key +'">'+ val +'</option>';
                                }
                            });
                        });
                        
                        $('select[name="designation_id"]').html(designationHtml);
                        $('select[name="reportingmanager_id"]').html(userHtml);

                    }
                });
            }else{
                $('select[name="designation_id"]').empty();
                $('select[name="reportingmanager_id"]').empty();
            }
        });	
	       
           $('select[name="is_admin"]').on('change', function() {
                var isAdmin = $(this).val();

                if(isAdmin == 1){
                    $('#TrackDiv').css( "display", "block" );
                }else{
                    $('#TrackDiv').css( "display", "none" );
                }
           });
		
    });
</script>
@endsection