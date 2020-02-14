<?//php echo $chartcourse;?>
<script type="text/javascript">
 var chartcourse =  ['<?php  echo $chartcourse;?>']; 
</script>
 
<?php //echo "<pre>"; print_r($elementsdata); "<pre>"; die;?>


@extends('frontend.layouts.app'.config('theme_layout'))

@section('title', trans('labels.frontend.home.title').' | '.app_name())
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
    </style>
@endpush

@section('content')


<!--================================
         START SLIDER AREA
=================================-->
<section class="slider-area">
    <div class="homepage-slide1">
     <div class="single-slide-item slide-bg1">
     
     <div class="container">
     <div class="homepage-sliderBanner">
     <div class="row">
     <div class="col-4 pr-0 vM">
     <div>
     <div class="homepage-sliderLogo">
     <img src="{{asset('assets/images/vidyakosh.svg')}}">
     </div>
     <h1>A way of learning</h1>
     </div>
     </div>
     <div class="col-8 pl-0">
     <div class="ingoBox">
     <img src="{{asset('assets/images/info3.svg')}}" class="center-shapelogo">
     <div class="ingoBoxPanel ingoBoxPanel-1"><a href="{{route('pilofselflearning')}}">Capacity Building Pillars</a> <i class="fa" aria-hidden="true"><img src="{{asset('assets/images/icon-4.png')}}"></i></div>
     <div class="ingoBoxPanel ingoBoxPanel-2"><a href="{{url('courses')}}">E-learning Courses</a><i class="fa fa-search" aria-hidden="true"></i></div>
     <div class="ingoBoxPanel ingoBoxPanel-3"><a href="{{route('beneficiaries')}}">Beneficiaries</a> <i class="fa" aria-hidden="true"><img src="{{asset('assets/images/robot.png')}}"></i></div>
     <div class="ingoBoxPanel ingoBoxPanel-4"><a href="{{route('analytics')}}">Analytics</a><i class="fa fa-bar-chart" aria-hidden="true"></i></div>
     
     </div>
     </div>
     </div>
     </div>
     
     </div>
        
    </div><!-- end homepage-slides -->
	</div>
    
</section><!-- end slider-area -->
<!--================================
        END SLIDER AREA
=================================-->





<!-- ================================
       START FUNFACT AREA
================================= -->
<section class="funfact-area text-center">
    <div class="container">
        <div class="funfact-row">
            <div class="funfact-item">
                <div class="funfact-inner-item">
                    <span class="flaticon-learning"></span>
                    <h4 class="funfact__title counter">{{$usercount}}</h4>
                    <p class="funfact__meta">Learners <!--Training--></p>
                </div><!-- end client-testimonial -->
            </div><!-- end col-lg-3 -->
            <div class="funfact-item">
                <div class="funfact-inner-item">
                    <span class="flaticon-book"></span>
                    <h4 class="funfact__title counter">{{$coursescount}}</h4>
                    <p class="funfact__meta">E-learning Courses</p>
                </div><!-- end client-testimonial -->
            </div><!-- end col-lg-3 -->             
            <div class="funfact-item">
                <div class="funfact-inner-item">
                    <span class="flaticon-training"></span>
                    <h4 class="funfact__title counter">{{$crttrainingcount}}</h4>
                    <p class="funfact__meta">CRT Trainings</p>
                </div><!-- end client-testimonial -->
            </div><!-- end col-lg-3 -->
            <div class="funfact-item">
                <div class="funfact-inner-item">
                    <span class="flaticon-webinar"></span>
                    <h4 class="funfact__title counter">890</h4>
                    <p class="funfact__meta">Webinars</p>
                </div><!-- end client-testimonial -->
            </div><!-- end col-lg-3 -->
            <div class="funfact-item">
                <div class="funfact-inner-item">
                    <span class="flaticon-seminar"></span>
                    <h4 class="funfact__title counter">{{$seminarcount}}</h4>
                    <p class="funfact__meta">Seminars</p>
                </div><!-- end client-testimonial -->
            </div><!-- end col-lg-3 -->
            <div class="funfact-item">
                <div class="funfact-inner-item">
                    <span class="flaticon-work"></span>
                    <h4 class="funfact__title counter">{{$executivebrifing}}</h4>
                    <p class="funfact__meta">Executive Briefings</p>
                </div><!-- end client-testimonial -->
            </div><!-- end col-lg-3 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end funfact-area -->
<!-- ================================
       START FUNFACT AREA
