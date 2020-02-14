@extends('backend.layouts.app')

@section('title', __('labels.backend.courserequest.title').' | '.app_name())
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
{{ html()->form('POST', route('admin.courserequest.store'))->acceptsFiles()->class('form-horizontal')->open() }}
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.courserequest.title')</h3>
       
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">

                <div class="form-group row">  
                    <div class="col-lg-6 form-group">
                        {!! Form::label('department_id',trans('labels.backend.courserequest.fields.name'), ['class' => 'control-label']) !!}
                         {{ html()->text('fullname')
                        ->value($getcourserequest->full_name)
                        ->class('form-control')
                        ->placeholder(__('labels.backend.courserequest.fields.name'))
                        ->readonly()
                        ->autofocus() }}
                    </div>

                    <div class="col-lg-6 form-group">
                        {!! Form::label('z',trans('labels.backend.courserequest.fields.designation_id'), ['class' => 'control-label']) !!}
                        {{ html()->text('designation')
                        ->value($getcourserequest->designation)
                        ->class('form-control')
                        ->placeholder(__('labels.backend.courserequest.fields.designation_id'))
                        ->required()
                        ->readonly()
                        ->autofocus() }}
                    </div>

                    <div class="col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.courserequest.fields.email'))->class('form-control-label')->for('email') }}
                        {{ html()->email('email')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.courserequest.fields.email'))
                        ->value($getcourserequest->email)
                        ->required()
                        ->readonly()
                        ->autofocus() }} 
                    </div>
                    <div class="col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.courserequest.fields.state'))->class('form-control-label')->for('state') }}
                        {{ html()->text('state')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.courserequest.fields.state'))
                        ->value($getcourserequest->state)
                        ->required()
                        ->readonly()
                        ->autofocus() }} 
                    </div> 
                    <div class="col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.courserequest.fields.city'))->class('form-control-label')->for('city') }}
                        {{ html()->text('city')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.courserequest.fields.city'))
                        ->value($getcourserequest->city)
                        ->required()
                        ->readonly()
                        ->autofocus() }} 
                    </div> 
                    <div class="col-lg-6 form-group">
                        {{ html()->label(__('labels.backend.courserequest.fields.phone'))->class('form-control-label')->for('phone') }}
                        {{ html()->text('phone')
                        ->class('form-control')
                        ->placeholder(__('labels.backend.courserequest.fields.phone'))
                        ->value($getcourserequest->phone)
                        ->required()
                        ->autofocus() }} 
                    </div>
                    <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('track_id', trans('labels.backend.courserequest.fields.track_id').' ', ['class' => 'control-label']) !!}
                        {!! Form::select('track_id', $resourcetrack, old('resourcetrack'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                    
                    <div class="col-12 col-lg-6 form-group">

                        {!! Form::label('category_id',trans('labels.backend.courserequest.fields.category_id'), ['class' => 'control-label']) !!}
                        {!! Form::select('category_id', $categories, old('categories'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>

                     <div class="col-12 col-lg-6 form-group">
                        {!! Form::label('subcategory_id',trans('labels.backend.courserequest.fields.subcategory_id'), ['class' => 'control-label']) !!}
                        {!! Form::select('subcategory_id', $subcategories, old('subcategory_id'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
                    </div>
                     <div class="col-12 col-lg-6 form-group">
                        
                        {!! Form::label('courses_id',trans('labels.backend.courserequest.fields.courses_id'), ['class' => 'control-label']) !!}
                        {!! Form::select('courses_id', $courses, old('courses_id'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required']) !!}
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
        $('select[name="track_id"]').on('change', function() {
            var trackID = $(this).val();
            if(trackID) {
                $.ajax({
                    url: 'courserequest/category-ajax/'+trackID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="category_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="category_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="category_id"]').empty();
            }
        }); 
        
    });

    $(document).ready(function() {
        $('select[name="category_id"]').on('change', function() {
            var trackID = $(this).val();
            if(trackID) {
                $.ajax({
                    url: 'courserequest/subcategory-ajax/'+trackID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="subcategory_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="subcategory_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="subcategory_id"]').empty();
            }
        }); 
        
    });

    $(document).ready(function() {
        $('select[name="subcategory_id"]').on('change', function() {
            var trackID = $(this).val();
            if(trackID) {
                $.ajax({
                    url: 'courserequest/courses-ajax/'+trackID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="courses_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="courses_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="courses_id"]').empty();
            }
        }); 
        
    });
</script>
@endsection
