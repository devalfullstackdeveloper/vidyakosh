<!DOCTYPE html>
@langrtl
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @endlangrtl
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @if(config('favicon_image') != "")
            <link rel="shortcut icon" type="image/x-icon" href="{{asset('storage/logos/'.config('favicon_image'))}}"/>
        @endif
        <title>@yield('title', app_name())</title>

        <meta name="description" content="@yield('meta_description', '')">
        <meta name="keywords" content="@yield('meta_keywords', '')">

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

    <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
       
              <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
              <link rel="stylesheet" href="{{asset('assets/css/Chart.min.css')}}">
              <link rel="stylesheet" href="{{asset('assets/css/flexslider.css')}}">
              <link rel="stylesheet" href="{{asset('assets/css/font-awesome.css')}}">
              <link rel="stylesheet" href="{{asset('assets/css/line-awesome.css')}}">
	      <link rel="stylesheet" href="{{asset('assets/css/flaticon.css')}}">
              <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
              <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
              <link rel="stylesheet" href="{{asset('assets/css/frontend.css')}}">
              <link rel="stylesheet" href="{{asset('assets/css/style_new.css')}}">
              <link rel="stylesheet" href="{{asset('assets/css/app.css')}}">
              <link rel="stylesheet" href="{{asset('assets/css/util.css')}}">
              <link rel="stylesheet" href="{{asset('assets/js/carousel/owl.carousel.css')}}">
              <link rel="stylesheet" href="{{asset('assets/js/carousel/owl.theme.css')}}">		
		 <link rel="stylesheet" href="{{asset('assets/css/tooltipster.bundle.min.css')}}">
                
                 <!-- <link rel="stylesheet" href="{{asset('assets/js/tabs/tabs.css')}}">
                 <link rel="stylesheet" href="{{asset('assets/js/tabs/tabs1.css')}}">
                 <link rel="stylesheet" href="{{asset('assets/js/tabs/tabs2.css')}}"> -->

        @yield('css')
        @stack('after-styles')

        @if(config('onesignal_status') == 1)
            {!! config('onesignal_data') !!}
        @endif

        @if(config('google_analytics_id') != "")
    <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id={{config('google_analytics_id')}}"></script> 
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{config('google_analytics_id')}}');
        </script>
            @endif

      <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body class="{{config('layout_type')}}">

    <div id="app">
    {{--<div id="preloader"></div>--}}
   
    <!--======================================
        START HEADER AREA
    ======================================-->