================================= -->


  <!--graph section-->
  <div class="container-fluid pb-4 pt-4">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-lg-6">
		  <div class="card">
			   <div class="triangle-up"></div>
		  <div class="triangle-right"></div>
		 <span class="classroom_training_drop">
			 <select id="drop_select1" name="drop_select1" style="font-size: 14px;padding: 3px;border-radius: 4px;">
				  <option value="0">Please Select</option>
                  <option value="1">Month Wise</option>
                  <option value="2">Year Wise</option>
                  <option value="3">Designation Wise</option>
				  <option value="4">Domain Wise</option>
                </select>
			<select id="drop_select2" name="drop_select2" style="font-size: 14px;padding: 3px;border-radius: 4px;">
                  <option value="0">All</option>
                 @foreach($designations as $designationdata)
				<option value="{{$designationdata->id}}">{{$designationdata->designation}}</option>
				 @endforeach	
                </select>
		</span>
        <div id="classroom_trainings_chart"></div>
		 
      </div>
	 </div>
      
      <!---graph 2-->
      <div class="col-sm-12 col-lg-6">
        <div class="card">
          <div class="card-tittle" id="constituencyPanel"> Top 10 E-Learning Courses
			  <span> 
				<!--  <span class="chartIcon"><img src="{{asset('assets/images/icon/line.svg')}}" id="lineChartBtn"></span> -->
				  <span class="chartIcon"><img src="{{asset('assets/images/icon/bar-chart.svg')}}" id="barChartBtn"></span> 
				 <span class="chartIcon"><img src="{{asset('assets/images/icon/filter.svg')}}" class="filterBtn-2"> </span> 
			  </span>
			</div>
          <!--filter Box-->
          <div class="filterPanel f-box-2" style="display:none;">
            <div class="row">
              <div class="col-md-4">
                <p>Name of Antibiotics </p>
                <select class="form-control">
                  <option value="#">Tetracycline</option>
                  <option value="#">Oxytetracycline</option>
                  <option value="#">Trimethoprim</option>
                  <option value="#">Oxolinic Self Assessment </option>
                </select>
              </div>
              
              <!--/01-->
              <div class="col" style="padding-top:20px;">
                <button type="submit" class="btn  btn-success">Go</button>
                <a href="#" class="btn btn-info">Reset</a> </div>
              <!--/01--> 
            </div>
          </div>
          <!--filter Box-->
          
          <div class="card-body">		
			   <div class="triangle-up2"></div>
			  <div class="triangle-right2"></div>
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class=""></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
              </div>
            </div>
            <canvas id="constituencyDetailsChart" class="chartjs-render-monitor" width="479" height="255" style="display: block; width: 479px; height: 255px;"></canvas>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
  <!--graph section emds--> 




<!--======================================
        START COURSE 2 AREA
