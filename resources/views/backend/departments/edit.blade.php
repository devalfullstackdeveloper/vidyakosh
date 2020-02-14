@extends('backend.layouts.app')
@section('title', __('labels.backend.departments.title').' | '.app_name())


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
{{ html()->modelForm($departments, 'PATCH', route('admin.departments.update', $departments->id))->class('form-horizontal')->acceptsFiles()->open() }}

<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.departments.edit')</h3>
        <div class="float-right">
            <a href="{{ route('admin.ministry.index') }}"
               class="btn btn-success">@lang('labels.backend.departments.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">  
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('ministry_id',trans('labels.backend.ministry.fields.ministry_name'), ['class' => 'control-label require']) !!}
                        {!! Form::select('ministry_id', $ministry, old('ministry_id'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.departments.fields.department_name'))->class('form-control-label require')->for('department_name') }}
                        {{ html()->text('department_name')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.departments.fields.department_name'))
                        ->attribute('maxlength', 191)
                        ->required()
                        ->autofocus() }}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('logo',  trans('labels.backend.departments.fields.logo'), ['class' => 'control-label']) !!}
                        {!! Form::file('logo',  ['class' => 'form-control', 'accept' => 'image/jpeg,image/gif,image/png']) !!}
                        {!! Form::hidden('logo_max_size', 2) !!}

                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0" {{old('status',$departments->status)=="0"? 'selected':''}}>Save</option>
                            <option value="1" {{old('status',$departments->status)=="1"? 'selected':''}}>Save & Publish</option>
                        </select>
                        </select>
                    </div>
                </div><!--form-group-->


                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.departments.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.update')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>

</div>
{{ html()->closeModelForm() }}
@endsection