<section class="header-menu-area" id="header">
    <div class="header-menu-fluid">
        <div class="headerTop">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="header-widget header-widget1">
                            <ul class="contact-info d-flex align-items-center">
                                <li><a href="tel:01124305930"><span class="la la-phone"></span> 011-24305930</a> </li>
                                <li><a href="mailto:vidya.kosh@nic.in"><span class="la la-envelope-o"></span> vidya.kosh@nic.in</a></li>
                            </ul>
                        </div><!-- end header-widget -->
                    </div><!-- end col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="header-widget header-widget2 d-flex align-items-center justify-content-end">
                            <div class="header-right-info">
                                <ul class="social-info d-flex align-items-center">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                            <div class="header-right-info d-flex align-items-center">
                                <ul class="user-cart d-flex align-items-center ">
                                    <li>
                                        <span class="user-cart-btn"><img src="{{asset('assets/images/icon2.png')}}"></span>
                                        <ul class="dropdown-menu-item shopping-cart-list">
                                            <li><a href="javascript:;" class="increaseFont" title="Increase font size">A<sup>+</sup></a></li>
                                            <li><a href="javascript:;" class="resetFont" title="Reset font size">A</a></li>
                                            <li><a href="javascript:;" class="decreaseFont" title="Decrease font size">A<sup>-</sup></a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul class="user-cart d-flex align-items-center ">
                                 <li>
                                   @if(count($locales) > 1)
                                   <span class="user-cart-btn">@lang('menus.language-picker.language')
                                    ({{ strtoupper(app()->getLocale()) }})</span>
                                        <ul class="dropdown-menu-item shopping-cart-list">
                                            @foreach($locales as $lang)
                                            @if($lang != app()->getLocale())
                                              <li>
                                                <a href="{{ url('lang/'.$lang) }}"
                                                   class=""> @lang('menus.language-picker.langs.'.$lang)</a>
                                              </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                </ul>
                                
                                <ul class="user-action d-flex align-items-center">
                                    @if (Auth::guest())
         <li><a id="openLoginModal" data-target="#myModal" href="javascript:void(0)">Login</a></li>
         @endif

         @if (Auth::check())
         
          <div class="dropdown welcomePanel"> <i class="fa fa-user"></i><a href="javascript:void(0);" data-toggle="dropdown">Welcome </a>
          <ul class="dropdown-content menuPanelDown">
            <li class="adminProfileBox">
            <div class="welcomePanelImgBox">
               <img src="{{asset('assets/images/user.jpg')}}">
              <p>{{ $logged_in_user->name }} </p>
             </div>
             <div class="welcomePanelBtnPanel">
             <div class="row">
              <div class="col-6"> 
             <a href="{{url('user/dashboard')}}" class="btn btn-info">Dashboard</a>
           </div>
           <div class="col-6">
             <a id="" data-target="" class="btn btn-primary"
          href="{{url('logout')}}">Logout</a>
        </div>
            </div>
            </div>
            </li>
           </ul>
        </div>

        
        
         @endif
      
                                  </ul>
                            </div>
                        </div><!-- end header-widget -->
                    </div><!-- end col-lg-6 -->
                </div><!-- end row -->
            </div><!-- end container-fluid -->
        </div><!-- end header-top -->
        <div class="header-menu-content">
            <div class="container-fluid">
                <div class="row align-items-center main-menu-content">
                    <div class="col-lg-7">
                        <div class="logo-box">
                          @if(isset($logo))
                        <img src="{{asset('assets/images/govt.png')}}"/> <a href="{{url('/')}}" class="logo"><img src="{{asset('assets/images/'.$logo)}}"></a>
                         @else
       
                       <img src="{{asset('assets/images/govt.png')}}"/><a href="{{url('/')}}" class="logo"> <img src="{{asset('assets/images/nic.png')}}"></a>
       
                        @endif
                        
                       <div class="dropdown dropdownMinistry">
            @if(isset($ministry->ministry_name))
            <button class="dropbtn ministri oneministry " id="ministri" value ="{{$ministry->ministry_name}}"><span>{{$ministry->ministry_name}}</span> <i class="fa fa-chevron-down" style="font-size:10px;"></i></button>
            @else
            <button class="dropbtn ministri oneministry " id="ministri" value ="Defence Ministry"><span>Defence Ministry</span> <i class="fa fa-chevron-down" style="font-size:10px;"></i></button>
            @endif
            @if(isset($allministry))
            <div class="dropdown-content selectedValue"> 
            @foreach($allministry as $ministries)
            <a href="#" class="ministry " id="ministrybuttontext">{{$ministries->ministry_name}}</a>
            @endforeach</div>
            @else
            <div class="dropdown-content selectedValue">
            <a href="#" class="ministry " id="ministrybuttontext">Defence Ministry</a>
            </div>
            @endif
          </div>
          <div class="dropdown shift-left dropdownMinistry">
            @if(isset($departments->department_name))
            <button id="departmentbuttontext" class="dropbtn">{{$departments->department_name}}<i class="fa fa-chevron-down" style="font-size:10px;"></i></button>
            @else
             <button id="departmentbuttontext" class="dropbtn">Press Department<i class="fa fa-chevron-down" style="font-size:10px;"></i></button>
             @endif

        
         <!-- <div class="dropdown-content ministri" id="min"></div> -->
             <div class="dropdown-content ministri selectedValue" id="min">
             @if(isset($alldepartments)) 
                @foreach($alldepartments as $department)
                <a href="#" class="">{{$department->department_name}}</a>
                @endforeach
                @else
                 <a href="#" class="">All Department</a>
                @endif
              </div>
          </div>
            <div class="header-category ml-2">
                    <ul>
                       <li>
                            <a data-target="#howItWorkModal" data-toggle="modal" href="javascript:void(0)" charset="pb-0"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> How it Works</a>
                         </li>
                    </ul>
                </div> 
            </div>
					
						
                    </div><!-- end col-lg-3 -->
                    <div class="col-lg-5">
                        <div class="menu-wrapper">							
                            <div class="contact-form-action">
                                <!--Contact Form-->

                                <form action="{{route('search-course')}}" method="get">
                                    <div class="row">
                                        <div class="col-lg-12 form-group">
                                            <input class="form-control" type="search" name="q" placeholder="Search for Courses" autocomplete="off">
                                            <button class="la la-search search-icon"
                                        type="submit" ></button>
                                            
                                        </div><!-- end col-lg-6 -->
                                    </div><!-- end row -->
                                </form>

                            </div><!-- end contact-form-action -->
							
							<ul class="user-action d-flex align-items-center">
                                    @if (Auth::guest())
         <li><a id="openLoginModal" data-target="#myModal" href="javascript:void(0)">Login</a></li>
         @endif

         @if (Auth::check())
         
          <div class="dropdown welcomePanel"> <i class="fa fa-user"></i><a href="javascript:void(0);" data-toggle="dropdown">Welcome </a>
          <ul class="dropdown-content menuPanelDown">
            <li class="adminProfileBox">
            <div class="welcomePanelImgBox">
               <img src="{{asset('assets/images/user.jpg')}}">
              <p>{{ $logged_in_user->name }} </p>
             </div>
             <div class="welcomePanelBtnPanel">
             <div class="row">
              <div class="col-6"> 
             <a href="{{url('user/dashboard')}}" class="btn btn-info">Dashboard</a>
           </div>
           <div class="col-6">
             <a id="" data-target="" class="btn btn-primary"
          href="{{url('logout')}}">Logout</a>
        </div>
            </div>
            </div>
            </li>
           </ul>
        </div>

        
        
         @endif
      
                                  </ul>
                           
                            <div class="logo-right-button">
                                <ul class="row" style="margin:0;">
                                    
                                     <li style="padding-top:10px; margin-left:15px;"><img src="{{asset('assets/images/vidya_kosh.png')}}">	</li>
                                </ul>
                                <div class="side-menu-open">
                                    <span class="menu__bar"></span>
                                    <span class="menu__bar"></span>
                                    <span class="menu__bar"></span>
                                </div>
                            </div><!-- end logo-right-button -->
                         
                        </div><!-- end menu-wrapper -->
                    </div><!-- end col-lg-9 -->
                </div><!-- end row -->
            </div><!-- end container-fluid -->
        </div><!-- end header-menu-content -->
    </div><!-- end header-menu-fluid -->