======================================-->
<section class="course-area course-area2" style="background-color: #f7fafd;">
    <div class="course-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading text-center">
                        <!--<h5 class="section__meta">Learn on your schedule</h5>-->
                        <h2 class="section__title">Trending E-learning Courses</h2>
                        <span class="section__divider"></span>
                    </div><!-- end section-heading -->
                </div><!-- end col-lg-12 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end course-wrapper -->
    <div class="course-content-wrapper">
        <div class="container">
            <div class="row course-item-wrap">
                <div class="col-lg-12">
                    <div class="tab-content">
                        <div class="course-block course-carousel" id="trendingCoursesSlider">
                            @foreach($trendingcourse as $trendingcourses)
                            
                            
                            <div class="col-12">
                            <div class="course-item">
                                <div class="course-img">
                                    <a href="{{ route('courses.show', [$trendingcourses->slug]) }}" class="course__img"><img src="{{asset('storage/uploads/'.$trendingcourses->course_image)}}" alt=""></a>
                                    <div class="course-tooltip">
                                        <span class="tooltip-label">E-learning</span>
                                    </div>
									@if(isset($level))
									@foreach($level as $leveldata)
									@if(($trendingcourses->difficulty_id)==($leveldata->id))
									<div class="course-tooltip1">
                                        <span class="tooltip-label1 float-right">{{$leveldata->name}}</span>
                                    </div>
									@endif
									@endforeach
									@endif
                                </div><!-- end course-img -->
                                <div class="course-content">
                                    <p class="course__label">
                                        <span class="course__label-text">{{$trendingcourses->name}}</span>
                                        <a href="#" class="course__collection-icon" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="la la-heart-o"></span></a>
                                    </p>
                                    <h3 class="course__title">
                                        <a href="{{ route('courses.show', [$trendingcourses->slug]) }}" class="customtooltip" title="{{$trendingcourses->title}}">@if(strlen(strip_tags($trendingcourses->title))>25){{substr(strip_tags(ucwords($trendingcourses->title)), 0, 22)}}...@else{{strip_tags(ucwords($trendingcourses->title))}}@endif</a>
                                    </h3>
                                    <p class="course__author">
                                        <a href="{{ route('courses.show', [$trendingcourses->slug]) }}">@if(strlen(strip_tags($trendingcourses->description))>=25){{substr(strip_tags($trendingcourses->description), 0, 65)}}...@else{{strip_tags($trendingcourses->description)}} @endif</a>
                                    </p>
                                    <div class="rating-wrap d-flex">
                                        <ul class="review-stars d-flex">
                                              @for($i=1; $i<=5; $i++)
                                              <li><i class="la la-star"></i></li>
                                              @endfor
                                              </ul>
                                              <ul class="review-stars d-flex overlaystar">
                                            @foreach($rating as $item)
                                            @if(($item->reviewable_id)==($trendingcourses->id))
                                              @for($i=1; $i<=(int)$item->rating; $i++)
                                          <li><span class="la la-star"></span></li>
                                             @endfor
                                             @endif
                                             @endforeach
                                             
                                          
                                        </ul>
                                        <span class="star-rating-wrap">
                                            <!-- <span class="star__rating">4.2</span> -->
                                          @if(isset($rating))
                                          @foreach($rating as $item)
                                            @if(($item->reviewable_id)==($trendingcourses->id))
                                            <span class="star__count">({{(int)$item->rating}})</span>
                                             @endif

                                              @endforeach
                                              @else
                                          @endif
                                        </span>
                                    </div><!-- end rating-wrap -->
                                    <div class="course-meta">
                                        <ul class="course__list d-flex">
											
                                            <li><span class="meta__date"><i class="la la-play-circle"></i>{{$trendingcourses->chapterCount()}} Lessons</span></li>
											
											<li class="text-right"><span class="meta__date"><i class="la la-clock-o"></i> 3 hours 20 min</span></li>
                                        </ul>
                                    </div><!-- end course-meta -->
                                    <div class="course-price-wrap">
                                      
                                      <span class="course__price"><span class="StudentsNo">{{$trendingcourses->students()->count()}}</span> <span class="course__before-price">Enrolled</span></span>
                                     
                                        <a href="{{ route('courses.show', [$trendingcourses->slug]) }}" class="course__btn">Read More</a>
                                    </div><!-- end course-price-wrap -->
                                </div><!-- end course-content -->
                            </div><!-- end course-item -->
                            </div>
                          @endforeach 
                        </div><!-- end course-block -->
                    </div><!-- end tab-content -->
                </div><!-- end col-lg-12 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end course-content-wrapper -->
</section><!-- end courses-area -->
<!--======================================
        END COURSE 2 AREA
======================================-->

<!--======================================
        START GET-START AREA
======================================-->
<!--section class="get-start-area">
    <div id="perticles-js"></div>
    <div class="box-icons">
        <div class="box-one"></div>
        <div class="box-two"></div>
        <div class="box-three"></div>
        <div class="box-four"></div>
    </div><!-- end box-icons - ->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-heading">
                    <h5 class="section__meta section__meta2">start online E-learning Courses</h5>
                    <h2 class="section__title section__title2">Enhance Your skills With Best Online E-learning  Courses</h2>
                    <span class="section__divider section__divider2"></span>
                    <div class="get-start-btn">
                        <a href="#" class="theme-btn">get started now</a>
                    </div>
                </div><!-- end section-heading - ->
            </div><!-- end col-lg-12 - ->
        </div><!-- end row - ->
    </div><!-- end container - - >
    <div class="box-icons2">
        <div class="box-one"></div>
        <div class="box-two"></div>
        <div class="box-three"></div>
        <div class="box-four"></div>
        <div class="box-five"></div>
    </div><!-- end box-icons2 - ->
</section --><!-- end get-start-area -->
<!--======================================
        END GET-START AREA
======================================-->

<!--======================================
        START BENEFIT AREA
