@extends('frontend.layouts.app'.config('theme_layout'))
@section('title', 'About Us | '. app_name() )
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
                    <h2 class="breadcrumb__title">About Us</h2> 
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
				<p class="pb-3">This is the official website of National Informatics Centre, the premier ICT Organization of Government of India. The website provides Information about the various capacity building programs being conducted/organised for NIC officers. This Website also provide information about the various E-learning Courses being made available to NIC officers.</p>
<p>The content of the site is being maintained by Training Division of NIC. It is our endeavor to continue the enhancement and enrichment of this site in terms of its content, coverage, design and technology on a regular basis.</p>
			</div>
			</div>
	 </div>
</section>
@endsection
