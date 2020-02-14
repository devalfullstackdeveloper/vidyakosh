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
  <!--section 2 starts-->
  @if(isset($banner->banner_image))
    <section class="sect2" style='background-image: url("{{asset('banners/'.$banner->banner_image)}}");'>
  @else
  <section class="sect2" style='background-image: url("{{asset('assets/images/bg_banner.jpg')}}");'>
    @endif
    <div class="container text-center">
      <div class="streamer__content row streamer__headline">
        <div class="col-md-9">
        <ul id="headerTextSlider">
        <li>   
          आओ ज्ञान की ज्योति जलाएं, कार्य क्षेत्र में दक्षता पाएं।
</li>
<li>   
विद्या कोश पटल पर आएँ, हर दिशा में ज्ञान बढ़ाएँ।
</li>

<li>   
आओ मिल एक कुटुंब बनाएं, जिसमें सीखें और सिखाएं।
</li>
         </ul>

          <!-- <button class="btn explore_it pull-up">Get started</button> -->
        </div>
      </div>
      <div class="newsBox holder" ><h3 class="newFlashHeading">Notice Board</h3>
        <ul id="ticker01" class="lnews">
            @if(isset($newsflash))
            @foreach($newsflash as $newsflashs)
            @foreach($newsflashs as $newsflashsdata)
          <li><span><i class="fa fa-calendar-check-o"> </i> {{date('d-M-Y', strtotime($newsflashsdata->start_date))}}<br>
            </span><a href="#">{{$newsflashsdata->title}}</a></li>
         @endforeach
         @endforeach
         @else
         <li><span><i class="fa fa-calendar-check-o"></i>start date<br>
            </span><a href="#">start title</a></li>
         @endif
        </ul>
      </div>
    </div>
    <ul id="bannerTextSlider">
       @if(isset($elementsdata))
         @foreach($elementsdata as $categorydata)
          <li class="hoUp">
            <div class="course-list pull-up headerTextSlider">
              {{$categorydata['category']['category_name']}}
              <img src="{{asset('assets/images/4.png')}}"> 
            </div>
          <!--01-->
            <div class="new_hover DigitalHover-1" style="background:url({{asset('assets/images/cyberscurity.jpg')}}) no-repeat center; background-size:cover;">
              <div class="container"> 
                <?php $i = 0;?>
                @foreach($categorydata['category']['subcategory'] as $sub_catdata)  
                  <!--01 Box-->
                    <div class="finBox-{{$sub_catdata['id']}}" <?=($i != 0)?'style="display:none;"':''?> >
                      <?php $i++;?>
                      <div id="slider-5"> 
                      @foreach($sub_catdata['courses'] as $coursedata)
                      
                        <!--01-->
                        <div class="item">
                          <div class="box_grid">
                            <figure> 
                              <!-- <a href="#0" class="wish_bt"></a> 
                              <a href="{{route('coursedetail',['id'=>$coursedata->id])}}"> -->
                              <!--   <a href="#0" class="wish_bt"></a>  -->
                              
                              <a href="{{ route('courses.show', [$coursedata->slug]) }}">
                              <!-- <div class="preview"><span>Preview course</span></div> -->
                              <img src="{{asset('storage/uploads/'.$coursedata->course_image)}}" alt=""></a> 
                            </figure>
                            <div class="wrapper"> <small>{{$sub_catdata['categoryname']}}</small>
                              <h3>@if(strlen(strip_tags($coursedata->title))>=20){{substr(ucwords(strip_tags($coursedata->title)),0, 20)}}...@else{{ucwords($coursedata->title)}}@endif</h3>

                              <p>@if(strlen($coursedata->description)>=30){{substr(strip_tags($coursedata->description), 0, 30)}}...@else{{strip_tags($coursedata->description)}}@endif

                                
                              </p>
                              <div>
                              <span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star unchecked"></span><span class="fa fa-star unchecked"></span></div>
                            </div>
                            <ul>
                              <!-- <li><a href="{{route('coursedetail',['id'=>$coursedata->id])}}">View Now</a></li> -->
                              @if(($coursedata->moodle_course_ref_id)!=0)
                              <a href="https://companydemo.in/apps/model">3500 Enroll Students<i class="fa fa-align-justify pull-right dicon-view"></i></a>
                              @else
                              <a href="{{ route('courses.show', [$coursedata->slug]) }}">3500 Enroll Students<i class="fa fa-align-justify pull-right dicon-view"></i></a>
                               @endif
                            </ul>
                          </div>
                        </div>
                        <!--./01-->
                      @endforeach
                      </div>
                    </div>
                  <!--./01 Box--> 
                @endforeach
                <ul class="catMark">
                  <?php $firstelement = true;?>
                  @foreach($categorydata['category']['subcategory'] as $sub_cat)  
                  <li class="finBoxBtn-{{$sub_cat['id']}} <?=($firstelement == true)?'active':'';?>">{{$sub_cat['subcategory_name']}}</li>
                  <?php $firstelement = false;?>
                  @endforeach
                </ul>
              
              </div>
            </div>
          <!--./01--> 
        </li>      
      @endforeach
      @else
         @endif
      
    </ul>
    
    <!-- \.section 2 ends --> 
  </section>

  <!--top categories starts--> 
  <!--webinar--> 
  <!--webniar section ends-->
 <!--  <div class="container-fluid Popular_courses">
    <div class="main_title_2 text-center"> <span><em></em></span>
      <h2 style="font-weight: 800; font-size: 25px; margin-bottom: 0; margin-top:40px;"> WEBINARS</h2>
      <div id="slider-new">
        <div class="item">
          <div class="box_grid">
            <figure> <a href="#0" class="wish_bt"></a> <a href="#">
              <div class="preview-new"><span> <i class="fa fa-calendar-check-o"></i> 15 OCT 2019<br>
                1:00 PM</span></div>
              <img src="{{asset('assets/images/web1.jpg')}}" class="img-fluid" alt=""></a> </figure>
            <div class="wrapper"> <small>Category</small>
              <h3 class="mb-10">Python</h3>
              <a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10" href="#">Reserve Your Spot</a> </div>
          </div>
        </div> -->
        
        <!-- /item -->
     <!--    <div class="item">
          <div class="box_grid">
            <figure> <a href="#0" class="wish_bt"></a> <a href="#">
              <div class="preview-new"><span><i class="fa fa-calendar-check-o"></i> 16 OCT 2019<br>
                3:00 PM</span></div>
              <img src="{{asset('assets/images/web2.jpg')}}" class="img-fluid" alt=""></a> </figure>
            <div class="wrapper"> <small>Category</small>
              <h3 class="mb-10">DB
                System</h3>
              <a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10" href="#">Reserve Your Spot</a> </div>
          </div>
        </div> -->
        <!-- /item -->
       <!--  <div class="item">
          <div class="box_grid">
            <figure> <a href="#0" class="wish_bt"></a> <a href="#">
              <div class="preview-new"><span><i class="fa fa-calendar-check-o"></i> 22 OCT 2019<br>
                11:00 AM</span></div>
              <img src="{{asset('assets/images/web3.jpg')}}" class="img-fluid" alt=""></a> </figure>
            <div class="wrapper"> <small>Category</small>
              <h3 class="mb-10">AI/ML</h3>
              <a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10" href="#">Reserve Your Spot</a> </div>
          </div>
        </div> -->
        <!-- /item -->
       <!--  <div class="item">
          <div class="box_grid">
            <figure> <a href="#0" class="wish_bt"></a> <a href="#">
              <div class="preview-new"><span><i class="fa fa-calendar-check-o"></i> 28 OCT 2019<br>
                3:00 PM</span></div>
              <img src="{{asset('assets/images/web1.jpg')}}" class="img-fluid" alt=""></a> </figure>
            <div class="wrapper"> <small>Category</small>
              <h3 class="mb-10">System Admin</h3>
              <a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10" href="#">Reserve Your Spot</a> </div>
          </div>
        </div> -->
        
        <!-- /item -->
       <!--  <div class="item">
          <div class="box_grid">
            <figure> <a href="#0" class="wish_bt"></a> <a href="#">
              <div class="preview-new"><span><i class="fa fa-calendar-check-o"></i> 1 NOV 2019<br>
                10:00 AM</span></div>
              <img src="{{asset('assets/images/web2.jpg')}}" class="img-fluid" alt=""></a> </figure>
            <div class="wrapper"> <small>Category</small>
              <h3 class="mb-10">Data Analytics</h3>
              <a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10" href="#">Reserve Your Spot</a> </div>
          </div>
        </div> -->
        <!-- /item -->
     <!--    <div class="item">
          <div class="box_grid">
            <figure> <a href="#0" class="wish_bt"></a> <a href="#">
              <div class="preview-new"><span><i class="fa fa-calendar-check-o"></i> 7 NOV 2019<br>
                2:00 PM</span></div>
              <img src="{{asset('assets/images/web3.jpg')}}" class="img-fluid" alt=""></a> </figure>
            <div class="wrapper"> <small>Category</small>
              <h3 class="mb-10">Cyber/App Security</h3>
              <a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10" href="#">Reserve Your Spot</a> </div>
          </div>
        </div> -->
        <!-- /item --> 
      <!-- </div>
    </div>
  </div> -->
  <!--graph section-->
  <div class="container-fluid">
    <div class="row mgt-90">
      <div class="col-sm-12 col-lg-6">
        <div class="card">
          <div class="card-tittle" id="schoolCollagePanel"> Classroom Training<span> <span class="chartIcon"><img src="{{asset('assets/images/icon/line.svg')}}" id="lineChartBtn"></span> <span class="chartIcon"><img src="{{asset('assets/images/icon/bar-chart.svg')}}" id="barChartBtn"></span> <span class="chartIcon"><img src="{{asset('assets/images/icon/filter.svg')}}" class="filterBtn-1"> </span> </div>
          <!--filter Box-->
          <div class="filterPanel f-box-1" style="display:none;">
            <div class="row">
              <div class="col-md-4">
                <p>Name of insecticide</p>
                <select class="form-control">
                  <option value="#">2,4-Dichlorophenoxy Acetic Acid</option>
                  <option value="#">Alachlor</option>
                  <option value="#">Alpha cypermethrin</option>
                  <option value="#">Benfuracarb</option>
                  <option value="#">Beta Cyfluthrin</option>
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
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class=""></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
              </div>
            </div>
            <canvas id="webinarsChart" class="chartjs-render-monitor" width="479" height="255" style="display: block; width: 479px; height: 255px;"></canvas>
          </div>
        </div>
      </div>
      
      <!---graph 2-->
      <div class="col-sm-12 col-lg-6">
        <div class="card">
          <div class="card-tittle" id="constituencyPanel"> Trending Courses <span> <span class="chartIcon"><img src="{{asset('assets/images/icon/line.svg')}}" id="lineChartBtn"></span> <span class="chartIcon"><img src="{{asset('assets/images/icon/bar-chart.svg')}}" id="barChartBtn"></span> <span class="chartIcon"><img src="{{asset('assets/images/icon/filter.svg')}}" class="filterBtn-2"> </span> </div>
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
  <!--graph section emds--> 
  
  <!--section-4--> 
  
  <!--./tab-->
  <div class="container-fluid">
  <div class=" Popular_courses" style="position: relative;">
    <div class="main_title_2 text-center"> <span><em></em></span>
      <h2 class="heading"> Trending Courses</h2>
    </div>
     <div id="slider-1">
      @foreach($trendingcourse as $trendingcourses)
      <div class="item">
        <div class="box_grid">
          <div class="slender">
          <figure>
           <!-- <a href="#0" class="wish_bt"></a>  -->
           <a href="{{ route('courses.show', [$trendingcourses->slug]) }}">
           <!--  <div class="preview"><span class="pointer">E-learning</span></div> -->
            <img src="{{asset('storage/uploads/'.$trendingcourses->course_image)}}" class="img-fluid" alt=""></a> </figure>
          <div class="wrapper"> <small>{{$trendingcourses->name}}</small>
            <h3 class="mb-10">@if(strlen(strip_tags($trendingcourses->title))>=17){{substr(strip_tags(ucwords($trendingcourses->title)), 0, 17)}}...@else{{strip_tags(ucwords($trendingcourses->title))}}@endif</h3>

            <h6>@if(strlen(strip_tags($trendingcourses->description))>=25){{substr(strip_tags($trendingcourses->description), 0, 25)}}...@else{{strip_tags($trendingcourses->description)}} @endif</h6>
            <div class="starMarking">
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star unchecked"></span>
            <span class="fa fa-star unchecked"></span> 
            <span class="rating_detail">4</span>
            <span class="ratingSpan">(18541)</span>
            </div>
            <div> <p>3500 Enroll Students  <a href="{{ route('courses.show', [$trendingcourses->slug]) }}"><i class='fa fa-align-justify pull-right dicon-view'></i></a></p>

            </div>
            <!-- <a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10" href="{{ route('courses.show', [$trendingcourses->slug]) }}">view details</a> --> </div>
        </div>
        </div>
      </div>
      
      @endforeach 
    </div> 

     <!--div on hover effect--> 
       <div class="hover_effect">
            <div class="date_update">
                <p>Last Updated:09/2019</p>
                <h3>Beginner to Pro in Excel : Financial Modeling and Valuation</h3>
                  <ol class="breadcrumb bestseller_crumbs">
                 <li class="breadcrumb-item"><a href="#">Financial Modeling </a></li>
                  <li class="breadcrumb-item"><a href="#">Business</a></li>
               </ol>
            <ul class="bestseller_course">
            <li> <i class="fa fa-play-circle-o"></i>  219 lectures </li>
            <li><i class="fa fa-clock-o"></i>  12 hours </li>
            <li><i class="fa fa-level-up"></i> All Levels </li>
           </ul>
          <p>Financial Modeling in Excel that would allow you to walk into a job and be a rockstar from day one!
          </p>
          <ul class="list-unstyled">
          <li>Master Microsoft Excel and many of its advanced features</li>
        <li>Become one of the top Excel users in your team</li>
         <li>Carry out regular tasks faster than ever before </li>
        </ul>
            </div>