======================================-->
<section class="benefit-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="benefit-heading">
                    <div class="section-heading">
                        <!--<h5 class="section__meta">get started with us</h5>-->
                        <h2 class="section__title">Exclusive Features</h2>
                        <span class="section__divider"></span>
                        <p class="section__desc" style="text-align:justify">
                            VidyaKosh is a Learning Management System of NIC providing a platform for learning various concepts on Emerging Technologies namely, Artificial Intelligence and Deep Learning, ELK Stack for Data Analytics, Internet of Things etc. Geographic Information System(GIS), Development of Mobile Apps on Android and iOS Platforms, Network Technologies and its components, Enterpise Archtecture, Cyber Security, Cloud and Data Centre, API Mangement, Agile Development & DevOPs, Software Quality etc.
                        </p>
                     <!--    <div class="row benefit-course-box">
                            <div class="col-lg-4">
                                <div class="benefit-item benefit-item1">
                                    <span class="la la-mouse-pointer benefit__icon"></span>
                                    <h4 class="benefit__title">100,000 E-learning courses</h4>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="benefit-item benefit-item2">
                                    <span class="la la-bolt benefit__icon"></span>
                                    <h4 class="benefit__title">Live Learning</h4>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="benefit-item benefit-item3">
                                    <span class="la la-users benefit__icon"></span>
                                    <h4 class="benefit__title">Anywhere Anytime</h4>
                                </div>
                            </div>
                        </div> -->


       <!-- Exclusive Features Start -->
       <div class="blog-area">       
        <div class="row blog-post-wrapper">
            <div class="col-lg-12" style="padding: 0">
                <div class="blog-post-carousel pt-0" id="exclusiveFeatures">
                <div class="col-12">
                    <div class="blog-post-item">
                        <div class="blog-post-img">
                            <img src="{{asset('assets/images/img50.jpg')}}" alt="blog image" class="blog__img">
                            <!-- end blog__date -->
                        </div><!-- end blog-post-img -->
                        <div class="post-body">
                            <div class="blog-title">
                                <a href="#" class="blog__title">
                                    Capacity Building
                                </a>
                            </div>
                            
                        </div><!-- end post-body -->
                    </div><!-- end blog-post-item -->
                  </div>  
                    
                    <div class="col-12">
                    <div class="blog-post-item">
                        <div class="blog-post-img">
                            <img src="{{asset('assets/images/img51.jpg')}}" alt="blog image" class="blog__img">
                            
                        </div><!-- end blog-post-img -->
                        <div class="post-body">
                            <div class="blog-title">
                                <a href="#" class="blog__title">
                                    Individual Grooming
                                </a>
                            </div>
                            
                        </div><!-- end post-body -->
                    </div><!-- end blog-post-item -->
                    </div>
                    <!-- end blog-post-item -->
                    <!-- end blog-post-item -->
                    <div class="col-12">
                    <div class="blog-post-item">
                        <div class="blog-post-img">
                            <img src="{{asset('assets/images/img52.jpg')}}" alt="blog image" class="blog__img">
                           
                        </div><!-- end blog-post-img -->
                        <div class="post-body">
                            <div class="blog-title">
                                <a href="#" class="blog__title">
                                   Multi Platform Accesibility
                                </a>
                            </div>
                            
                        </div><!-- end post-body -->
                    </div><!-- end blog-post-item -->
                    </div>
                    <!-- end blog-post-item -->
                    <div class="col-12">
                    <div class="blog-post-item">
                        <div class="blog-post-img">
                            <img src="{{asset('assets/images/img53.jpg')}}" alt="blog image" class="blog__img">
                            <!-- end blog__date -->
                        </div><!-- end blog-post-img -->
                        <div class="post-body">
                            <div class="blog-title">
                                <a href="#" class="blog__title">
                                    Self Assesment
                                </a>
                            </div>
                            
                        </div><!-- end post-body -->
                    </div><!-- end blog-post-item -->
                    </div>
                    <div class="col-12">
                    <div class="blog-post-item">
                        <div class="blog-post-img">
                            <img src="{{asset('assets/images/img54.jpg')}}" alt="blog image" class="blog__img">
                            <!-- end blog__date -->
                        </div><!-- end blog-post-img -->
                        <div class="post-body">
                            <div class="blog-title">
                                <a href="#" class="blog__title">
                                    PAN India Access
                                </a>
                            </div>
                            
                        </div><!-- end post-body -->
                    </div><!-- end blog-post-item -->
                    </div>
                    
                </div><!-- end blog-post-carousel -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
 
</div><!-- end blog-area -->


                      <!--   <div class="get-start-btn">
                            <a href="#" class="theme-btn">learn more</a>
                        </div> -->
                    </div><!-- end section-heading -->
                </div><!-- end benefit-heading -->
            </div><!-- end col-lg-6 -->
            <div class="col-lg-6">
                <div class="benefit-img">
                    <img src="{{asset('assets/images/img13.jpg')}}" alt="">
                    <img src="{{asset('assets/images/img14.jpg')}}" alt="">
                </div>
            </div>
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end benefit-area -->
<!--======================================
        END BENEFIT AREA
