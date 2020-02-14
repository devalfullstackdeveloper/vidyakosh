@extends('frontend.layouts.app'.config('theme_layout'))
@section('title', 'Feedback | '. app_name() )
@push('after-styles')
<style>
	msg-error {
  color: #c65848;
}
.g-recaptcha.error {
  border: solid 2px #c64848;
  padding: .2em;
  width: 19em;
}
	</style>
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
                    <h2 class="breadcrumb__title">Feedback</h2> 
                </div>
					
            </div>
        </div>
    </div>
</section>
<!-- Inner Page Content -->
<section class="container-fluid pb-0 pt-5">
 <div class="container">
        <div class="row">
            <div class="col-md-12">
				  <div class="feedback_form">				 
					  <h3 class="pb-4 text-center">Feedback Form</h3>
					  @if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					  <form method ="get" action="{{route('UserFeedbacksave')}}">
					  <div class="row">
						  <div class="col-md-6">
							  <div class="form-group">
								  <label>Your Name <span class="red">*</span></label>
						  <input type="text" name="name" placeholder="Your name here" class="form-control">
							  </div>
						  </div>
						   <div class="col-md-6">
							  <div class="form-group">
								  <label>Your Email <span class="red">*</span></label>
						  <input type="email" name="email" name placeholder="Your email here" class="form-control">
							  </div>
						  </div>
					  </div>
					    <div class="row">
						  <div class="col-md-12">
							  <div class="form-group">
								  <label>Subject <span class="red">*</span></label>
								  <select class="form-control" name="subject">
									  <option disabled selected>Select</option>
									  <option value="1">E-Learnings</option>
									  <option value="2">CRT's</option>
									  <option value="3">Webinars</option>
									  <option value="4">Executive Briefings</option>
									  <option value="5">Seminars</option>
								  </select>
							  </div>
						  </div>
					</div>
					      <div class="row">
						  <div class="col-md-12">
							  <div class="form-group">
								  <label>Your Feedback<span class="red">*</span> (Max character limit 200)</label>
								  <textarea class="form-control" name="feedback" placeholder="Your feedback here"></textarea>
							  </div>
						  </div>
					</div>
					  	<div class="row">
							
								<div class="col-md-6">
									<div id="google_recaptcha" class="g-recaptcha" data-sitekey="6LfxnNIUAAAAADNeutB797f7tXsyj1F4ztc0beIw">
									</div>
										<span class="msg-error error" style="color:red;"></span>
							<!--<div id="recaptcha" class="g-recaptcha" data-sitekey="6LfxnNIUAAAAADNeutB797f7tXsyj1F4ztc0beIw"></div>-->
						<!--	<div class="row mt-4">
								<div class="col-md-9 pr-0">
									<input type="text" class="custom_captcha_text text-center form-control" disabled>
								</div>
								<div class="col-md-3 pl-0">
									<a style="border-style: none;" href="javascript:void(0);">
										<img src="{{asset('assets/images/refresh.png')}}" alt="" onclick="ReloadCaptcha()" style="vertical-align: middle; height: 32px; width: 32px; border: 0px;margin-left:10px;" align="bottom">
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								 <label>Enter code <span class="red">*</span></label>
								<input type="text" name="yours_captcha" placeholder="Code here" class="form-control">
							</div>-->
								</div>
							<div class="col-md-6">
								<button id="btn_validate" type="button" class="btn btn-primary btn-feedback">Validate reCAPTCHA</button>
							</div>
						</div>
					      <div class="row">
						  <div class="col-md-12 text-center">
							<div class="form-check mt-2 mb-4">
								<input type="checkbox" name="agree" class="form-check-input" value="1">
		<span class="form-check-label agree-lable" for="yours_agree">I agree to the <a href="javascript:void(0);" class="termtxt">terms of service</a></span>
						</div>
						</div>
						
					</div>
						  
					  <div class="bst-row">
						<div class="col-md-12 text-center">
							<div class="form-group">
								<button id="btn_submit" class="btn btn-primary btn-feedback"  type="submit" style="display:none;">Submit</button>
							</div>
						</div>
					</div>
					  </form>
				</div>
			</div>
			</div>
	 </div>
</section>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
$('#btn_validate').click(function(){
  var $captcha = $('#google_recaptcha' ),
      response = grecaptcha.getResponse();
  
  if (response.length === 0) {
    $('.msg-error').text("reCAPTCHA is mandatory");
    if( !$captcha.hasClass("error") ){
      $captcha.addClass("error");
    }
  } else {
    $('.msg-error').text('');
    $captcha.removeClass("error");
	$('#btn_submit').show();
	$('#btn_validate').hide();  
    //alert('reCAPTCHA marked');
  }
})

</script>

@endsection