</section><!-- end header-menu-area -->
<!--======================================
        END HEADER AREA
======================================-->


        @yield('content')
        @include('cookieConsent::index')

 @include('frontend.layouts.modals.loginModal')
		
<div class="modal fade" id="howItWorkModal" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top:2px!important;">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                 <div class="modal-header backgroud-style">
 <button type="button" class="close hide-modal" data-dismiss="modal">&times;</button>
                    <div class="gradient-bg"></div>
                    <div class="popup-logo">
                        <img src="{{asset('assets/images/nic1.png')}}" alt="">
                    </div>
                    <div class="popup-text text-center">
                        @if(isset($logo))
                        <p><img src="{{asset('assets/images/'.$logo)}}"></p>
                        @else
                        <p><img src="{{asset('assets/images/nic.png')}}"></p>
                        @endif
                    </div>
                   

                </div>

                <!-- Modal body --> 
                <div class="modal-body" style="padding: 30px;">                   
                   <iframe src="https://www.youtube-nocookie.com/embed/fUiZPKZivnw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>                  
                </div>
            </div>
        </div>
    </div>			
		
<!-- ================================
       START BLOG AREA
================================= -->
<!-- <section class="blog-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    
                    <h2 class="section__title section__title2">Exclusive Features</h2>
                    <span class="section__divider section__divider2"></span>
                </div>
            </div>
        </div>
        <div class="row blog-post-wrapper">
            <div class="col-lg-12">
                <div class="blog-post-carousel pt-0" id="exclusiveFeatures">
                <div class="col-12">
                    <div class="blog-post-item">
                        <div class="blog-post-img">
                            <img src="{{asset('assets/images/img50.jpg')}}" alt="blog image" class="blog__img">
                           
                        </div>
                        <div class="post-body">
                            <div class="blog-title">
                                <a href="blog-single.html" class="blog__title">
                                    Capacity Building
                                </a>
                            </div>
                            
                        </div>
                    </div>
                  </div>  
                    
                    <div class="col-12">
                    <div class="blog-post-item">
                        <div class="blog-post-img">
                            <img src="{{asset('assets/images/img51.jpg')}}" alt="blog image" class="blog__img">
                            
                        </div>
                        <div class="post-body">
                            <div class="blog-title">
                                <a href="blog-single.html" class="blog__title">
                                    Individual Grooming
                                </a>
                            </div>
                            
                        </div>
                    </div>
                    </div>
                  
                    <div class="col-12">
                    <div class="blog-post-item">
                        <div class="blog-post-img">
                            <img src="{{asset('assets/images/img52.jpg')}}" alt="blog image" class="blog__img">
                           
                        </div>
                        <div class="post-body">
                            <div class="blog-title">
                                <a href="blog-single.html" class="blog__title">
                                   Multi Platform Accesibility
                                </a>
                            </div>
                            
                        </div>
                    </div>
                    </div>
                 
                    <div class="col-12">
                    <div class="blog-post-item">
                        <div class="blog-post-img">
                            <img src="{{asset('assets/images/img53.jpg')}}" alt="blog image" class="blog__img">
                         
                        </div>
                        <div class="post-body">
                            <div class="blog-title">
                                <a href="blog-single.html" class="blog__title">
                                    Self Assesment
                                </a>
                            </div>
                            
                        </div>
                    </div>
                    </div>
                    <div class="col-12">
                    <div class="blog-post-item">
                        <div class="blog-post-img">
                            <img src="{{asset('assets/images/img54.jpg')}}" alt="blog image" class="blog__img">
                           
                        </div>
                        <div class="post-body">
                            <div class="blog-title">
                                <a href="blog-single.html" class="blog__title">
                                    PAN India Access
                                </a>
                            </div>
                            
                        </div>
                    </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>--> 
<!-- ================================
       START BLOG AREA
================================= -->

  <!-- ================================
       START CLIENTLOGO AREA
================================= -->
<section class="clientlogo-area">
    <div class="stroke-line">
        <span class="stroke__line"></span>
        <span class="stroke__line"></span>
        <span class="stroke__line"></span>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="client-logo pt-0" id="footerSlider">
                    <div class="client-logo-item">
                        <a href="#"><img src="{{asset('assets/images/logo/01.png')}}"></a>
                    </div><!-- end client-logo-item -->
                    <div class="client-logo-item">
                        <a href="#"><img src="{{asset('assets/images/logo/02.png')}}"></a>
                    </div><!-- end client-logo-item -->
                    <div class="client-logo-item">
                        <a href="#"><img src="{{asset('assets/images/logo/03.png')}}"></a>
                    </div><!-- end client-logo-item -->
                    <div class="client-logo-item">
                        <a href="#"><img src="{{asset('assets/images/logo/04.png')}}"></a>
                    </div><!-- end client-logo-item -->
                    <div class="client-logo-item">
                        <a href="#"><img src="{{asset('assets/images/logo/05.png')}}"></a>
                    </div><!-- end client-logo-item -->
                    <div class="client-logo-item">
                        <a href="#"><img src="{{asset('assets/images/logo/06.png')}}"></a>
                    </div><!-- end client-logo-item -->
                    <div class="client-logo-item">
                        <a href="#"><img src="{{asset('assets/images/logo/07.png')}}"></a>
                    </div><!-- end client-logo-item -->
                </div><!-- end client-logo -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container -->
    <div class="stroke-line2">
        <span class="stroke__line"></span>
        <span class="stroke__line"></span>
        <span class="stroke__line"></span>
    </div>
