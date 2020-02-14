@extends('frontend.layouts.app'.config('theme_layout'))
@section('title', 'Website Policy | '. app_name() )
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
                    <h2 class="breadcrumb__title">Website Policy</h2> 
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
				<h3 class="pb-3">Hyperlinking Policy</h3>
				<p class="pb-3" style="color:#000"><strong>Links to external websites/portals</strong></p>
				<p class="pb-3">We do not object to you linking directly to the information that is hosted on our site and no prior permission is required for the same. However, we would like you to inform us about any links provided to our site so that you can be informed of any changes or updations therein. Also, we do not permit our pages to be loaded into frames on your site. Our website’s pages must load into a newly opened browser window of the user.</p>
				<br>
				<h3 class="pb-3">Copyright Policy</h3>
				<p class="pb-3">Material featured on this Portal may be reproduced free of charge after taking proper permission by sending a mail to us. However, the material has to be reproduced accurately and not to be used in a derogatory manner or in a misleading context. Wherever the material is being published or issued to others, the source must be prominently acknowledged. However, the permission to reproduce this material shall not extend to any material which is identified as being copyright of a third party. Authorisation to reproduce such material must be obtained from the departments/copyright holders concerned.</p>
				<p class="pb-3">These terms and conditions shall be governed by and construed in accordance with the Indian Laws. Any dispute arising under these terms and conditions shall be subject to the exclusive jurisdiction of the courts of India.</p>
			</div>
			</div>
	 </div>
</section>

@endsection
