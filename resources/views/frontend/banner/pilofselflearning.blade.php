@extends('frontend.layouts.app'.config('theme_layout'))
@section('title', 'Capacity Building Pillars | '.app_name())
@section('meta_description', '')
@section('meta_keywords','')


@push('after-styles')
<style>
        /*.address-details.ul-li-block{*/
        /*line-height: 60px;*/
        /*}*/
        .teacher-img-content .teacher-social-name{
            max-width: 67px;
        }
        .my-alert{
            position: absolute;
            z-index: 10;
            left: 0;
            right: 0;
            top: 25%;
            width: 50%;
            margin: auto;
            display: inline-block; 
        } 
    #ticker01{
      overflow: hidden;
    }
.inner_home_icon {
    top: 4%;
}
    </style>
@endpush

@section('content')
<section class="slider-area zIn-9999">

  <div class="homepage-slide1">
     <div class="inner_home_icon">
                        <a href="{{url('/')}}">
                        <i class="fa fa-home"></i>
                    </a>
                    </div>
    <div class="single-slide-item slide-bg1">
      <div class="container">

     <!--  <div class="closeBox"><a href="{{url('/')}}">x</a></div> -->
       
      <div class="pillarsOfLearning">
      <h2>Capacity Building Pillars</h2>
      
      <div class="row">
      <!--box01-->
      <div class="col">
      
      <div class="pillarsOfLearningBox learningBox-1 up">
      <i class="vM"><img src="{{asset('assets/images/elearning.svg')}}"></i>
      <h5>E-Learnings</h5>
      <span class="vM">{{$coursescount}}</span>
      </div>
      </div>
       <!--./box01-->
        <!--box01-->
      <div class="col">
      
      <div class="pillarsOfLearningBox learningBox-2 up">
      <i class="vM"><img src="{{asset('assets/images/crt.svg')}}"></i>
      <h5>CRT's</h5>
      <span class="vM">{{$crttrainingcount}}</span>
      </div>
      </div>
       <!--./box01-->
        <!--box01-->
      <div class="col">
      
      <div class="pillarsOfLearningBox learningBox-3 up">
      <i class="vM"><img src="{{asset('assets/images/webinar.svg')}}"></i>
      <h5>Webinars</h5>
      <span class="vM">03</span>
      </div>
      </div>
       <!--./box01-->

         <!--box01-->
      <div class="col">
      
      <div class="pillarsOfLearningBox learningBox-5 up">
      <i class="vM"><img src="{{asset('assets/images/executive_briefing.svg')}}"></i>
      <h5>Executive Briefings</h5>
      <span class="vM">{{$executivebrifing}}</span>
      </div>
      </div>
       <!--./box01-->

        <!--box01-->
      <div class="col">
      
      <div class="pillarsOfLearningBox learningBox-4 up">
      <i class="vM"><img src="{{asset('assets/images/seminar.svg')}}"></i>
      <h5>Seminars</h5>
      <span class="vM">{{$seminarcount}}</span>
      </div>
      </div>
       <!--./box01-->
          
      
      </div>
      </div>
      </div>
    </div>
  </div>
</section>
@endsection