</section><!-- end clientlogo-area -->
<!-- ================================
       START CLIENTLOGO AREA
================================= -->

        @include('frontend.layouts.partials.footer')

    </div><!-- #app -->

    <!-- Scripts -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script> 
    <script src="{{asset('assets/js/popper.min.js')}}"></script> 
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script> 
    <script src="{{asset('assets/js/carousel/owl.carousel.js')}}"></script> 
    <script src="{{asset('assets/js/tabs/tabs.js')}}"></script> 
    <script src="{{asset('assets/js/theme.js')}}"></script> 
    <script src="{{asset('assets/js/Chart.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.flexslider.js')}}"></script>
     <script src="{{asset('assets/js/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('assets/js/particles.min.js')}}"></script>
	<script src="{{asset('assets/js/particlesRun.js')}}"></script>
	<script src="{{asset('assets/js/fancybox.js')}}"></script>
	<script src="{{asset('assets/js/wow.js')}}"></script>
	<script src="{{asset('assets/js/cokie.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.easing.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/jquery.easy-ticker.js')}}"></script>
	<script src="{{asset('assets/js/charts/highcharts.js')}}"></script>
	<script src="{{asset('assets/js/charts/data.js')}}"></script>
	<script src="{{asset('assets/js/charts/drilldown.js')}}"></script>
	<script src="{{asset('assets/js/charts/exporting.js')}}"></script>
	<script src="{{asset('assets/js/charts/export-data.js')}}"></script>
	<script src="{{asset('assets/js/charts/accessibility.js')}}"></script>
    <script src="{{asset('assets/js/chart.js')}}"></script> 
    <script src="{{asset('assets/js/tooltipster.bundle.min.js')}}"></script>
		
		
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>


   
   <script type="text/javascript">
	   
	   $("#drop_select1").change(function(){
    if($(this).val() == 3){
      $("#drop_select2").show();
    }else{
      $("#drop_select2").hide();
    }
    
});
     
  $(document).on("scroll", function(){
    if
      ($(document).scrollTop() > 100){
      $("#header").addClass("shrink");
    }
    else
    {
      $("#header").removeClass("shrink");
    }
  });
	   
	     // Hide modal on button click
    $(".hide-modal").click(function(){
        $("#howItWorkModal").modal('hide');
    });
   </script>
    
    <script>
  $(document).ready(function(){
    $('.selectedValue a').on('click', function() {
      var getValue = $(this).text();
      $('.oneministry span').text(getValue);
      $('#departmentbuttontext').text('Select Department');
    });   
  });
</script>

    <script type="text/javascript">
$(document).ready(function(){
    $(".ministry").click(function(){
      var baseUrl = "{{URL::to('/')}}";
     $("#min").empty();
     var baseUrl = "{{URL::to('/')}}";
      var allministry  = $(this).text();
      $.ajax({
            type: 'get',
            url: baseUrl+'/getdepartment',
            data: {allministry: allministry},
            success: function(result) {
                html = '';
                // $.each(JSON.parse(result), function () {
                   $.each(JSON.parse(result), function () {
                      var id = (this.id);  
                      var ministryid = (this.ministry_id);
                      var departmentname = (this.department_name);
                    html+= '<a href="" class="">'+departmentname+'</a>';
                });
                 $("#min").append(html);
            }
        });
    });
    });
    </script>
    <script>
    $(document).ready(function(){
        $("div#min" ).on( "click", "a", function() {
          var baseUrl = "{{URL::to('/')}}";
        var department = $(this).text();
         $.ajax({
             type: 'get',
             url: baseUrl+'/getdptname',
             data: {department: department},
             success: function(result) {
              //location.reload(baseUrl); 
             window.location.href = baseUrl;
             }
          });
        });
    });  
    </script>
   
    <!--script>
        @if(request()->has('user')  && (request('user') == 'admin'))

        $('#myModal').modal('show');
        $('#loginForm').find('#email').val('admin@lms.com')
        $('#loginForm').find('#password').val('secret')

        @elseif(request()->has('user')  && (request('user') == 'student'))

        $('#myModal').modal('show');
        $('#loginForm').find('#email').val('student@lms.com')
        $('#loginForm').find('#password').val('secret')

        @elseif(request()->has('user')  && (request('user') == 'teacher'))

        $('#myModal').modal('show');
        $('#loginForm').find('#email').val('teacher@lms.com')
        $('#loginForm').find('#password').val('secret')

        @endif
    </script-->
    <script src="{{asset('assets/js/script.js')}}"></script>
    <script>
        @if((session()->has('show_login')) && (session('show_login') == true))
        $('#myModal').modal('show');
                @endif
        var font_color = "{{config('font_color')}}"
        setActiveStyleSheet(font_color);
    </script>

    @yield('js')

    @stack('after-scripts')

    @include('includes.partials.ga')
    <script>
$(document).ready(function(){
    $('.section-4 .item').hover(function(){
    $('.hover_effect').show()   
    });
    
    $('.section-4 .item').mouseleave(function(){
    $('.hover_effect').hide()   
    });
    
    });
