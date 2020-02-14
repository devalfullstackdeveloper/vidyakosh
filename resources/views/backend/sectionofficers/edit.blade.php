@extends('backend.layouts.app')
@section('title', __('labels.backend.sectionofficers.title').' | '.app_name())

@section('content')
    {{ html()->modelForm($sectionofficers, 'PATCH', route('admin.section.update', $sectionofficers->id))->class('form-horizontal')->acceptsFiles()->open() }}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.sectionofficers.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.year.index') }}"
                   class="btn btn-success">@lang('labels.backend.sectionofficers.view')</a>
            </div>
        </div>
        <div class="card-body"> 
            <div class="row">
                <div class="col-12"> 
                <div class="form-group row">   
               <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('z',trans('labels.backend.sectionofficers.fields.department_id'), ['class' => 'control-label']) !!}
                    {!! Form::select('department_id', $department, $sectionofficers->deptname, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                </div>

                 <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('z',trans('labels.backend.sectionofficers.fields.officer_id'), ['class' => 'control-label']) !!}
                    {!! Form::select('officer_id', $users,$sectionofficers->firstname, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                </div>
                </div>
                    <div class="form-group row justify-content-center">
                        <div class="col-4">
                            {{ form_cancel(route('admin.section.index'), __('buttons.general.cancel')) }}
                            {{ form_submit(__('buttons.general.crud.update')) }}
                        </div>
                    </div><!--col-->
                </div>
            </div>
        </div>

    </div>
    {{ html()->closeModelForm() }}
@endsection
