@extends('backend.layouts.app')
@section('title', __('labels.backend.cities.title').' | '.app_name())
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
{{ html()->modelForm($cities, 'PATCH', route('admin.cities.update', $cities->id))->class('form-horizontal')->acceptsFiles()->open() }}

<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.cities.edit')</h3>
        <div class="float-right">
            <a href="{{ route('admin.cities.index') }}"
               class="btn btn-success">@lang('labels.backend.cities.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('state_id',trans('labels.backend.states.fields.state'), ['class' => 'control-label require']) !!}
                        {!! Form::select('state_id', $states, $cities->state_id, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.cities.fields.city'))->class('form-control-label require')->for('city') }}
                        {{ html()->text('city')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.cities.fields.city'))
                        ->attribute('maxlength', 100)
                        ->required()
                        ->autofocus() }}


                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0" {{old('status',$cities->status)=="0"? 'selected':''}}>Save</option>
                            <option value="1" {{old('status',$cities->status)=="1"? 'selected':''}}>Save & Publish</option>
                        </select>
                    </div>
                </div><!--form-group-->


                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.cities.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.update')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>

</div>
{{ html()->closeModelForm() }}
@endsection