</script> 
<script>
$(document).ready(function(){
    $('.blackBtnBox').click(function(){
        $(this).hide();
        $('.whiteBtnBox').show();
        });
        
            $('.whiteBtnBox').click(function(){
        $(this).hide();
        $('.blackBtnBox').show();
        });
    
    });
    </script> 
<script>
$(document).ready(function(){
    $('.finBoxBtn-1').click(function(){
        
        $('.finBox-1').show();
         $('.finBox-2,.finBox-3,.finBox-4,.finBox-5,.finBox-6,.finBox-7,.finBox-8,.finBox-9,.finBox-10,.finBox-11,.finbox-12,.finbox-13,.finbox-14,.finbox-15,.finbox-16,.finbox-17,.finbox-18,.finbox-19,.finbox-20,.finbox-21,.finbox-22, .finbox-23,.finbox-24,.finbox-25,.finbox-26,.finbox-27,.finbox-28,.finbox-29,.finbox-30,.finbox-31,.finbox-32,.finbox-33,.finbox-34,.finbox-35,.finbox-36,.finbox-37,.finbox-38,.finbox-39,.finbox-40,.finbox-41,.finbox-42,.finbox-43,.finbox-44,.finbox-45').hide();
        });
        
        $('.finBoxBtn-2').click(function(){
        
        $('.finBox-2').show();
         $('.finBox-1,.finBox-3,.finBox-4,.finBox-5,.finBox-6,.finBox-7,.finBox-8,.finBox-9,.finBox-10,.finBox-11,.finbox-12,.finbox-13,.finbox-14,.finbox-15,.finbox-16,.finbox-17,.finbox-18,.finbox-19,.finbox-20,.finbox-21,.finbox-22, .finbox-23,.finbox-24,.finbox-25,.finbox-26,.finbox-27,.finbox-28,.finbox-29,.finbox-30,.finbox-31,.finbox-32,.finbox-33,.finbox-34,.finbox-35,.finbox-36,.finbox-37,.finbox-38,.finbox-39,.finbox-40,.finbox-41,.finbox-42,.finbox-43,.finbox-44,.finbox-45').hide();
        });
        
        $('.finBoxBtn-3').click(function(){
        
        $('.finBox-3').show();
         $('.finBox-1,.finBox-2,.finBox-4,.finBox-5,.finBox-6,.finBox-7,.finBox-8,.finBox-9,.finBox-10,.finBox-11,.finbox-12,.finbox-13,.finbox-14,.finbox-15,.finbox-16,.finbox-17,.finbox-18,.finbox-19,.finbox-20,.finbox-21,.finbox-22, .finbox-23,.finbox-24,.finbox-25,.finbox-26,.finbox-27,.finbox-28,.finbox-29,.finbox-30,.finbox-31,.finbox-32,.finbox-33,.finbox-34,.finbox-35,.finbox-36,.finbox-37,.finbox-38,.finbox-39,.finbox-40,.finbox-41,.finbox-42,.finbox-43,.finbox-44,.finbox-45').hide();
        });
        
        $('.finBoxBtn-4').click(function(){
        
        $('.finBox-4').show();
         $('.finBox-1,.finBox-2,.finBox-3,.finBox-5,.finBox-6,.finBox-7,.finBox-8,.finBox-9,.finBox-10,.finBox-11,.finbox-12,.finbox-13,.finbox-14,.finbox-15,.finbox-16,.finbox-17,.finbox-18,.finbox-19,.finbox-20,.finbox-21,.finbox-22, .finbox-23,.finbox-24,.finbox-25,.finbox-26,.finbox-27,.finbox-28,.finbox-29,.finbox-30,.finbox-31,.finbox-32,.finbox-33,.finbox-34,.finbox-35,.finbox-36,.finbox-37,.finbox-38,.finbox-39,.finbox-40,.finbox-41,.finbox-42,.finbox-43,.finbox-44,.finbox-45').hide();
        });
        
        $('.finBoxBtn-5').click(function(){
        
        $('.finBox-5').show();
         $('.finBox-1,.finBox-2,.finBox-3,.finBox-4,.finBox-6,.finBox-7,.finBox-8,.finBox-9,.finBox-10,.finBox-11,.finbox-12,.finbox-13,.finbox-14,.finbox-15,.finbox-16,.finbox-17,.finbox-18,.finbox-19,.finbox-20,.finbox-21,.finbox-22, .finbox-23,.finbox-24,.finbox-25,.finbox-26,.finbox-27,.finbox-28,.finbox-29,.finbox-30,.finbox-31,.finbox-32,.finbox-33,.finbox-34,.finbox-35,.finbox-36,.finbox-37,.finbox-38,.finbox-39,.finbox-40,.finbox-41,.finbox-42,.finbox-43,.finbox-44,.finbox-45').hide();
        });
        
        $('.finBoxBtn-6').click(function(){
        
        $('.finBox-6').show();
         $('.finBox-1,.finBox-2,.finBox-3,.finBox-4,.finBox-5,.finBox-7,.finBox-8,.finBox-9,.finBox-10,.finBox-11,.finbox-12,.finbox-13,.finbox-14,.finbox-15,.finbox-16,.finbox-17,.finbox-18,.finbox-19,.finbox-20,.finbox-21,.finbox-22, .finbox-23,.finbox-24,.finbox-25,.finbox-26,.finbox-27,.finbox-28,.finbox-29,.finbox-30,.finbox-31,.finbox-32,.finbox-33,.finbox-34,.finbox-35,.finbox-36,.finbox-37,.finbox-38,.finbox-39,.finbox-40,.finbox-41,.finbox-42,.finbox-43,.finbox-44,.finbox-45').hide();
        });
     
        $('.finBoxBtn-7').click(function(){
        
        $('.finBox-7').show();
         $('.finBox-1,.finBox-2,.finBox-3,.finBox-4,.finBox-5,.finBox-6,.finBox-8,.finBox-9,.finBox-10,.finBox-11,.finbox-12,.finbox-13,.finbox-14,.finbox-15,.finbox-16,.finbox-17,.finbox-18,.finbox-19,.finbox-20,.finbox-21,.finbox-22, .finbox-23,.finbox-24,.finbox-25,.finbox-26,.finbox-27,.finbox-28,.finbox-29,.finbox-30,.finbox-31,.finbox-32,.finbox-33,.finbox-34,.finbox-35,.finbox-36,.finbox-37,.finbox-38,.finbox-39,.finbox-40,.finbox-41,.finbox-42,.finbox-43,.finbox-44,.finbox-45').hide();
        });
        
        $('.finBoxBtn-8').click(function(){
        
        $('.finBox-8').show();
         $('.finBox-1,.finBox-2,.finBox-3,.finBox-4,.finBox-5,.finBox-6,.finBox-7,.finBox-9,.finBox-10,.finBox-11,.finbox-12,.finbox-13,.finbox-14,.finbox-15,.finbox-16,.finbox-17,.finbox-18,.finbox-19,.finbox-20,.finbox-21,.finbox-22, .finbox-23,.finbox-24,.finbox-25,.finbox-26,.finbox-27,.finbox-28,.finbox-29,.finbox-30,.finbox-31,.finbox-32,.finbox-33,.finbox-34,.finbox-35,.finbox-36,.finbox-37,.finbox-38,.finbox-39,.finbox-40,.finbox-41,.finbox-42,.finbox-43,.finbox-44,.finbox-45').hide();
        });
        
        $('.finBoxBtn-9').click(function(){
        
        $('.finBox-9').show();
         $('.finBox-1,.finBox-2,.finBox-3,.finBox-4,.finBox-5,.finBox-6,.finBox-7,.finBox-8,.finBox-10,.finBox-11,.finbox-12,.finbox-13,.finbox-14,.finbox-15,.finbox-16,.finbox-17,.finbox-18,.finbox-19,.finbox-20,.finbox-21,.finbox-22, .finbox-23,.finbox-24,.finbox-25,.finbox-26,.finbox-27,.finbox-28,.finbox-29,.finbox-30,.finbox-31,.finbox-32,.finbox-33,.finbox-34,.finbox-35,.finbox-36,.finbox-37,.finbox-38,.finbox-39,.finbox-40,.finbox-41,.finbox-42,.finbox-43,.finbox-44,.finbox-45').hide();
        });
        
        $('.finBoxBtn-10').click(function(){
        
        $('.finBox-10').show();
         $('.finBox-1,.finBox-2,.finBox-3,.finBox-4,.finBox-5,.finBox-6,.finBox-7,.finBox-8,.finBox-9,.finBox-11,.finbox-12,.finbox-13,.finbox-14,.finbox-15,.finbox-16,.finbox-17,.finbox-18,.finbox-19,.finbox-20,.finbox-21,.finbox-22, .finbox-23,.finbox-24,.finbox-25,.finbox-26,.finbox-27,.finbox-28,.finbox-29,.finbox-30,.finbox-31,.finbox-32,.finbox-33,.finbox-34,.finbox-35,.finbox-36,.finbox-37,.finbox-38,.finbox-39,.finbox-40,.finbox-41,.finbox-42,.finbox-43,.finbox-44,.finbox-45').hide();
        });
        
        $('.finBoxBtn-11').click(function(){
        
        $('.finBox-11').show();
         $('.finBox-1,.finBox-2,.finBox-3,.finBox-4,.finBox-5,.finBox-6,.finBox-7,.finBox-8,.finBox-9,.finBox-10,.finbox-12,.finbox-13,.finbox-14,.finbox-15,.finbox-16,.finbox-17,.finbox-18,.finbox-19,.finbox-20,.finbox-21,.finbox-22, .finbox-23,.finbox-24,.finbox-25,.finbox-26,.finbox-27,.finbox-28,.finbox-29,.finbox-30,.finbox-31,.finbox-32,.finbox-33,.finbox-34,.finbox-35,.finbox-36,.finbox-37,.finbox-38,.finbox-39,.finbox-40,.finbox-41,.finbox-42,.finbox-43,.finbox-44,.finbox-45').hide();
        });
        
        $('.finBoxBtn-12').click(function(){
        
        $('.finBox-12').show();
         $('.finBox-1,.finBox-2,.finBox-3,.finBox-4,.finBox-5,.finBox-6,.finBox-7,.finBox-8,.finBox-9,.finBox-10,.finBox-11,.finbox-13,.finbox-14,.finbox-15,.finbox-16,.finbox-17,.finbox-18,.finbox-19,.finbox-20,.finbox-21,.finbox-22, .finbox-23,.finbox-24,.finbox-25,.finbox-26,.finbox-27,.finbox-28,.finbox-29,.finbox-30,.finbox-31,.finbox-32,.finbox-33,.finbox-34,.finbox-35,.finbox-36,.finbox-37,.finbox-38,.finbox-39,.finbox-40,.finbox-41,.finbox-42,.finbox-43,.finbox-44,.finbox-45').hide();
        });
        

        $('.finBoxBtn-13').click(function(){
        
        $('.finBox-13').show();
         $('.finBox-1,.finBox-2,.finBox-3,.finBox-4,.finBox-5,.finBox-6,.finBox-7,.finBox-8,.finBox-9,.finBox-10,.finBox-11,.finbox-12,.finbox-14,.finbox-15,.finbox-16,.finbox-17,.finbox-18,.finbox-19,.finbox-20,.finbox-21,.finbox-22, .finbox-23,.finbox-24,.finbox-25,.finbox-26,.finbox-27,.finbox-28,.finbox-29,.finbox-30,.finbox-31,.finbox-32,.finbox-33,.finbox-34,.finbox-35,.finbox-36,.finbox-37,.finbox-38,.finbox-39,.finbox-40,.finbox-41,.finbox-42,.finbox-43,.finbox-44,.finbox-45').hide();
        });
        
       

    })