</div>
<!--div on hover effetc ends--> 

  </div>
  </div>




  <!--sction 3 starts-->
  <section class="sec3">
    <div class="container-fluid"> 
      <!--row 1 starts-->
      
      <h2 class="heading"> Exclusive Features </h2>
      <div class="row" style="padding-top: 21px;">
        
        <div class="col">
          <div class="cartoon_img"> <img src="{{asset('assets/images/exclusive/capacity.png')}}">
            <h5>Capacity Building</h5>
            <p></p>
          </div>
        </div>
        <div class="col">
          <div class="cartoon_img"> <img src="{{asset('assets/images/exclusive/individual.png')}}">
            <h5>Individual Grooming</h5>
            <p></p>
          </div>
        </div>
        <div class="col">
          <div class="cartoon_img"> <img src="{{asset('assets/images/exclusive/multiplatform.png')}}">
            <h5>Multi Platform Accesibility</h5>
            <p></p>
          </div>
        </div>
        <div class="col">
          <div class="cartoon_img"> <img src="{{asset('assets/images/exclusive/selfassesment.png')}}">
            <h5>Self Assesment</h5>
            <p></p>
          </div>
        </div>

            <div class="col">
          <div class="cartoon_img"> <img src="{{asset('assets/images/exclusive/panindia.png')}}">
            <h5>PAN India Access</h5>
            <p></p>
          </div>
        </div>
        
        <!-- /.row 1 ends--> 
      </div>
   
    </div>
  </section>
  <!--section 3 ends--> 
  
  <!--section 4 starts-->
  
  <!-- <section class="sec4 text-center">
    <div class="container"> <img src="{{asset('assets/images/circle.png')}}" > </div>
  </section>-->  
  <!---tab-->
@endsection

@push('after-scripts')
    <script>
        $('ul.product-tab').find('li:first').addClass('active');
		 $(function() {
    $('#ticker01').cycle({ 
      fx: 'fade', 
      pause: 1 
    });
  }); 
    </script>
		
		
@endpush


