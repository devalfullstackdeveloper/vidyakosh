@extends('backend.layouts.app')
@section('title', __('labels.backend.years.title').' | '.app_name())

@section('content')
{{ html()->modelForm($years, 'PATCH', route('admin.year.update', $years->id))->class('form-horizontal')->acceptsFiles()->open() }}
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
        <h3 class="page-title d-inline">@lang('labels.backend.years.edit')</h3>
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
                        {!! Form::select('department_id', $department, $years->deptid, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                        
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.years.fields.name'))->class('form-control-label')->for('name') }}
                        <select class="form-control select2 js-example-placeholder-single select2-hidden-accessible year" name="name" id="year_select" tabindex="-1" aria-hidden="true" required>
                            <option value="" selected="selected">Please select</option>
                            <option value="Financial year" <?php echo ($years->yearname == "Financial year") ? 'selected="selected"' : ""; ?>>Financial year</option>
                            <option value="Calender year" <?php echo ($years->yearname == "Calender year") ? 'selected="selected"' : ""; ?>>Calender year</option>
                        </select>

                    </div>
                    <?php
                    
                        $year = explode("-", $years->year);
                        $year1 = $year[0];
                        
                    ?>
                    <input type="hidden" id="year_hidden" value="<?php echo $years->year; ?>">
                    <div class="col-12 col-lg-6 form-group year_1">
                        {{ html()->label(__('labels.backend.years.fields.year'))->class('form-control-label')->for('year') }}
                        {{ html()->text('year')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.years.fields.year'))
                        ->attribute('maxlength', 500)
                        ->required()
                        ->autofocus() }} 
                        
                        

                    </div> 
                    <div class="col-12 col-lg-6 form-group year_2 d-none"> 
                        <label class="form-control-label" for="year2">Year</label>
                        <input class="form-control" type="text" name="year2" id="year2" placeholder="Year" maxlength="500" required value=""  autofocus="">
                    </div> 

                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0" {{old('status',$years->status)=="0"? 'selected':''}}>Save</option>
                            <option value="1" {{old('status',$years->status)=="1"? 'selected':''}}>Save & Publish</option>
                        </select>
                    </div>
<!--                    {{ html()->label(__('labels.backend.years.edit'))->class('col-md-2 form-control-label')->for('name') }}-->
                    <?php
//echo '<pre>';
//print_r($years->department_id);
//echo '<pre>';
//exit();
                    ?>
<!--                    <div class="col-md-10">
                        {{ html()->text('name')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.year.fields.name'))
                        ->attribute('maxlength', 100)
                        ->required()
                        ->autofocus() }}
                    </div>col-->
                </div><!--form-group-->


                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.year.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.update')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>

</div>
{{ html()->closeModelForm() }}
<script src="{{asset('assets/plugins/YearPicker/yearpicker.js')}}"></script>
<script>
    var jq = jQuery.noConflict();
      jq(document).ready(function() {
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
        var yr = jq("#year_hidden").val().split('-');
        console.log(yr);
        if(jq("#year_select").val() == "Financial year"){
            jq(".year_2").removeClass('d-none');
            jq("#year2").val(yr[1]);
            jq("#year").val(yr[0]);
        }else{
            jq(".year_2").addClass('d-none');
            jq("#year").val(yr[0]);
        }
        $('#year_select').on('change', function() {
            var year = $(this).val();
            if(year == "Financial year"){
                $(".year_2").removeClass('d-none');
            }else{
                $(".year_2").addClass('d-none');
                $("#year2").val('0000');
            }
        });
    });
</script>
@endsection