</script> 
<script>
        jQuery.fn.liScroll = function(settings) {
    settings = jQuery.extend({
        travelocity: 0.03
        }, settings);       
        return this.each(function(){
                var $strip = jQuery(this);
                $strip.addClass("newsticker")
                var stripHeight = 1;
                $strip.find("li").each(function(i){
                    stripHeight += jQuery(this, i).outerHeight(true); // thanks to Michael Haszprunar and Fabien Volpi
                });
                var $mask = $strip.wrap("<div class='mask'></div>");
                var $tickercontainer = $strip.parent().wrap("<div class='tickercontainer'></div>");                             
                var containerHeight = $strip.parent().parent().height();    //a.k.a. 'mask' width   
                $strip.height(stripHeight);         
                var totalTravel = stripHeight;
                var defTiming = totalTravel/settings.travelocity;   // thanks to Scott Waye     
                function scrollnews(spazio, tempo){
                $strip.animate({top: '-='+ spazio}, tempo, "linear", function(){$strip.css("top", containerHeight); scrollnews(totalTravel, defTiming);});
                }
                scrollnews(totalTravel, defTiming);             
                $strip.hover(function(){
                  jQuery(this).stop();
                },
                function(){
                  var offset = jQuery(this).offset();
                  var residualSpace = offset.top + stripHeight;
                  var residualTime = residualSpace/settings.travelocity;
                  scrollnews(residualSpace, residualTime);
                });         
        }); 
};

