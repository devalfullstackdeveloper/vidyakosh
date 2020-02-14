@extends('backend.layouts.app')
@section('title', __('labels.backend.default_website_page.title').' | '.app_name())

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
    {{ html()->form('POST', route('admin.default-settings'))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.default_website_page.title') }}
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr/>
                <div class="col-12">
               	<div class="form-group row"> 
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('ministry_id', trans('labels.backend.ministry.fields.ministry_name'), ['class' => 'control-label']) !!}
                    {!! Form::select('ministry_id', $ministry,  (request('ministry_id')) ? request('ministry_id') : old('ministry_id'), ['class' => 'form-control select2']) !!}
                </div>
				 <div class="col-12 col-lg-6 form-group">
                <label class="control-label">@lang('labels.backend.departments.fields.department_name')</label>
                <select class="form-control select2"  name="department_id" required>
              <option value="">Please Select</option>
              
            </select>
                </div>
				
				</div><!--form-group-->	

                 
                  

                </div><!--col-->
           
        </div><!--card-body-->

        <div class="card-footer clearfix">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.social-settings'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->form()->close() }}
@endsection


@push('after-scripts')
    <script type="text/javascript">
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
</script>
@endpush
