@extends('backend.layouts.app')
@section('title', __('labels.backend.news.title').' | '.app_name())

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
{{ html()->modelForm($newsflash, 'PATCH', route('admin.newsflash.update', $newsflash->id))->class('form-horizontal')->acceptsFiles()->open() }}

<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.news.edit')</h3>
        <div class="float-right">
            <a href="{{ route('admin.newsflash.index') }}"
               class="btn btn-success">@lang('labels.backend.news.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row"> 
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('ministry_id', trans('labels.backend.ministry.fields.ministry_name'), ['class' => 'control-label require']) !!}
                        {!! Form::select('ministry_id[]', $ministry, $ministryArr, ['class' => 'form-control select2', 'multiple' => true, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('department_id', trans('labels.backend.departments.fields.department_name'), ['class' => 'control-label require']) !!}
                        {!! Form::select('department_id[]', $departments, $deptArr, ['class' => 'form-control select2', 'multiple' => true, 'required']) !!}
                    </div>

                </div><!--form-group-->	



                <div class="form-group row"> 

                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.news.fields.title'))->class('form-control-label require')->for('title') }}
                        {{ html()->text('title')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.news.fields.title'))
                        ->attribute('maxlength', 191)
                        ->required()
                        ->autofocus() }}       
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.news.fields.description'))->class('form-control-label require')->for('description') }}
                        {{ html()->text('description')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.news.fields.description'))
                        ->attribute('maxlength', 500)
                        ->required()
                        ->autofocus() }}       
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('start_date', trans('labels.backend.news.fields.start_date').' (yyyy-mm-dd)', ['class' => 'control-label require']) !!}
                        {!! Form::text('start_date', $newsflash->start_date, ['class' => 'form-control date','pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.news.fields.start_date').' (Ex . 2019-01-01)', 'autocomplete' => 'off', 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('end_date', trans('labels.backend.news.fields.end_date').' (yyyy-mm-dd)', ['class' => 'control-label require']) !!}
                        {!! Form::text('end_date', $newsflash->end_date, ['class' => 'form-control date','pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.news.fields.end_date').' (Ex . 2019-01-01)', 'autocomplete' => 'off', 'required']) !!}
                    </div>


                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0" {{old('status',$newsflash->status)=="0"? 'selected':''}}>Save</option>
                            <option value="1" {{old('status',$newsflash->status)=="1"? 'selected':''}}>Save & Publish</option>
                        </select>
                    </div>
                </div><!--form-group-->		
                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.newsflash.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.update')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>

</div>
{{ html()->closeModelForm() }}


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
		
    $(document).ready(function () {
        $('#end_date').datepicker({
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
    })


</script>

@endpush	
@endsection
