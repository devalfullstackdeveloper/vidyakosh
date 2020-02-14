@extends('backend.layouts.app')
@section('title', __('labels.backend.banner.title').' | '.app_name())

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
    {{ html()->modelForm($banners, 'PATCH', route('admin.banners.update', $banners->id))->class('form-horizontal')->acceptsFiles()->open() }}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.banner.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.banners.index') }}"
                   class="btn btn-success">@lang('labels.backend.banner.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                     <div class="form-group row">   
	   <div class="col-12 col-lg-6 form-group">
	      
		    {{ html()->label(__('labels.backend.banner.fields.title'))->class('form-control-label require')->for('title') }}
            {{ html()->text('title')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.banner.fields.title'))
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}       
           </div>
		   
		    <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('banner_image',  trans('labels.backend.banner.fields.banner_image'), ['class' => 'control-label require']) !!}
                    {!! Form::file('banner_image',  ['class' => 'form-control', 'accept' => 'image/jpeg,image/gif,image/png']) !!}
					{!! Form::image('/public/banners/','success', array( 'width' => 32, 'height' => 32 ))  !!}
                    {!! Form::hidden('banner_image_max_size', 8) !!}
                    {!! Form::hidden('banner_image_max_width', 4000) !!}
                    {!! Form::hidden('banner_image_max_height', 4000) !!}

                </div>
	
		   
		  </div><!--form-group-->	
                    <div class="form-group row justify-content-center">
                        <div class="col-4">
                            {{ form_cancel(route('admin.banners.index'), __('buttons.general.cancel')) }}
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
