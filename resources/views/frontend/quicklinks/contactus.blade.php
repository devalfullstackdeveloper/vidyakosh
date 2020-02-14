@extends('frontend.layouts.app'.config('theme_layout'))
@section('title', 'Contact Us | '. app_name() )
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
                    <h2 class="breadcrumb__title">National Informatics Centre</h2> 
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Inner Page Content -->
<section class="container-fluid pb-0 pt-5 contactpage">
 <div class="container">
        <div class="row">
            <div class="col-md-3">
				  <div class="contact-block">
					  <div class="contact-icon">
						  <i class="fa fa-user"></i>
					  </div>
					  <br>
					  <h3>Web Information Manager</h3>					 
					  <h4>Shri Rajesh Kumar Pathak</h4>
					  <h5>Scientist-F</h5>
				</div>
			</div>
			     <div class="col-md-3">
				  <div class="contact-block">
					  <div class="contact-icon">
						  <i class="fa fa-phone"></i>
					  </div>
					  <br>
					  <h3>Telephone</h3>					
					  <h4>011-24305930</h4>
				</div>
			</div>
			    <div class="col-md-3">
				  <div class="contact-block">
					  <div class="contact-icon">
						  <i class="fa fa-envelope"></i>
					  </div>
					  <br>
					  <h3>Email</h3>					
					  <h4>vidya.kosh@nic.in</h4>
				</div>
			</div>
			    <div class="col-md-3">
				  <div class="contact-block">
					  <div class="contact-icon">
						  <i class="fa fa-map-marker"></i>
					  </div>
					  <br>
					  <h3>Office Address</h3>				
					  <h4>A-Block, CGO Complex, Lodhi Road,New Delhi - 110 003 India</h4>
				</div>
			</div>
			</div>
	 </div>
</section>


@endsection