$(function(){
    $("ul#ticker01").liScroll();
});
        </script>


 <script>
        $('ul.product-tab').find('li:first').addClass('active');
    </script>
<script>

   $(function(){
                $(".tab-content-1").hide();
                $(".tab-content-1:first").show();

                $("ul.product-tab").on("click", "li", function () {

                    $(".tab-content-1").hide();
                    var activeTab = $(this).attr("rel");
                    $("#" + activeTab).fadeIn();

                    $("ul.product-tab li").removeClass("active");
                    $(this).addClass("active");

                    $(".tab_drawer_heading").removeClass("d_active");
                    $(".tab_drawer_heading[rel^='" + activeTab + "']").addClass("d_active");

                });

});



                
            //     $(".tab_drawer_heading").on("click", function () {

            //         $(".tab-content-1").hide();
            //         var d_activeTab = $(this).attr("rel");
            //         $("#" + d_activeTab).fadeIn();

            //         $(".tab_drawer_heading").removeClass("d_active");
            //         $(this).addClass("d_active");

            //         $("ul.product-tab li").removeClass("active");
            //         $("ul.product-tab li[rel^='" + d_activeTab + "']").addClass("active");
            //     });


            //     /* Extra class "tab_last"
            //        to add border to right side
            //        of last tab */
            //     $('ul.product-tab li').last().addClass("tab_last");
            // },



</script>
<script>

$(document).ready(function(){
  // Add scrollspy to <body>
  //$('body').scrollspy({target: ".header-menu-area", offset: 100});   


});
	
	
	function scrollNav() {
  $('#myNavbar a').click(function(){  
    //Toggle Class
    $(".active").removeClass("active");      
    $(this).closest('li').addClass("active");
    var theClass = $(this).attr("class");
    $('.'+theClass).parent('li').addClass('active');
    //Animate
    $('html, body').stop().animate({
        scrollTop: $( $(this).attr('href') ).offset().top - 260
    }, 400);
    return false;
  });
  $('.scrollTop a').scrollTop();
}
scrollNav();
</script>

<script>
    var APP_URL = {!! json_encode(url('/')) !!};
    $.ajax({
        url: APP_URL+'/beneficiaries/beneficiaries-ajax/',
        type: "GET",
        dataType: "json",
        success:function(data1) {
            var ctx = document.getElementById("beneficiariesChart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data1.label,
                    datasets: data1.data,
//                        [{
//                            label: 'Classroom Training',
//                            backgroundColor: "#1a2b4a",
//                            data: [12, 59, 5, 56, 58,12, 59, 87, 45],
//                        }, {
//                            label: 'e-Learning Courses',
//                            backgroundColor: "#dfc32a",
//                            data: [12, 59, 5, 56, 58,12, 59, 85, 23],
//                        }, {
//                            label: 'Webinar',
//                            backgroundColor: "#ec5252",
//                            data: [12, 59, 5, 56, 58,12, 59, 65, 51],
//                        }, {
//                            label: 'Seminar and Workshops',
//                            backgroundColor: "#75de41",
//                            data: [12, 59, 5, 56, 58, 12, 59, 12, 74],
//                        }],
                },
                options: {
                    tooltips: {
                        displayColors: true,
                        callbacks:{
                            mode: 'x',
                        },
                    },
                    scales: {
                        xAxes: [{
                                stacked: true,
                                
                                gridLines: {
                                    display: false,
                                }
                            }],
                        yAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true,
									  userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }

                 },
                                },	
		
                                type: 'linear',
                            }]
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: { position: 'bottom' },
                }
            });
        }
    });
    
