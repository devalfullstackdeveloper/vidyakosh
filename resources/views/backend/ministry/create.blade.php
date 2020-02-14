@extends('backend.layouts.app')

@section('title', __('labels.backend.ministry.title').' | '.app_name())


@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
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
    {{ html()->form('POST', route('admin.ministry.store'))->acceptsFiles()->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.ministry.create')</h3>
            <div class="float-right">
                <a href="{{ route('admin.ministry.index') }}"
                   class="btn btn-success">@lang('labels.backend.ministry.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
			<div class="form-group row"> 
                <div class="col-12 col-lg-6 form-group">
                   {{ html()->label(__('labels.backend.ministry.fields.ministry_name'))->class('col-md form-control-label require')->for('ministry_name') }}
                            {{ html()->text('ministry_name')
                                ->class('form-control restrict')
                                ->placeholder(__('labels.backend.ministry.fields.ministry_name'))
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                </div>
			 <div class="col-12 col-lg-6 form-group">
              <label class="control-label">Status</label>
              <select class="form-control select2"  name="status">
              <option value="0">Save</option>
			  <option value="1">Save & Publish</option>
            </select>
            </select>
                </div>
				
				</div><!--form-group-->

                    <div class="form-group row justify-content-center">
                        <div class="col-4">
                            {{ form_cancel(route('admin.ministry.index'), __('buttons.general.cancel')) }}
                            {{ form_submit(__('buttons.general.crud.create')) }}
                        </div>
                    </div><!--col-->
                </div>
            </div>
        </div>
    </div>
    {{ html()->form()->close() }}


<script>
	$(function() {//<-- wrapped here
  $('.restrict').on('input', function() {
    this.value = this.value.replace(/[^a-zA-Z@\s]/g, ''); //<-- replace all other than given set of values
  });
});
	</script>
@endsection
