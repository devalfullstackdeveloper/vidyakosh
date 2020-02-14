@extends('frontend.layouts.app'.config('theme_layout'))

@section('title', app_name() . ' | ' . __('labels.frontend.passwords.reset_password_box_title'))
@push('after-styles')
<style>
.about-page-section input[type="email"] {
    background: #d7e0e4;
}
.about-page-section {
    padding: 40px 0px;
}
.about-page-section .card-body {
    border: 1px solid #000;
}
</style>	
@endpush

@section('content')
<?//php $email='';$email = $_GET['data'];?>
  <!-- ================================
    START BREADCRUMB AREA
================================= -->
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
                    <h2 class="breadcrumb__title">{{__('labels.frontend.passwords.reset_password_box_title')}}</h2>
                   
                </div><!-- end breadcrumb-content -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end breadcrumb-area -->


    <section id="about-page" class="about-page-section pb-0">
        <div class="row justify-content-center align-items-center">
            <div class="col col-md-4 align-self-center">
                <div class="card border-0">

                    <div class="card-body">

                        @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ html()->form('POST', route('frontend.auth.password.email.post'))->open() }}
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->email('email')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.email'))
                                        ->attribute('maxlength', 191)
                                        ->required()
									    ->id('currentemail')
										->value('$email')
                                        ->autofocus() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-0 clearfix">
                                    <div class="text-center  text-capitalize">
                                        <button type="submit" class="nws-button btn-info btn "
                                                value="Submit">{{__('labels.frontend.passwords.send_password_reset_link_button')}}</button>
                                    </div>
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        {{ html()->form()->close() }}
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col-6 -->
        </div><!-- row -->
    </section>
@endsection