======================================-->






@endsection

@push('after-scripts')
<script type="text/javascript">
$(document).ready(function(){

  var dd = $('.ticker01').easyTicker({
    direction: 'up',
    easing: 'easeInOutBack',
    speed: 'slow',
    interval: 2000,
    height: 'auto',
    visible: 10,
    mousePause: 0,
    controls: {
      up: '.up',
      down: '.down',
      toggle: '.toggle',
      stopText: 'Stop !!!'
    }
  }).data('easyTicker');
  
  cc = 1;
  $('.aa').click(function(){
    $('.ticker01 ul').append('<li>' + cc + ' Triangles can be made easily using CSS also without any images. This trick requires only div tags and some</li>');
    cc++;
  });
  
  $('.vis').click(function(){
    dd.options['ticker01'] = 3;
    
  });
  
  $('.ticker01').click(function(){
    dd.stop();
    dd.options['ticker01'] = 0 ;
    dd.start();
  });
  
});
</script>

<script>
$(function() {
  $('[data-toggle="popover"]').each(function(i, obj) {
    var popover_target = $(this).data('popover-target');
  
    $(this).popover({
        html: true,
        trigger: 'manual',
    delay: { 
             show:0, 
             hide: 0
    },
        placement: 'right',
        content: function(obj) {
            return $('#trendingCoursesHoverArea').html();
        }
    }).on("mouseenter", function () {
        var _this = this;
        var dynamic_elementid = $(this).attr('data-element');
        var allelements = $("#"+dynamic_elementid).html();
        var name = allelements.split('##**##')[0];
        var title = allelements.split('##**##')[1];
        var description = allelements.split('##**##')[2];
        var route = allelements.split('##**##')[3];
        $("#popover_name").html(name);
        $("#popover_title").html(title);
        $("#popover_description").html(description);
        $("#popover_redirection").attr('href',route);
        $(this).popover("show");
        $(".popover").on("mouseleave", function () {
            $("#popover_name").html();
            $("#popover_title").html();
            $("#popover_description").html();
            $("#popover_route").html();
            $(_this).popover('hide');
        });
    }).on("mouseleave", function () {
        var _this = this;
        setTimeout(function () {
            if (!$(".popover:hover").length) {
                $(_this).popover("hide");
            }
        }, 300);
});
  });
});
</script>
<script>
var trending_headings = <?php echo $trending_courses ?>;
var trending_chartdata = <?php echo $trending_courses_data ?>;
var classroom_trainings_chart_data = <?php echo json_encode($classroom_trainings_chart_data);?>;
$(document).ready(function() {
$(".headerTextSlider").click(function () {
    $(".headerTextSlider").removeClass("active");
    // $(".tab").addClass("active"); // instead of this do the below 
    $(this).addClass("active");   
});
$(".findbox").click(function () {
    $(".findbox").removeClass("active");
    // $(".tab").addClass("active"); // instead of this do the below 
    $(this).addClass("active");   
});
});
//-------------classromm training-----------------------------------------------------------//

$(document).ready(function() {
	load_charts('classroom_trainings_chart' , classroom_trainings_chart_data, 'Domains', 'Number of Trainings', 'Classroom Trainings', 'Numbers');   
	
	//-------------------------------yearwise filter------------------------------//
	$('select[name="drop_select1"]').on('change', function() {
            var drop_select1 = $(this).val();
            if(drop_select1) {
                $.ajax({
                    url: 'training_charts/classroom/'+drop_select1+'/0',
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
						load_charts('classroom_trainings_chart' , data, 'Domains', 'Number of Trainings', 'Classroom Trainings', 'Numbers');
                    }
                });
            }else{
             //   $('#crt_designation_id').empty();
            }
        });	
	
	$('select[name="drop_select2"]').on('change', function() {
            var drop_select2 = $(this).val();
            if(drop_select2) {
                $.ajax({
                    url: 'training_charts/classroom/3/'+drop_select2, 
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
						load_charts('classroom_trainings_chart' , data, 'Domains', 'Number of Trainings', 'Classroom Trainings', 'Numbers');
                    }
                });
            }else{
             //   $('#crt_designation_id').empty();
            }
        });	
	//------------------------------------vivsitor count---------------------------------//
		    var ip = '<?php echo $_SERVER['REMOTE_ADDR'];?>';
			//alert(ip);
			$.ajax({
			data:{'ip':ip,},
				type:"get",
				url:'visitorcount',
				 success:function(data) {
				 },
				error:function(data) {
				 }
			});
		
    });

</script>
    
@endpush 