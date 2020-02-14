@extends('backend.layouts.app')

@section('title', __('labels.backend.years.title').' | '.app_name())
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
{{ html()->form('POST', route('admin.year.store'))->acceptsFiles()->class('form-horizontal')->open() }}
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.years.create')</h3>
        <div class="float-right">
            <a href="{{ route('admin.year.index') }}"
               class="btn btn-success">@lang('labels.backend.years.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">

                <div class="form-group row">  
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.years.fields.department_id'), ['class' => 'control-label']) !!}
                        {!! Form::select('department_id', $department, old('department'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <!--                        {{ html()->label(__('labels.backend.years.fields.name'))->class('form-control-label')->for('name') }}
                                                {{ html()->text('name')
                                                ->class('form-control')
                                                ->placeholder(__('labels.backend.years.fields.name'))
                                                ->attribute('maxlength', 500)
                                                ->required()
                                                ->autofocus() }} -->
                        {{ html()->label(__('labels.backend.years.fields.name'))->class('form-control-label')->for('name') }}
                        <select class="form-control select2 js-example-placeholder-single select2-hidden-accessible year" name="name" id="year_select" tabindex="-1" aria-hidden="true" required>
                            <option value="" selected="selected">Please select</option>
                            <option value="Financial year">Financial year</option>
                            <option value="Calender year">Calender year</option>
                        </select>

                    </div> 

                    <div class="col-12 col-lg-6 form-group year_1">
                        {{ html()->label(__('labels.backend.years.fields.year'))->class('form-control-label')->for('year') }}
                        {{ html()->text('year')
                        ->class('form-control yearpicker')
                        ->placeholder(__('labels.backend.years.fields.year'))
                        ->attribute('maxlength', 500)
                        ->required()
                        ->autofocus() }} 

                    </div> 
                    <div class="col-12 col-lg-6 form-group year_2 d-none"> 
                        <label class="form-control-label" for="year">Year</label>
                        <input class="form-control" type="text" name="year2" id="year2" placeholder="Year" maxlength="500" required autofocus="" autocomplete="off">

                    </div> 

                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0">Save</option>
                            <option value="1">Save & Publish</option>
                        </select>
                    </div>
                </div><!--form-group-->	


                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.year.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>
</div>
{{ html()->form()->close() }}
<script src="{{asset('assets/plugins/YearPicker/yearpicker.js')}}"></script>
<script>
    var jq = jQuery.noConflict();
      jq(document).ready(function() {
        //  alert("here");
        jq("#year").yearpicker({
          year: 2019,
          startYear: 2019,
          endYear: 2030
        });
        jq("#year2").yearpicker({
          year: 2019,
          startYear: 2019,
          endYear: 2030
        });
      });
    </script>
<script type="text/javascript">
    jq(document).ready(function() {
        jq('select[name="ministry_id"]').on('change', function() {
            var ministryID = jq(this).val();
            //alert(ministryID); exit;
            if(ministryID) {
                jq.ajax({
                    url: 'department-ajax/'+ministryID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        
                        jq('select[name="department_id"]').empty();
                        jq.each(data, function(key, value) {
                            $('select[name="department_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });


                    }
                });
            }else{
                jq('select[name="department_id"]').empty();
            }
        });
				
		
        jq('select[name="department_id"]').on('change', function() {
            var departmentID = $(this).val();
            //alert(departmentID); exit;
            if(departmentID) {
                jq.ajax({
                    url: 'office-ajax/'+departmentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        
                        jq('select[name="office_id"]').empty();
                        jq.each(data, function(key, value) {
                            jq('select[name="office_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });


                    }
                });
            }else{
                jq('select[name="office_id"]').empty();
            }
        });	
        
        $('#year_select').on('change', function() {
       
            var year = $(this).val();
                
            if(year == "Financial year"){
                $(".year_2").removeClass('d-none');
            }else{
                $(".year_2").addClass('d-none');
            }
        });
	
//        $('#year').datepicker( {
//            yearRange: "-100:+20",
//            changeMonth: false,
//            changeYear: true,
//            showButtonPanel: true,
//            closeText:'Select',
//            currentText: 'This year',
//            onClose: function(dateText, inst) {
//                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
//                $(this).val($.datepicker.formatDate("yy", new Date(year, 0, 1)));
//            },
//            beforeShow: function(input, inst){
//                if ($(this).val()!=''){
//                    var tmpyear = $(this).val();
//                    $(this).datepicker('option','defaultDate',new Date(tmpyear, 0, 1));
//                }
//            }
//        }).focus(function () {
//            $(".ui-datepicker-month").hide();
//            $(".ui-datepicker-calendar").hide();
//            $(".ui-datepicker-current").hide();
//            /*$(".ui-datepicker-close").hide();*/
//            $(".ui-datepicker-prev").hide();
//            $(".ui-datepicker-next").hide();
//            $("#ui-datepicker-div").position({
//                my: "left top",
//                at: "left bottom",
//                of: $(this)
//            });
//        }).attr("readonly", false);
        
        
//        $('#year2').datepicker( {
//            yearRange: "-100:+20",
//            changeMonth: false,
//            changeYear: true,
//            showButtonPanel: true,
//            closeText:'Select',
//            currentText: 'This year',
//            onClose: function(dateText, inst) {
//                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
//                $(this).val($.datepicker.formatDate("yy", new Date(year, 0, 1)));
//            },
//            beforeShow: function(input, inst){
//                if ($(this).val()!=''){
//                    var tmpyear = $(this).val();
//                    $(this).datepicker('option','defaultDate',new Date(tmpyear, 0, 1));
//                }
//            }
//        }).focus(function () {
//            $(".ui-datepicker-month").hide();
//            $(".ui-datepicker-calendar").hide();
//            $(".ui-datepicker-current").hide();
//            /*$(".ui-datepicker-close").hide();*/
//            $(".ui-datepicker-prev").hide();
//            $(".ui-datepicker-next").hide();
//            $("#ui-datepicker-div").position({
//                my: "left top",
//                at: "left bottom",
//                of: $(this)
//            });
//        }).attr("readonly", false);
        
    });
</script>
@endsection
