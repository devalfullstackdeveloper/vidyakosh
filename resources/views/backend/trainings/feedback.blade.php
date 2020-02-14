@extends('backend.layouts.app')
@section('title', __('labels.backend.feedbacks.title').' | '.app_name())
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
		.star-rating {
		  line-height:32px;
		  font-size:1.25em;
		  display: inline-block;
		}
		.star-rating .fa-star{color: yellow;}
    </style>

@endpush

@section('content')
    {{ html()->form('get', route('admin.trainings.feedbacksave'))->acceptsFiles()->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.feedbacks.create')</h3>
            @if (Session::has('message'))
                <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            <!-- <div class="float-right">
                <a href="{{ route('admin.crt.index') }}"
                   class="btn btn-success">@lang('labels.backend.crts.view')</a>
            </div> -->
        </div>
        <div class="card-body">
            
            <div class="row">
                <div class="col-12">
                
              <div class="form-group row">   
               <div class="col-12 col-lg-6 form-group">
                <input type="hidden" name="login_user_id" id="login_user_id" value="{{$logged_in_user->id}}">
                @foreach($attendance as $attendancedata)
                <input type="hidden" name="department_id" id="department_id" value="{{$attendancedata->department_id}}">
                @endforeach

                    {!! Form::label('z',trans('labels.backend.feedbacks.fields.training_id'), ['class' => 'control-label']) !!}
                    <select class="form-control select2" name= "training_id">
                        @foreach($attendance as $attendancedata)
                        <option value="{{$attendancedata->id}}">{{$attendancedata->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('z',trans('labels.backend.feedbacks.fields.topic'), ['class' => 'control-label']) !!}
                   {!! Form::textarea('topic', old('topic'), ['class' => 'form-control','rows' => 4, 'cols' => 54, 'placeholder' => trans('labels.backend.feedbacks.fields.feedback_placeholder')]) !!}

                   {!! Form::label('z',trans('labels.backend.feedbacks.fields.ratings'), ['class' => 'control-label']) !!}
                   <?php
                   /* $review=(object)['rate'=>3];
                    for($i=0; $i<5; ++$i){
                    echo '<i class="fa fa-star',($review->rate<=$i?'-o':''),'" aria-hidden="true"></i>';
                    }*/
					?>
                    <div class="star-rating topic-rating">
                        <span class="fa fa-star-o" data-rating="1"></span>
                        <span class="fa fa-star-o" data-rating="2"></span>
                        <span class="fa fa-star-o" data-rating="3"></span>
                        <span class="fa fa-star-o" data-rating="4"></span>
                        <span class="fa fa-star-o" data-rating="5"></span>
                        <input type="hidden" name="topic_rating" class="rating-value" value="3">
                    </div>
                </div>

                  <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('z',trans('labels.backend.feedbacks.fields.faculties'), ['class' => 'control-label']) !!}
                   {!! Form::textarea('faculties', old('faculties'), ['class' => 'form-control','rows' => 4, 'cols' => 54, 'placeholder' => trans('labels.backend.feedbacks.fields.feedback_placeholder')]) !!}

                   {!! Form::label('z',trans('labels.backend.feedbacks.fields.ratings'), ['class' => 'control-label']) !!}
                   <?php
				    /*$review=(object)['rate'=>3];
                    for($i=0; $i<5; ++$i){
                    echo '<i class="fa fa-star',($review->rate<=$i?'-o':''),'" aria-hidden="true"></i>';
                    }*/
					?>
                    <div class="star-rating faculties-rating">
                        <span class="fa fa-star-o" data-rating="1"></span>
                        <span class="fa fa-star-o" data-rating="2"></span>
                        <span class="fa fa-star-o" data-rating="3"></span>
                        <span class="fa fa-star-o" data-rating="4"></span>
                        <span class="fa fa-star-o" data-rating="5"></span>
                        <input type="hidden" name="faculties_rating" class="rating-value" value="3">
                    </div>
                </div>
                 <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('z',trans('labels.backend.feedbacks.fields.prospective'), ['class' => 'control-label']) !!}
                   {!! Form::textarea('prospective', old('prospective'), ['class' => 'form-control','rows' => 4, 'cols' => 54, 'placeholder' => trans('labels.backend.feedbacks.fields.feedback_placeholder')]) !!}                   
                </div>

                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('z',trans('labels.backend.feedbacks.fields.rate'), ['class' => 'control-label']) !!}
                    <br>
                    {!! Form::label('z',trans('labels.backend.feedbacks.fields.structure'), ['class' => 'control-label','style'=>'color:red;font-size: initial;']) !!} 
                    {{ Form::radio('structure', 0) }} Poor
                    {{ Form::radio('structure', 1) }} Fair
                    {{ Form::radio('structure', 2) }} Good
                    {{ Form::radio('structure', 3) }} Very Good
                    {{ Form::radio('structure', 4) }} Excellent
                    <br><br>
                    {!! Form::label('z',trans('labels.backend.feedbacks.fields.interaction'), ['class' => 'control-label','style'=>'color:red;font-size: initial;']) !!} 
                    {{ Form::radio('interaction', 0) }} Poor
                    {{ Form::radio('interaction', 1) }} Fair
                    {{ Form::radio('interaction', 2) }} Good
                    {{ Form::radio('interaction', 3) }} Very Good
                    {{ Form::radio('interaction', 4) }} Excellent
                    <br><br>
                    {!! Form::label('z',trans('labels.backend.feedbacks.fields.venue'), ['class' => 'control-label','style'=>'color:red;font-size: initial;']) !!} 
                    {{ Form::radio('venue', 0) }} Poor
                    {{ Form::radio('venue', 1) }} Fair
                    {{ Form::radio('venue', 2) }} Good
                    {{ Form::radio('venue', 3) }} Very Good
                    {{ Form::radio('venue', 4) }} Excellent
                </div>
                
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('z',trans('labels.backend.feedbacks.fields.arrangement'), ['class' => 'control-label']) !!}
                   {!! Form::textarea('arrangement', old('arrangement'), ['class' => 'form-control','rows' => 4, 'cols' => 54, 'placeholder' => trans('labels.backend.feedbacks.fields.feedback_placeholder')]) !!}
                   {!! Form::label('z',trans('labels.backend.feedbacks.fields.location'), ['class' => 'control-label']) !!} 
                    {{ Form::radio('location_rate', 0) }} Poor
                    {{ Form::radio('location_rate', 1) }} Fair
                    {{ Form::radio('location_rate', 2) }} Good
                    {{ Form::radio('location_rate', 3) }} Very Good
                    {{ Form::radio('location_rate', 4) }} Excellent
                </div>
                  <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('z',trans('labels.backend.feedbacks.fields.coordination'), ['class' => 'control-label']) !!}
                   {!! Form::textarea('coordination', old('coordination'), ['class' => 'form-control','rows' => 4, 'cols' => 54, 'placeholder' => trans('labels.backend.feedbacks.fields.feedback_placeholder')]) !!}
                   {!! Form::label('z',trans('labels.backend.feedbacks.fields.ratings'), ['class' => 'control-label']) !!}
                   <?php 
				    /*$review=(object)['rate'=>3];
                    for($i=0; $i<5; ++$i){
                    echo '<i class="fa fa-star',($review->rate<=$i?'-o':''),'" aria-hidden="true"></i>';
                    }*/
					?>
                    <div class="star-rating coordination-rating">
                        <span class="fa fa-star-o" data-rating="1"></span>
                        <span class="fa fa-star-o" data-rating="2"></span>
                        <span class="fa fa-star-o" data-rating="3"></span>
                        <span class="fa fa-star-o" data-rating="4"></span>
                        <span class="fa fa-star-o" data-rating="5"></span>
                        <input type="hidden" name="coordination_rating" class="rating-value" value="3">
                    </div>
                </div>
                 <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('z',trans('labels.backend.feedbacks.fields.activities'), ['class' => 'control-label']) !!}
                   {!! Form::textarea('activities', old('activities '), ['class' => 'form-control','rows' => 4, 'cols' => 54, 'placeholder' => trans('labels.backend.feedbacks.fields.feedback_placeholder')]) !!}
                   {!! Form::label('z',trans('labels.backend.feedbacks.fields.capability'), ['class' => 'control-label']) !!} 
                    {{ Form::radio('capability', 0) }} Yes
                    {{ Form::radio('capability', 1) }} No
                </div>
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('z',trans('labels.backend.feedbacks.fields.utilizing'), ['class' => 'control-label']) !!}
                   {!! Form::textarea('utilizing', old('utilizing '), ['class' => 'form-control','rows' => 4, 'cols' => 54, 'placeholder' => trans('labels.backend.feedbacks.fields.feedback_placeholder')]) !!}
                </div>
                 <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('z',trans('labels.backend.feedbacks.fields.suggestions'), ['class' => 'control-label']) !!}
                   {!! Form::textarea('suggestions', old('suggestions '), ['class' => 'form-control','rows' => 4, 'cols' => 54, 'placeholder' => trans('labels.backend.feedbacks.fields.feedback_placeholder')]) !!}
                </div>
                 <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('z',trans('labels.backend.feedbacks.fields.overall'), ['class' => 'control-label']) !!}
                     <div class="star-rating overall-rating">
                            <span class="fa fa-star-o" data-rating="1"></span>
                            <span class="fa fa-star-o" data-rating="2"></span>
                            <span class="fa fa-star-o" data-rating="3"></span>
                            <span class="fa fa-star-o" data-rating="4"></span>
                            <span class="fa fa-star-o" data-rating="5"></span>
                            <input type="hidden" name="overall_rating" class="rating-value" value="3">
                     </div>
                </div>
                </div>
                	@if(count($attendance) > 0)
                    <div class="form-group row justify-content-center">
                            {{ form_submit(__('buttons.general.crud.submit')) }}
                    </div><!--col-->
                    @endif
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function() {
var $star_rating = $('.star-rating .fa');

var SetRatingStar = function() {
  return $star_rating.each(function(key,val) { 
    if (parseInt($(val).siblings('input.rating-value').val()) >= parseInt($(val).data('rating'))) {
      return $(this).removeClass('fa-star-o').addClass('fa-star');
    } else {
      return $(this).removeClass('fa-star').addClass('fa-star-o');
    }
  });
};

var $topic_rating = $('.topic-rating .fa');
$topic_rating.on('click', function() {
  $topic_rating.siblings('input.rating-value').val($(this).data('rating'));
  return SetRatingStar();
});

var $faculties_rating = $('.faculties-rating .fa');
$faculties_rating.on('click', function() {
  $faculties_rating.siblings('input.rating-value').val($(this).data('rating'));
  return SetRatingStar();
});

var $coordination_rating = $('.coordination-rating .fa');
	$coordination_rating.on('click', function() {
  	$coordination_rating.siblings('input.rating-value').val($(this).data('rating'));
  	return SetRatingStar();
});

var $overall_rating = $('.overall-rating .fa');
	$overall_rating.on('click', function() {
  	$overall_rating.siblings('input.rating-value').val($(this).data('rating'));
  	return SetRatingStar();
});
SetRatingStar();
});
</script>
{{ html()->form()->close() }}
@endsection