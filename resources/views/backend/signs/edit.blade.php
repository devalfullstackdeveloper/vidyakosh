@extends('backend.layouts.app')
@section('title', __('labels.backend.signings.title').' | '.app_name())
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
{{ html()->modelForm($signs, 'PATCH', route('admin.signing.update', $signs->id))->class('form-horizontal')->acceptsFiles()->open() }}

<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.signings.edit')</h3>
        <div class="float-right">
            <a href="{{ route('admin.signing.index') }}"
               class="btn btn-success">@lang('labels.backend.signings.view')</a>
        </div>
    </div>
    <div class="card-body"> 
        <div class="row">
            <div class="col-12"> 
                <div class="form-group row">   
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.sectionofficers.fields.department_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('department_id', $department, $signs->departmentid, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.signings.fields.office_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('office_id', $office, $signs->office, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.sectionofficers.fields.officer_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('officer_id', $users, $signs->firstname, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0" {{old('status',$signs->status)=="0"? 'selected':''}}>Save</option>
                            <option value="1" {{old('status',$signs->status)=="1"? 'selected':''}}>Save & Publish</option>
                        </select>
                        </select>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.signing.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.update')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>

</div>
{{ html()->closeModelForm() }}
@endsection
