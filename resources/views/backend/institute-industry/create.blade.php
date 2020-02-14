@extends('backend.layouts.app')

@section('title', __('labels.backend.institute-industry.title').' | '.app_name())


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
{{ html()->form('POST', route('admin.institutes-industries.store'))->acceptsFiles()->class('form-horizontal')->open() }}
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.institute-industry.create')</h3>
        <div class="float-right">
            <a href="{{ route('admin.institutes-industries.index') }}"
               class="btn btn-success">@lang('labels.backend.institute-industry.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row"> 

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('department_id', trans('labels.backend.departments.fields.department_name'), ['class' => 'control-label require']) !!}
                        {!! Form::select('department_id', $departments, old('department_id'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}

                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">Type</label>
                        <select class="form-control select2"  name="type_id" required>
                            <option value="">Please Select</option>
                            <option value="1">Institute</option>
                            <option value="2">Industry</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.institute-industry.fields.name'))->class('form-control-label require')->for('name') }}
                        {{ html()->text('name')
                        ->class('form-control restrict')
                        ->placeholder(__('labels.backend.institute-industry.fields.name'))
                        ->attribute('maxlength', 191)
                        ->required()
                        ->autofocus() }}       
                    </div>	

                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.institute-industry.fields.phone'))->class('form-control-label require')->for('phone') }}
                        {{ html()->text('phone')
                        ->class('form-control number')
                        ->placeholder(__('labels.backend.institute-industry.fields.phone'))
                        ->attribute('maxlength',10)
                        ->required()
                        ->autofocus() }}       
                    </div>	

                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.institute-industry.fields.email'))->class('form-control-label require')->for('email') }}
                        {{ html()->text('email')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.institute-industry.fields.email'))
                        ->attribute('maxlength',30)
                        ->required()
                        ->autofocus() }}     

                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.institute-industry.fields.address'))->class('form-control-label require')->for('address') }}
                        {{ html()->text('address')
                        ->class('form-control address')
                        ->placeholder(__('labels.backend.institute-industry.fields.address'))
                        ->attribute('maxlength',500)
                        ->required()
                        ->autofocus() }}     

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
                        {{ form_cancel(route('admin.institutes-industries.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>
</div>
{{ html()->form()->close() }}



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
<script>
	$(function() {//<-- wrapped here
  $('.restrict').on('input', function() {
    this.value = this.value.replace(/[^a-zA-Z@\s]/g, ''); //<-- replace all other than given set of values
  });
 $('.number').on('input', function() {
    this.value = this.value.replace(/[^0-9@]/g, ''); //<-- replace all other than given set of values
  });
			$('.address').on('input', function() {
    this.value = this.value.replace(/[^a-zA-Z0-9,-@\s]/g, ''); //<-- replace all other than given set of values
  });
		
});
	</script>

@endpush	


@endsection
