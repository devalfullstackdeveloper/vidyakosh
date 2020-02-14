@extends('frontend.layouts.app'.config('theme_layout'))
@section('title', 'Terms of Use | '. app_name() )
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
                    <h2 class="breadcrumb__title">Terms of Use</h2> 
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Inner Page Content -->
<section class="container-fluid pb-0 pt-5 inner_page_content">
 <div class="container">
        <div class="row">
            <div class="col-lg-12">			
				<h3 class="pb-3">Disclaimer</h3>
				<p class="pb-3">This Portal is designed, developed and hosted by National Informatics Centre, Government of India.</p>
				<p class="pb-3">Though all efforts have been made to ensure the accuracy and currency of the content on this Portal,the same should not be construed as a statement of law or used for any legal purposes. In no event will the Government or NIC be liable for any expense, loss or damage including, without limitation, indirect or consequential loss or damage, or any expense, loss or damage whatsoever arising from use, or loss of use, of data, arising out of or in connection with the use of this Portal.Links to other websites that have been included on this Portal are provided for public convenience only.</p>
					<p class="pb-3">Material featured on this Portal may be reproduced free of charge after taking proper permission by sending a mail to us. However, the material has to be reproduced accurately and not to be used in a derogatory manner or in a misleading context. Wherever the material is being published or issued to others, the source must be prominently acknowledged. However, the permission to reproduce this material shall not extend to any material which is identified as being copyright of a third party. Authorisation to reproduce such material must be obtained from the departments/copyright holders concerned.</p>
				<p class="pb-3">These terms and conditions shall be governed by and construed in accordance with the Indian Laws. Any dispute arising under these terms and conditions shall be subject to the exclusive jurisdiction of the courts of India.</p>
			</div>
			</div>
	 </div>
</section>

@endsection
