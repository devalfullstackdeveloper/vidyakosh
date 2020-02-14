@extends('backend.layouts.app')
@section('title', __('labels.backend.categories.title').' | '.app_name())


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


@push('after-styles')
<link rel="stylesheet" href="{{asset('plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')}}"/>
@endpush
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.categories.create')</h3>
        <div class="float-right">
            <a href="{{ route('admin.categories.index') }}"
               class="btn btn-success">@lang('labels.backend.categories.view')</a>

        </div>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-12">

                {!! Form::open(['method' => 'POST', 'route' => ['admin.categories.store'], 'files' => true,]) !!}

                <div class="row">
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('department_id', trans('labels.backend.categories.fields.department_id'), ['class' => 'control-label']) !!}
                        {!! Form::select('department_id', $departments, old('departments'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Tracks</label>
                        {!! Form::select('tracks', $track, old('tracks'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('title', trans('labels.backend.categories.fields.name').' *', ['class' => 'control-label']) !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control restrict', 'placeholder' => trans('labels.backend.categories.fields.name'), 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('title', trans('labels.backend.categories.fields.short_name').' *', ['class' => 'control-label']) !!}
                        {!! Form::text('short_name', old('short_name'), ['class' => 'form-control restrict', 'placeholder' => trans('labels.backend.categories.fields.short_name'), 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-2  form-group">
                        {!! Form::label('icon',  trans('labels.backend.categories.fields.select_icon'), ['class' => 'control-label  d-block']) !!}
                        <button class="btn  btn-block btn-default border" id="icon" name="icon"></button>
                    </div>
                    <div class="col-12 col-lg-4 form-group"></div>

                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0">Save</option>
                            <option value="1">Save & Publish</option>
                        </select>
                        </select>
                    </div>

                    <div class="col-12 form-group text-center">
                        <div class="col-8">
                            {{ form_cancel(route('admin.categories.index'), __('buttons.general.cancel')) }}
                            {{ form_submit(__('buttons.general.crud.create')) }}
                        </div>
<!--                        {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn mt-auto  btn-danger']) !!}-->
                    </div>
                </div>

                {!! Form::close() !!}


            </div>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script src="{{asset('plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.bundle.min.js')}}"></script>

<script>
    $(document).ready(function () {
        $('#icon').iconpicker({
            cols: 10,
            icon: 'fas fa-bomb',
            iconset: 'fontawesome5',
            labelHeader: '{0} of {1} pages',
            labelFooter: '{0} - {1} of {2} icons',
            placement: 'bottom', // Only in button tag
            rows: 5,
            search: true,
            searchText: 'Search',
            selectedClass: 'btn-success',
            unselectedClass: ''
        });
        $('select[name="department_id"]').on('change', function() {
            var departmentID = $(this).val();
            //alert(departmentID); exit;
            if(departmentID) {
                $.ajax({
                    url: 'office-ajax/'+departmentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        var trackHtml = '<option value="">Please select</option>';
                        $.each(data, function(key, value) {
                            trackHtml += '<option value="'+ key +'">'+ value +'</option>';
                        });
                        $('select[name="tracks"]').html(trackHtml);


                    }
                });
            }
        });
        });
</script>
<script>
	$(function() {//<-- wrapped here
  $('.restrict').on('input', function() {
    this.value = this.value.replace(/[^a-zA-Z@\s]/g, ''); //<-- replace all other than given set of values
  });
});
	</script>
@endpush
