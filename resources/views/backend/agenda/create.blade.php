@extends('backend.layouts.app')

@section('title', __('labels.backend.agenda.title').' | '.app_name())
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
{{ html()->form('POST', route('admin.agenda.store'))->acceptsFiles()->class('form-horizontal')->open() }}
<?php 
$crt = 0;
if (isset($_GET['crt'])) {
    $crt = $_GET['crt'];
}
?>
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.agenda.create')</h3>
        <div class="float-right">
            <a href="{{ route('admin.agenda.index',['crt'=>$crt]) }}"
               class="btn btn-success">@lang('labels.backend.agenda.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">

                <div class="form-group row">  
                    <input type="hidden" name="crt_id" value="<?php echo $_GET['crt']; ?>" id="crtId">
                    <div class="col-12 col-lg-12 form-group">
                        <h4 class="page-title d-inline">{!! Form::label('z',trans('labels.backend.agenda.fields.duration'), ['class' => 'control-label']) !!}</h4>
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.agenda.fields.agenda_date'), ['class' => 'control-label']) !!}
                        {!! Form::text('agenda_date', old('agenda_date'), ['class' => 'form-control date agenda_date',  'placeholder' => trans('Agenda Date'), 'autocomplete' => 'off', 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group"></div>
                </div>
                <div class="form-group row agenda">  
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.agenda.fields.session_duration_from'), ['class' => 'control-label']) !!}
                        {!! Form::text('session_duration_from[]', old('session_duration_from'), ['class' => 'form-control date session_duration_from',  'placeholder' => trans('Start Time'), 'autocomplete' => 'off', 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.agenda.fields.session_duration_to'), ['class' => 'control-label']) !!}
                        {!! Form::text('session_duration_to[]', old('session_duration_to'), ['class' => 'form-control date session_duration_to timepicker', 'placeholder' => trans('End Time'), 'autocomplete' => 'off', 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.agenda.fields.type'), ['class' => 'control-label']) !!}
                        <select class="form-control"  name="type[]" required>
                            <option value="" selected>Please Select</option>
                            <option value="0">Lecture</option>
                            <option value="1">Break</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.agenda.fields.title'), ['class' => 'control-label']) !!}
                        {!! Form::text('title[]', old('title'), ['class' => 'form-control','placeholder' => trans('Enter Title'), 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group speaker">
                        {!! Form::label('z',trans('labels.backend.agenda.fields.speaker'), ['class' => 'control-label']) !!}
                        <select class="form-control"  name="speaker[]">
                            <option value="" selected>Please Select</option>
                            <option value="0">Internal</option>
                            <option value="1">External</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-6 form-group resourse_person">
                        <label for="z" class="control-label">Resource Person</label>
                        <select class="form-control"  name="resource_person[]">
                            <option value="" selected>Please Select</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-12 form-group">
                        <button class="btn btn-info pull-right add_more_agenda" type="button"> + Add More</button>
<!--                        <button class="btn btn-light pull-right rem_emp_code_resource" type="button">-</button>-->
                    </div>

                </div><!--form-group-->	


                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.agenda.index',["crt"=>$crt]), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>
</div>
{{ html()->form()->close() }}
<script type="text/javascript">
    $(document).ready(function() {
        
        $(".add_more_agenda").on('click', function(){
            var ele = $(this).closest('.agenda').clone(true);
            $(this).closest('.agenda').after(ele);
        });
        
        $('.session_duration_from').timepicker({
            timeFormat: 'h:mm p',
            interval: 30,
            minTime: '10',
            maxTime: '6:00pm',
            defaultTime: '11',
            startTime: '10:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
        $('.session_duration_to').timepicker({
            timeFormat: 'h:mm p',
            interval: 30,
            minTime: '10',
            maxTime: '6:00pm',
            defaultTime: '11',
            startTime: '10:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
        $(".agenda_date").datepicker({
            autoclose: true,
            minDate: "{{ $crts->start_date }}",
            maxDate: "{{ $crts->end_date }}",
            dateFormat: "{{ config('app.date_format_js') }}",
            numberOfMonths: 2
        });
        
        $('select[name="type[]"]').on('change', function() {
            var type = $(this).val();
            var speaker = $(this).parent().next().next();
            var res_per = speaker.next();
            if(type == 1){
                speaker.addClass('d-none');
                res_per.addClass('d-none');
            }else{
                speaker.removeClass('d-none');
                res_per.removeClass('d-none');
            }
        });
        
        $('select[name="speaker[]"]').on('change', function() {
            var speaker = $(this).val();
            var crtId = $("#crtId").val();
            var test =$(this).parent().next().children('select');
            $.ajax({
                url: 'speaker-ajax/'+speaker+','+crtId,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    var html = '<option value="">Please Select</option>';
                    $.each(data, function(key, value) {
                        html += '<option value="'+ key +'">'+ value +'</option>';
                    });
                    test.html(html);
                }
            });
        });
		
			
		
    });
</script>
@endsection
