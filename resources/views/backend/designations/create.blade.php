@extends('backend.layouts.app')

@section('title', __('labels.backend.designations.title').' | '.app_name())
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
{{ html()->form('POST', route('admin.designations.store'))->acceptsFiles()->class('form-horizontal')->open() }}
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.designations.create')</h3>
        <div class="float-right">
            <a href="{{ route('admin.designations.index') }}"
               class="btn btn-success">@lang('labels.backend.designations.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">

                <div class="form-group row">  
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('department_id',trans('labels.backend.designations.fields.department_id'), ['class' => 'control-label require']) !!}
                        {!! Form::select('department_id', $departments, old('departments'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.designations.fields.parent_designation_id'), ['class' => 'control-label require']) !!}
                        <select class="form-control select2 js-example-placeholder-single select2-hidden-accessible" name="parent_designation_id" tabindex="-1" aria-hidden="true" required>
                            <option value="" selected="selected">Please select</option>
                        </select>
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.designations.fields.designation'))->class('form-control-label require')->for('designation') }}
                        {{ html()->text('designation')
                        ->class('form-control restrict')
                        ->placeholder(__('labels.backend.designations.fields.designation'))
                        ->attribute('maxlength', 500)
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
                        {{ form_cancel(route('admin.designations.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>
</div>
{{ html()->form()->close() }}

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="department_id"]').on('change', function() {
            var departmentID = $(this).val();
            if(departmentID) {
                $.ajax({
                    url: 'designation_ajax/'+departmentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        var parent = '<option value="">Please select</option>';
//                        $('select[name="parent_designation_id"]').empty();
                        $.each(data, function(key, value) {
                            parent +='<option value="'+ key +'">'+ value +'</option>';
//                            $('select[name="parent_designation_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        $('select[name="parent_designation_id"]').html(parent);
                    }
                });
            }else{
                $('select[name="parent_designation_id"]').empty();
            }
        });
    });
</script>

<script>
	$(function() {//<-- wrapped here
  $('.restrict').on('input', function() {
    this.value = this.value.replace(/[^a-zA-Z@]/g, ''); //<-- replace all other than given set of values
  });
});
	</script>
@endsection
