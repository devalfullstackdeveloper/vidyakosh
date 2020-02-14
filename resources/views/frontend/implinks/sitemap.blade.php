@extends('frontend.layouts.app'.config('theme_layout'))
@section('title', 'Sitemap | '. app_name() )
@push('after-styles')
@endpush
@section('content')
<section class="breadcrumb-area">
      <div class="inner_home_icon">
                        <a href="{{url('/')}}">
                        <i class="fa fa-home"></i>
                    </a>
                    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content">
                    <h2 class="breadcrumb__title">Site Map</h2> 
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Inner Page Content -->
<section class="container-fluid pb-0 pt-5">
 <div class="container">
        <div class="row">
            <div class="col-lg-12">	
				<div class="sitemap">
				<h3 class="pb-3">Menu</h3>
				<ul>
					<li><a href="{{url('/')}}">Home</a></li>
					<li><a href="{{url('aboutus')}}">About us</a></li>
                    <li><a href="{{url('courses')}}">Courses</a></li>
                    <li><a href="{{url('contactus')}}">Contact Us</a></li>  
					<!--<li><a href="{{url('support')}}">support</a></li>-->
					<li><a href="{{url('privacy')}}">Website Policy  </a></li>
                    <li><a href="{{url('terms')}}">Terms of Use</a></li>
                    <li><a href="{{url('feedback')}}">Feedback</a></li>
                    <li><a href="{{url('sitemap')}}">Site Map</a></li>
                    <!--<li><a href="{{url('disclaimer')}}">Disclaimer</a></li>-->
				</ul>
			</div>
			</div>
			</div>
	 </div>
</section>

@endsection