</script>

<script>
//School Collage
$(document).ready(function(){
var config = {
  type: 'line',
  data: {
     labels: ["Kotputli", "Viratnagar", "Shahpura ", "Phulera", "Jhotwara", "Amer", "Ramgarh", "Bansur", "Baran", "Barmer", "Bikaner", "Churu"],
    datasets: [{
      label: "Population",
       data: [10, 13, 17, 12, 30, 47, 60, 120, 230, 300, 310, 400],
	   
      fill: true,
      borderColor: "rgba(49,172,170,0.9)",
       backgroundColor:[ "#36a2eb","#ff6384","#ff9f40","#ffcd56","#4bc0c0","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
//	   borderCapStyle: 'square',
//    pointBorderColor: "white",
//    pointBackgroundColor: "green",
//    pointBorderWidth: 1,
//    pointHoverRadius: 8,
//    pointHoverBackgroundColor: "yellow",
//    pointHoverBorderColor: "green",
//    pointHoverBorderWidth: 2,
 fill: false,
    pointRadius: 4,
   pointHitRadius: 10,
    },]
  },
  
  options: {
    responsive: true,
	legend: {
		 display: false,
           // position: 'bottom',
        },
		
	  scales: {
   yAxes: [{
     ticks: {
      beginAtZero: false
     },
	  scaleLabel: {
          labelString: 'Attendees',
          display: true,
        },
    }]
  },
  title: {
    fontSize: 12,
    display: true,
    text: 'Webinars Categories',
    position: 'bottom'
  }
  },
  
};

var myChart;
 change('bar');
$("#schoolCollagePanel #barChartBtn").click(function() {
  change('bar');
});

$("#schoolCollagePanel #pieChartBtn").click(function() {
  change('polarArea');
  //backgroundColor:[ "#ff4243","#ffd13e","#45c27e","#42c4f5","#ff4342","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
  
});

$("#schoolCollagePanel #lineChartBtn").click(function() {
  /**change('line');**/
	  change('bar');
});

function change(newType) {
  var ctx = document.getElementById("WebinarChartStBox").getContext("2d");

  // Remove the old chart and all its event handles
  if (myChart) {
    myChart.destroy();
  }

  // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
  var temp = jQuery.extend(true, {}, config);
  temp.type = newType;
   //temp.type = newType;
  myChart = new Chart(ctx, temp);
};

});

</script>

<script>

//Constituency Details
$(document).ready(function(){
var config = {
  type: 'bar',
  data: {
    labels: ["2005", "2006", "2007", "2008", "2009", "2010", "2011", "2012", "2013", "2014", "2015", "2016"],
    datasets: [{
      label: "Population",
       data: [10, 13, 17, 12, 30, 47, 60, 120, 230, 300, 310, 400],
	   
      fill: true,
      borderColor: "rgba(49,172,170,0.9)",
       backgroundColor:[ "#36a2eb","#ff6384","#ff9f40","#ffcd56","#4bc0c0","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
//	   borderCapStyle: 'square',
//    pointBorderColor: "white",
//    pointBackgroundColor: "green",
//    pointBorderWidth: 1,
//    pointHoverRadius: 8,
//    pointHoverBackgroundColor: "yellow",
//    pointHoverBorderColor: "green",
//    pointHoverBorderWidth: 2,
 fill: false,
    pointRadius: 4,
   pointHitRadius: 10,
    },]
  },
  
  options: {
    responsive: true,
	legend: {
		 display: false,
           // position: 'bottom',
        },
		
		  scales: {
  yAxes: [{
             ticks: {
                 beginAtZero: true,
                 userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }

                 },
             }
         }]
  },
  title: {
    fontSize: 12,
    display: true,
    text: 'Month',
    position: 'bottom'
  }
  },
  
};

var myChart;
 change('bar');
$("#constituencyPanel #barChartBtn").click(function() {
  change('bar');
});

$("#constituencyPanel #pieChartBtn").click(function() {
  change('polarArea');
  //backgroundColor:[ "#ff4243","#ffd13e","#45c27e","#42c4f5","#ff4342","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
  
});

$("#constituencyPanel #lineChartBtn").click(function() {
 /** change('line'); **/
	  change('bar');
});

function change(newType) {
  var ctx = document.getElementById("SeminarWorkshopsChart").getContext("2d");

  // Remove the old chart and all its event handles
  if (myChart) {
    myChart.destroy();
  }

  // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
  var temp = jQuery.extend(true, {}, config);
  temp.type = newType;
   //temp.type = newType;
  myChart = new Chart(ctx, temp);
};

});
	
</script>

		<script>
        $(document).ready(function() {
            $('.customtooltip').tooltipster();
		
		
        })
    </script>




    </body>
    </html>
