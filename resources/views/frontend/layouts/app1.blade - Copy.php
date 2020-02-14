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
              <link rel="stylesheet" href="{{asset('assets/css/fontawesome.css')}}">
              <link rel="stylesheet" href="{{asset('assets/css/font-awesome.css')}}">
              <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
              <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
              <link rel="stylesheet" href="{{asset('assets/css/style_new.css')}}">
               <link rel="stylesheet" href="{{asset('assets/css/util.css')}}">
                <link rel="stylesheet" href="{{asset('assets/js/carousel/owl.carousel.css')}}">
                 <link rel="stylesheet" href="{{asset('assets/js/carousel/owl.theme.css')}}">
                 <link rel="stylesheet" href="{{asset('assets/js/tabs/tabs.css')}}">
                 <link rel="stylesheet" href="{{asset('assets/js/tabs/tabs1.css')}}">
                 <link rel="stylesheet" href="{{asset('assets/js/tabs/tabs2.css')}}">


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


    </head>
    <body class="{{config('layout_type')}}">

    <div id="app">
    {{--<div id="preloader"></div>--}}
    @include('frontend.layouts.modals.loginModal')


    <!-- Start of Header section
        ============================================= -->
       <header>
    <div class="container-fluid">
      <div class="row middle_text">
        
        <div class="logoPanel"> <a href="{{url('/')}}"><img src="{{asset('assets/images/govt.png')}}" class="mr-r-10" /> <img src="{{asset('assets/images/'.$logo)}}" style="max-height: 45px;"></a></div>
        <div class="col">
          <div class="dropdown">
            
            <button class="dropbtn ministri" id="ministri" value ="{{$ministry->ministry_name}}">{{$ministry->ministry_name}}<i class="fa fa-chevron-down" style="font-size:10px;"></i></button>
          
            <div class="dropdown-content"> 
                @foreach($allministry as $ministries)
                <a href="#" class="ministry" id="ministry">{{$ministries->ministry_name}}</a>
                 @endforeach
             </div>
          </div>
          <div class="dropdown shift-left">
            <button class="dropbtn">{{$departments->department_name}}<i class="fa fa-chevron-down" style="font-size:10px;"></i></button>
        
         <!-- <div class="dropdown-content ministri" id="min"></div> -->
             <div class="dropdown-content ministri" id="min"> 
                @foreach($alldepartments as $department)
                <a href="#" class="">{{$department->department_name}}</a>
                @endforeach
              </div>
          </div>
        </div>
        <div class="col-md-4">
         @if (Auth::guest())
         <a id="openLoginModal" data-target="#myModal" class="btn btn-primary"
          href="javascript:void(0)">Login</a>
         @endif

         @if (Auth::check())
         <a id="" data-target="" class="btn btn-primary"
          href="{{url('logout')}}"> Logout</a>
         <a id="" data-target="" class="btn btn-primary"
         href="javascript:void(0)">Welcome {{ $logged_in_user->name }} </a>
        
         @endif
      
          <div class="center_side">
            <form id="demo-2">
              <input type="search" placeholder="Search">
            </form>
          </div>
        </div>
        <div class="commonPanels">
          <ul class="insFace">
            <li class="linkedinLink"> <a href="javascript:void(0);" data-toggle="dropdown"><img src="{{asset('assets/images/vidya_kosh.png')}}"></a></li>
            <li class="facebookLink"><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li class="twitterLink"><a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li class="linkedinLink"><a href=""><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
          </ul>
        </div>
        <div class="dropdown colorPanel"> <a href="javascript:void(0);" data-toggle="dropdown"><img src="{{asset('assets/images/icon2.png')}}"></a>
          <ul class="dropdown-content menuPanelDown">
            <li><a href="javascript:;" class="increaseFont" title="Increase font size">A<sup>+</sup></a></li>
            <li><a href="javascript:;" class="resetFont" title="Reset font size">A</a></li>
            <li><a href="javascript:;" class="decreaseFont" title="Decrease font size">A<sup>-</sup></a></li>
            <li class="blackBtnBox"><a href="javascript:;" class="colorBox" id="blackBtn" title="High contrast dark">A</a></li>
            <li class="whiteBtnBox"><a href="javascript:;" class="colorBox" id="whiteBtn" title="">A</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
        <!-- Start of Header section
            ============================================= -->


        @yield('content')
        @include('cookieConsent::index')


        @include('frontend.layouts.partials.footer')

    </div><!-- #app -->

    <!-- Scripts -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script> 
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script> 
    <script src="{{asset('assets/js/carousel/owl.carousel.js')}}"></script> 
    <script src="{{asset('assets/js/tabs/tabs.js')}}"></script> 
    <script src="{{asset('assets/js/theme.js')}}"></script> 
    <script src="{{asset('assets/js/chart.js')}}"></script> 
    <script src="{{asset('assets/js/Chart.min.js')}}"></script>
    <script src="{{asset('assets/js/cokie.js')}}"></script>
    
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
                    html+= '<a href="javascript:void(0)" class="bjo">'+departmentname+'</a>';
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
   
    <script>
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
    </script>
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
    </body>
    </html>
