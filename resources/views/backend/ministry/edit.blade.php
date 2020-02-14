@extends('backend.layouts.app')
@section('title', __('labels.backend.ministry.title').' | '.app_name())

@section('content')
    {{ html()->modelForm($ministry, 'PATCH', route('admin.ministry.update', $ministry->id))->class('form-horizontal')->acceptsFiles()->open() }}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.ministry.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.ministry.index') }}"
                   class="btn btn-success">@lang('labels.backend.ministry.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.ministry.fields.ministry_name'))->class('col-md-2 form-control-label require')->for('ministry_name') }}

                        <div class="col-md-10">
                            {{ html()->text('ministry_name')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.ministry.fields.ministry_name'))
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

  
                    <div class="form-group row justify-content-center">
                        <div class="col-4">
                            {{ form_cancel(route('admin.ministry.index'), __('buttons.general.cancel')) }}
                            {{ form_submit(__('buttons.general.crud.update')) }}
                        </div>
                    </div><!--col-->
                </div>
            </div>
        </div>

    </div>
    {{ html()->closeModelForm() }}
@endsection
