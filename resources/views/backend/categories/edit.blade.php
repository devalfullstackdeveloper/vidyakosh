@extends('backend.layouts.app')
@section('title', __('labels.backend.categories.title').' | '.app_name())

@push('after-styles')
<link rel="stylesheet" href="{{asset('plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')}}"/>
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
{!! Form::model($category, ['method' => 'PUT', 'route' => ['admin.categories.update', $category->id], 'files' => true,]) !!}

<div class="alert alert-danger d-none" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <div class="error-list">
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.categories.edit')</h3>
        <div class="float-right">
            <a href="{{ route('admin.categories.index') }}"
               class="btn btn-success">@lang('labels.backend.categories.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.years.fields.department_id'), ['class' => 'control-label']) !!}
                        {!! Form::select('department_id', $department, $category->department_id, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Track</label>
                        {!! Form::select('tracks', $track, $category->track_id, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}

                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('title', trans('labels.backend.categories.fields.name').' *', ['class' => 'control-label']) !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.categories.fields.name'), 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('title', trans('labels.backend.categories.fields.short_name').' *', ['class' => 'control-label']) !!}
                        {!! Form::text('short_name', old('short_name'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.categories.fields.short_name'), 'required']) !!}
                    </div>

                    <div class="col-12 col-lg-2  form-group">
                        {!! Form::label('icon',  trans('labels.backend.categories.fields.select_icon'), ['class' => 'control-label  d-block']) !!}
                        <button class="btn  btn-block btn-default border" id="icon" name="icon"></button>
                    </div>
                    <div class="col-12 col-lg-4 form-group"></div>

                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0" {{old('status',$category->status)=="0"? 'selected':''}}>Save</option>
                            <option value="1" {{old('status',$category->status)=="1"? 'selected':''}}>Save & Publish</option>
                        </select>
                    </div>

                    <div class="col-12 form-group text-center">
                        <div class="col-8">
                            {{ form_cancel(route('admin.faculty.index'), __('buttons.general.cancel')) }}
                            {{ form_submit(__('buttons.general.crud.update')) }}
                        </div>
                        <!--                        {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn mt-auto  btn-danger']) !!}-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ html()->form()->close() }}
@endsection

@push('after-scripts')
<script src="{{asset('plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.bundle.min.js')}}"></script>

<script>
    
    $.ajax({
        url: 'http://103.101.59.95/nic-lms/public/user/categories/office-ajax/'+$('select[name="department_id"]').val(),
        type: "GET",
        dataType: "json",
        success:function(data) {
            var trackHtml = '<option value="">Select Track</option>';
            $.each(data, function(key, value) {
                trackHtml += '<option value="'+ key +'">'+ value +'</option>';
            });
            $("#tracks").html(trackHtml);
        }
    });
    
    var icon = 'fas fa-bomb';
    @if($category->icon != "")
        icon = "{{$category->icon}}";
    @endif
    $('#icon').iconpicker({
        cols: 10,
        icon: icon,
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

    $(document).on('change', '#icon_type', function () {

        if ($(this).val() == 1) {
            $('.upload-image-wrapper').parent('.col-12').removeClass('d-none')

            $('.upload-image-wrapper').removeClass('d-none');
            $('.select-icon-wrapper').addClass('d-none')
        } else if ($(this).val() == 2) {
            $('.upload-image-wrapper').parent('.col-12').removeClass('d-none')

            $('.upload-image-wrapper').addClass('d-none');
            $('.select-icon-wrapper').removeClass('d-none')
        } else {
            $('.upload-image-wrapper').parent('.col-12').addClass('d-none')
            $('.upload-image-wrapper').addClass('d-none');
            $('.select-icon-wrapper').addClass('d-none');


        }
    })
    
    $('select[name="department_id"]').on('change', function() {
        var departmentID = $(this).val();
        //alert(departmentID); exit;
        if(departmentID) {
            $.ajax({
                //                    url: 'office-ajax/'+departmentID,
                url: '/nic-lms/public/user/categories/office-ajax/'+departmentID,
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
</script> 
@endpush


