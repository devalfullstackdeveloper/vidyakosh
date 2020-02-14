@extends('backend.layouts.app')
@section('title', __('labels.backend.locations.title').' | '.app_name())
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
{{ html()->modelForm($locations, 'PATCH', route('admin.locations.update', $locations->id))->class('form-horizontal')->acceptsFiles()->open() }}

<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.locations.edit')</h3>
        <div class="float-right">
            <a href="{{ route('admin.locations.index') }}"
               class="btn btn-success">@lang('labels.backend.locations.view')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('department_id', trans('labels.backend.departments.fields.department_name'), ['class' => 'control-label require']) !!}
                        {!! Form::select('department_id', $departments,  $locations->department_id, ['class' => 'form-control select2', 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.locations.fields.office_name'))->class('form-control-label require')->for('office_name') }}
                        {{ html()->text('office_name')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.locations.fields.office_name'))
                        ->attribute('maxlength', 191)
                        ->required()
                        ->autofocus() }}       
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('state_id', trans('labels.backend.states.fields.state'), ['class' => 'control-label require']) !!}
                        {!! Form::select('state_id', $state,  $locations->state_id, ['class' => 'form-control select2', 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.locations.fields.contact'))->class('form-control-label')->for('address') }}
                        {{ html()->text('contact')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.locations.fields.contact'))
                        ->attribute('maxlength', 10)
                        ->attribute('minlength', 10)
                        ->attribute('pattern', '\d*')
                        ->required()
                        ->autofocus() }}       
                    </div>
                </div><!--form-group-->
                
                <div class="form-group row"> 
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">@lang('labels.backend.cities.fields.city')</label>
                        {!! Form::select('city_id', $city,  $locations->city_id, ['class' => 'form-control select2', 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.locations.fields.email'))->class('form-control-label require')->for('email') }}
                        {{ html()->email('email')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.locations.fields.email'))
                        ->required()
                        ->autofocus() }}       
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.locations.fields.address'))->class('form-control-label require')->for('email') }}
                        {{ html()->text('address')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.locations.fields.address'))
                        ->required()
                        ->autofocus() }}       
                    </div>
                </div>
                <div class="form-group row"> 
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label require">Office Role</label>
                        {!! Form::select('parent_office_id', $locationListing,  $locations->parent_office_id, ['class' => 'form-control select2', 'required']) !!}
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control select2"  name="status">
                            <option value="0" {{old('status',$locations->status)=="0"? 'selected':''}}>Save</option>
                            <option value="1" {{old('status',$locations->status)=="1"? 'selected':''}}>Save & Publish</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                    <div class="col-4">
                        {{ form_cancel(route('admin.locations.index'), __('buttons.general.cancel')) }}
                        {{ form_submit(__('buttons.general.crud.update')) }}
                    </div>
                </div><!--col-->
            </div>
        </div>
    </div>

</div>
{{ html()->closeModelForm() }}
<script type="text/javascript">
    $(document).ready(function() {
        var APP_URL = {!! json_encode(url('/')) !!};
        $('select[name="department_id"]').on('change', function() {
            var departmentID = $(this).val();
            //alert(ministryID); exit;
            if(departmentID) {
                $.ajax({
                    url: APP_URL+'/user/locations/department-ajax/'+departmentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        var office_html = '<option value="">Please Select</option>';
                        $.each(data, function(key, value) {
                             office_html += '<option value="'+ key +'">'+ value +'</option>';
                        });
                        $('select[name="parent_office_id"]').html(office_html);
                    }
                });
            }else{
                $('select[name="department_id"]').empty();
            }
        });
    });
</script>
<!---------------------------------------------------------------------cities-filter--->
<script type="text/javascript">
    $(document).ready(function() {
        var APP_URL = {!! json_encode(url('/')) !!};
        $('select[name="state_id"]').on('change', function() {
            var stateID = $(this).val();
           
            if(stateID) {
                $.ajax({
                    url: APP_URL+'/user/locations/cities-ajax/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        //  alert(data); exit;
                        
                        var city_html = '<option value="">Please Select</option>';
                        $.each(data, function(key, value) {
                            city_html += '<option value="'+ key +'">'+ value +'</option>';
                        });
                        $('select[name="city_id"]').html(city_html);

                    }
                });
            }else{
                $('select[name="city_id"]').empty();
            }
        });
    });
</script>
@endsection
