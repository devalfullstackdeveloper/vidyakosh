@extends('frontend.layouts.app'.config('theme_layout'))
@section('title', trans('labels.frontend.course.courses').' | '. app_name() )
@push('after-styles')
@endpush
@section('content')


        
        
        
       <!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content">
                    <h2 class="breadcrumb__title">@if(isset($category)) {{$category->name}} @else @lang('labels.frontend.course.courses') @endif </h2>
                    <ul class="breadcrumb__list">
                        <li class="active__list-item"><a href="{{url('/')}}">home</a></li>
                        <li class="active__list-item">@if(isset($category)) {{$category->name}} @else @lang('labels.frontend.course.courses') @endif </li>
                       
                    </ul>
                    <div class="inner-form-action">
                    <form action="{{route('search-course')}}" method="get">
                                    <div class="row">
                                        <div class="col-lg-12 form-group">
                                            <input class="form-control" type="text" name="q" placeholder="Search courses..."  autocomplete="off">
 
                                            <button class="la la-search search-icon"
                                            type="submit"></button> 

                                            <!-- <span class="la la-search search-icon"></span> -->
                                        </div><!-- end col-lg-6 -->

                                        <span class="advancIcon"><a href="#">Advance Search</a></span>
                                    </div><!-- end row -->
                    </form>
                    </div>
                    
                    <div class="text-outline">course List</div>
                </div><!-- end breadcrumb-content -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end breadcrumb-area -->
<!-- ================================ 
        
 <!-- ================================
       START FUNFACT AREA
================================= -->
<section class="funfact-area text-center pt-4 pb-4">
     <div class="container">
        <div class="funfact-row">
            <div class="funfact-item">
                <div class="funfact-inner-item">
                    <span class="la la-book"></span>
                    <h4 class="funfact__title counter">{{$coursescount}}</h4>
                    <p class="funfact__meta"> Total E-learning <br> Courses</p>
                </div><!-- end client-testimonial -->
            </div><!-- end col-lg-3 -->
            <div class="funfact-item">
                <div class="funfact-inner-item">
                    <span class="la la-file"></span>
                    <h4 class="funfact__title counter">{{$usercount}}</h4>
                    <p class="funfact__meta">Total learners<!--Training--></p>
                </div><!-- end client-testimonial -->
            </div><!-- end col-lg-3 -->
            <div class="funfact-item">
                <div class="funfact-inner-item">
                    <span class="la la-users"></span>
                    <h4 class="funfact__title counter">{{$crttrainingcount}}</h4>
                    <p class="funfact__meta">Total CRT Trainees <br> (Overall)</p>
                </div><!-- end client-testimonial -->
            </div><!-- end col-lg-3 -->
            <div class="funfact-item">
                <div class="funfact-inner-item">
                    <span class="la la-users"></span>
                    <h4 class="funfact__title counter">{{$crtcurrentcount}}</h4>
                    <p class="funfact__meta">Total CRT Trainees <br> (Current Year)</p>
                </div><!-- end client-testimonial -->
            </div><!-- end col-lg-3 -->
            <div class="funfact-item">
                <div class="funfact-inner-item">
                    <span class="la la-bullhorn"></span>
                    <h4 class="funfact__title counter">890</h4>
                    <p class="funfact__meta">Total Webinar</p>
                </div><!-- end client-testimonial -->
            </div><!-- end col-lg-3 -->

            <div class="funfact-item">
                <div class="funfact-inner-item">
                    <span class="la la-edit"></span>
                    <h4 class="funfact__title counter">{{$executivebrifing}}</h4>
                    <p class="funfact__meta">Total Executive <br>Briefing</p>
                </div><!-- end client-testimonial -->
            </div><!-- end col-lg-3 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end funfact-area -->
<!-- ================================
       START FUNFACT AREA
================================= -->       
        
<div class="section-divider"></div>     
        
 <!--======================================
        START COURSE AREA
======================================-->
<section class="course-area course-area4 pt-5 pb-5">
    <div class="course-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="course-tab-wrap d-flex align-items-center">
                        <ul class="course-tab-list nav nav-tabs align-items-center" role="tablist"
                            id="review">
                            <li role="presentation">
                                <a href="#tab1" role="tab" data-toggle="tab" class="active" aria-selected="true">
                                    <span class="la la-th-large" data-toggle="tooltip" data-placement="top" title="Grid view"></span>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#tab2" role="tab" data-toggle="tab" aria-selected="false">
                                    <span class="la la-th-list" data-toggle="tooltip" data-placement="top" title="List view"></span>
                                </a>
                            </li>
                            <li><span class="courses-showing-text">{{$coursescount}}Courses Found</span></li>
                        </ul>
                        <div class="course-filter d-flex align-items-center ml-auto">
                     <!--   <div class="courses-ordering"  style="margin-right:10px;">
                                <select class="target-course" id="sortbycategory">
                                <option value="all-category">Select Category</option>
                                @if(count($categories) > 0)
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                                @endif
                                </select>
                            </div>  -->
                            <!-- end courses-ordering -->
                            <div class="courses-ordering" style="width: 150px; margin-right:10px;">
                                <select id="sortbyrating" class="target-course">
                                    <option value="">Ratings by</option>
                                    <option value="good">1</option>
                                    <option value="average">2</option>
                                    <option value="classic">3</option>
                                    <option value="best">4</option>
                                    <option value="perfect">5</option>
                                </select>
                            </div>

                            <!-- end courses-ordering -->
                        
                        <div class="courses-ordering" style="width: 110px;">
                        
                           
                          <!--  <span>@lang('labels.frontend.course.sort_by')</span>-->
                            <select id="sortBy" class="target-course">
                             <option value="">@lang('labels.frontend.course.sort_by')</option>
                                <option value="">@lang('labels.frontend.course.none')</option>
                                <option value="popular">@lang('labels.frontend.course.popular')</option>
                                <option value="trending">@lang('labels.frontend.course.trending')</option>
                                <option value="featured">@lang('labels.frontend.course.featured')</option>
                            </select>
                     
                           
                            </div><!-- end courses-ordering -->
                        
                           
                        </div><!-- end course-filter -->
                    </div><!-- end course-tab-wrap -->
                </div><!-- end col-lg-12 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end course-wrapper -->
    <div class="course-content-wrapper">
        <div class="container">
            <div class="row course-item-wrap">
                <div class="col-lg-8">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade show active" id="tab1">
                            <div class="row course-block">
                                 @if($courses->count() > 0)
                                            @foreach($courses as $course)

                                <div class="col-lg-6">
                                    <div class="course-item">
                                <div class="course-img">
                                    <a href="{{ route('courses.show', [$course->slug]) }}" class="course__img"><img src="{{asset('storage/uploads/'.$course->course_image)}}" alt=""></a>
                                    <div class="course-tooltip">
                                        <span class="tooltip-label">E-learning</span>
                                    </div>
                                </div><!-- end course-img -->
                                <div class="course-content">
                                    <p class="course__label">
                                        <span class="course__label-text">{{$course->category->name}}</span>
                                        <a href="{{route('courses.category',['category'=>$course->category->slug])}}" class="course__collection-icon" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="la la-heart-o"></span></a>
                                    </p>
                                    <h3 class="course__title">
                                        <a href="{{ route('courses.show', [$course->slug]) }}">
                                        @if(strlen(strip_tags($course->title))>25){{substr(strip_tags(ucwords($course->title)), 0, 22)}}...@else{{strip_tags(ucwords($course->title))}}@endif
                                        </a>
                                    </h3>
                                    <p class="course__author">

                                        @if(strlen(strip_tags($course->description))>=25){{substr(strip_tags($course->description), 0, 65)}}...@else{{strip_tags($course->description)}} @endif


                                        <!-- {{ str_limit(strip_tags($course->description), 100) }}
                                                    @if(strlen(strip_tags($course->description)) > 100)
                                                      <a href="{{route('courses.category',['category'=>$course->category->slug])}}">Read More</a>
                                                    @endif -->
                                    </p>
                                    <div class="rating-wrap d-flex">
                                        <ul class="review-stars d-flex">
                                            @for($i=1; $i<=(int)$course->rating; $i++)
                                            <li><span class="la la-star"></span></li>
                                            @endfor
                                           @for($i=(int)$course->rating+1;$i<=5;$i++)
                                            <li><i class="la la-star"></i></li>
                                          @endfor
                                        </ul>
                                        <span class="star-rating-wrap">
                                            <!-- <span class="star__rating">4.2</span> -->
                                            <span class="star__count">({{(int)$course->rating}})</span>
                                        </span>
                                    </div><!-- end rating-wrap -->
                                    <div class="course-meta">
                                        <ul class="course__list d-flex">
                                            <li><span class="meta__date"><i class="la la-play-circle"></i> 45 Classes</span></li>
                                            <li><span class="meta__date"><i class="la la-clock-o"></i> 3 hours 20 min</span></li>
                                        </ul>
                                    </div><!-- end course-meta -->
                                    <div class="course-price-wrap">
                                        <span class="course__price"><span class="course__before-price">Trainees</span> <span class="StudentsNo">{{ $course->students()->count() }}</span></span>
                                        <a href="{{ route('courses.show', [$course->slug]) }}" class="course__btn">Read More</a>
                                    </div><!-- end course-price-wrap -->
                                </div><!-- end course-content -->
                            </div><!-- end course-item -->
                                </div><!-- end col-lg-6 -->


                                      @endforeach
                                        @else
                                            <h3>@lang('labels.general.no_data_available')</h3>
                                    @endif
                              
                            </div><!-- end course-block -->
                        </div><!-- end tab-pane -->

                        <div role="tabpanel" class="tab-pane fade" id="tab2">
                            <div class="row course-block course-list-block">
                                @if($courses->count() > 0)
                                            @foreach($courses as $course)

                                <div class="col-lg-12">
                                    <div class="course-item">
                                        <div class="course-img">
                                            <a href="{{ route('courses.show', [$course->slug]) }}" class="course__img"><img src="{{asset('storage/uploads/'.$course->course_image)}}" alt=""></a>
                                        </div><!-- end course-img -->
                                        <div class="course-content">
                                            <p class="course__label">
                                                <span class="course__label-text">E-LEARNING</span>
                                                <a href="#" class="course__collection-icon" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="la la-heart-o"></span></a>
                                            </p>
                                            <h3 class="course__title">
                                                <a href="{{ route('courses.show', [$course->slug]) }}"> @if(strlen(strip_tags($course->title))>25){{substr(strip_tags(ucwords($course->title)), 0, 22)}}...@else{{strip_tags(ucwords($course->title))}}@endif</a>
                                            </h3>
                                            <p class="course__author">
                                                 {{ str_limit(strip_tags($course->description), 100) }}
                                                    @if(strlen(strip_tags($course->description)) > 100)
                                                      <a href="{{route('courses.category',['category'=>$course->category->slug])}}">Read More</a>
                                                    @endif
                                            </p>
                                            <div class="rating-wrap d-flex">
                                                <ul class="review-stars d-flex">

                                                    @for($i=1; $i<=(int)$course->rating; $i++)
                                                    <li><span class="la la-star"></span></li>
                                                    @endfor
                                                     @for($i=(int)$course->rating+1;$i<=5;$i++)
                                                        <li><i class="la la-star"></i></li>
                                                      @endfor
                                                    
                                                </ul>
                                                <span class="star-rating-wrap">
                                                    <!-- <span class="star__rating">4.4</span> -->
                                                    <span class="star__count">({{(int)$course->rating}})</span>
                                                </span>
                                            </div><!-- end rating-wrap -->
                                            <div class="course-meta">
                                                <ul class="course__list d-flex">
                                                    <li>
                                                        <span class="meta__date">
                                                            <i class="la la-play-circle"></i> 45 Classes
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span class="meta__date">
                                                            <i class="la la-clock-o"></i> 3 hours 20 min
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div><!-- end course-meta -->
                                            <div class="course-price-wrap">
                                                <span class="course__price">Trainees <span class="TraineesNo">{{ $course->students()->count() }}</span></span>
                                                <a href="{{ route('courses.show', [$course->slug]) }}" class="course__btn">Read More</a>
                                            </div><!-- end course-price-wrap -->
                                        </div><!-- end course-content -->
                                    </div>
                                </div><!-- end col-lg-12 -->
                               @endforeach
                                        @else
                                            <h3>@lang('labels.general.no_data_available')</h3>
                                    @endif




                            </div><!-- end course-block -->
                        </div><!-- end tab-pane -->
                    </div><!-- end tab-content -->
                    <div class="pagination-wrap">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                  {{ $courses->links() }}
                                </li>
                            </ul>
                        </nav>
                    </div><!-- end pagination-wrap -->
                </div><!-- end col-lg-8 -->
                <div class="col-lg-4">
                    <div class="sidebar">

                        <div class="sidebar-widget">
                            <h3 class="widget__title">@lang('labels.frontend.course.find_your_course')</h3>
                            <span class="section__divider"></span>
                        <div class="side-bar-widget  first-widget">
                            
                            <div class="listing-filter-form pb30">
                                <form action="{{route('search-course')}}" method="get">

                                     <div class="courses-ordering mb20">
                                        <!--<label class="text-uppercase">@lang('labels.frontend.course.category')</label>-->
                                        <select name="category" class="target-course">
                                            <option value="">@lang('labels.frontend.course.select_category')</option>
                                            @if(count($categories) > 0)
                                                @foreach($categories as $category)
                                                    <option @if(request('category') && request('category') == $category->id) selected
                                                            @endif value="{{$category->id}}">{{$category->name}}</option>

                                                @endforeach
                                            @endif

                                        </select>
                                    </div> 
                                    <!-- <div class="filter-search mb20">
                                        <label>@lang('labels.frontend.course.full_text')</label>
                                        <input type="text" class="" name="q" placeholder="{{trans('labels.frontend.course.looking_for')}}">
                                    </div>  -->
                                    <button class="theme-btn w-100 text-center"
                                            type="submit">@lang('labels.frontend.course.find_courses') <i
                                                class="fa fa-caret-right"></i></button> 
                                </form>

                            </div>
                        </div>
                        </div>



                        <div class="sidebar-widget">
                            <h3 class="widget__title">Search field</h3>
                            <span class="section__divider"></span>
                            <div class="contact-form-action">
                                <form action="{{route('search-course')}}" method="get">
                                    <div class="form-group">
                                    <div class="mb20">
                                        <input class="form-control" type="search" name="q" placeholder="Search courses...">
                                    </div>
                                        <button class="theme-btn w-100 text-center"
                                        type="submit" class="la la-search">@lang('labels.frontend.course.find_courses')</button>
                                    </div>
                                    <span class="advancIcon2"><a href="#">Advance Search</a></span>
                                </form>
                            </div><!-- end contact-form-action -->
                        </div><!-- end sidebar-widget -->
                        
                        
                        <!-- end sidebar-widget -->
                        <div class="sidebar-widget category-widget">
                            <h3 class="widget__title">Categories</h3>
                            <span class="section__divider"></span>
                            <ul class="widget__list">
                                @if(count($categories) > 0)
                                @foreach($categories as $category)
                                <li><a href="{{route('searchCoursebycat',['catid'=>$category->id])}}">{{$category->name}}</a></li>
                                @endforeach
                                @endif
                            </ul>
                        </div><!-- end sidebar-widget -->
                         <div class="sidebar-widget sort-widget">
                            <h3 class="widget__title">Event Calendar</h3>
                            <span class="section__divider"></span>
                            <div class="courses-ordering">
                            <input class="target-course" type="date" name="search" placeholder="Search courses..." autocomplete="off">
                                
                            </div><!-- end courses-ordering -->
                        </div><!-- end sidebar-widget -->
                        
                        <div class="sidebar-widget sort-widget">
                            <h3 class="widget__title">Exclusive Features</h3>
                            <span class="section__divider"></span>
                            <div class=" ExclusiveFeatures">
                            <div class="blog-post-carousel-2 pt-0"  id="course-area2">
                            <div class="atAy">
                            <img src="{{asset('assets/images/img50.jpg')}}" alt="blog image" class="blog__img">
                            <span>Capacity Building</span>
                            </div>
                             <div class="atAy">
                            <img src="{{asset('assets/images/img51.jpg')}}" alt="blog image" class="blog__img">
                            <span>Individual Grooming</span>
                            </div>
                             <div class="atAy">
                            <img src="{{asset('assets/images/img52.jpg')}}" alt="blog image" class="blog__img">
                            <span>Multi Platform Accesibility</span>
                            </div>
                             <div class="atAy">
                            <img src="{{asset('assets/images/img53.jpg')}}" alt="blog image" class="blog__img">
                            <span>Self Assesment</span>
                            </div>
                             <div class="atAy">
                            <img src="{{asset('assets/images/img54.jpg')}}" alt="blog image" class="blog__img">
                            <span>PAN India Access</span>
                            </div>
                            </div>
                                
                            </div><!-- end courses-ordering -->
                        </div><!-- end sidebar-widget -->
                        
                        
                        <div class="sidebar-widget level-widget">
                            <h3 class="widget__title">Levels</h3>
                            <span class="section__divider"></span>
                            <ul class="instructor__list">
                                <li>
                                    <div class="custom-checkbox">
                                        <input type="radio" name="level" value="1" id="level"/>
                                        <label for="chb1">Beginner</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-checkbox">
                                        <input type="radio" name="level" value="2" id="level"/>
                                        <label for="chb2">Intermediate</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-checkbox">
                                        <input type="radio" name="level" value="3" id="level"/>
                                        <label for="chb3">Advanced</label>
                                    </div>
                                </li>
                            </ul>
                        </div><!-- end sidebar-widget -->
                       
                        <!-- end sidebar-widget -->
                        <div class="sidebar-widget rating-widget">
                            <h3 class="widget__title">Ratings</h3>
                            <span class="section__divider"></span>
                            <ul class="rating__list">
                                <li>
                                    <span class="la la-star"></span><span class="la la-star"></span><span class="la la-star"></span><span class="la la-star"></span><span class="la la-star"></span>
                                    <label class="review-label">
                                        <input type="radio" checked="checked" id="review_radio" value= "5" name="review-radio">
                                        <span class="review-mark"></span>
                                    </label>
                                </li>
                                <li>
                                    <span class="la la-star"></span> <span class="la la-star"></span><span class="la la-star"></span><span class="la la-star"></span>
                                    <label class="review-label">
                                        <input type="radio" id="review_radio" value= "5" name="review-radio">
                                        <span class="review-mark"></span>
                                    </label>
                                </li>
                                <li>
                                    <span class="la la-star"></span><span class="la la-star"></span><span class="la la-star"></span>
                                    <label class="review-label">
                                        <input type="radio" id="review_radio" value= "5" name="review-radio">
                                        <span class="review-mark"></span>
                                    </label>
                                </li>
                                <li>
                                    <span class="la la-star"></span><span class="la la-star"></span>
                                    <label class="review-label">
                                        <input type="radio" id="review_radio" value= "5" name="review-radio">
                                        <span class="review-mark"></span>
                                    </label>
                                </li>
                                <li>
                                    <span class="la la-star"></span>
                                    <label class="review-label">
                                        <input type="radio" id="review_radio" value= "5" name="review-radio">
                                        <span class="review-mark"></span>
                                    </label>
                                </li>
                            </ul>
                        </div><!-- end sidebar-widget -->
                        @if($global_featured_course != "")
                         <div class="sidebar-widget rating-widget">
                            <h3 class="widget__title">@lang('labels.frontend.course.featured_course')</h3>
                            <span class="section__divider"></span>
                          
                                <div class="featured-course">
                                    <div class="best-course-pic-text relative-position pt-0">
                                        <div class="best-course-pic relative-position "
                                             @if($global_featured_course->course_image != "") style="background-image: url({{asset('storage/uploads/'.$global_featured_course->course_image)}})" @endif>

                                            @if($global_featured_course->trending == 1)
                                                <div class="trend-badge-2 text-center text-uppercase">
                                                    <i class="fa fa-bolt"></i>
                                                    <span>@lang('labels.frontend.badges.trending')</span>
                                                </div>
                                            @endif
                                                <!-- @if($global_featured_course->free == 1)
                                                    <div class="trend-badge-3 text-center text-uppercase">
                                                        <i class="fa fa-bolt"></i>
                                                        <span>@lang('labels.backend.courses.fields.free')</span>
                                                    </div>
                                                @endif -->

                                        </div>
                                        <div class="best-course-text" style="padding:10px;">
                                            <div class="course-title headline relative-position mb-2">
                                                <h3>
                                                    <a href="{{ route('courses.show', [$global_featured_course->slug]) }}">{{$global_featured_course->title}}</a>
                                                </h3>
                                            </div>
                                            <div class="course-meta">
                                                <span class="course-category"><a
                                                            href="{{route('courses.category',['category'=>$global_featured_course->category->slug])}}">{{$global_featured_course->category->name}}</a></span>
                                                <span class="course-author">{{ $global_featured_course->students()->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                          
                       
                        </div><!-- end sidebar-widget -->
                         @endif
                        
                    </div><!-- end sidebar -->
                </div><!-- end col-lg-4 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end course-content-wrapper -->
</section><!-- end courses-area -->
<!--======================================
        END COURSE AREA
======================================-->       
        
        
        
        


    <!-- Start of course section
        ============================================= -->
   
    <!-- End of course section
        ============================================= -->

    <!-- Start of best course
   =============================================  -->
   {{--@include('frontend.layouts.partials.browse_courses')--}}
    <!-- End of best course
            ============================================= -->


@endsection

@push('after-scripts')
   <script>
        $(document).ready(function () {
            $(document).on('change', '#sortBy', function () {
                if ($(this).val() != "") {
                    location.href = '{{url()->current()}}?type=' + $(this).val();
                } else {
                    location.href = '{{route('courses.all')}}';
                }
            });

            @if(request('type') != "")
            $('#sortBy').find('option[value="' + "{{request('type')}}" + '"]').attr('selected', true);
            @endif


//----------------------sort by ratting-----------------------------------//
 $(document).on('change', '#sortbyrating', function () {
                if ($(this).val() != "") {
                    location.href = '{{url()->current()}}?type=' + $(this).val();
                } else {
                    location.href = '{{route('courses.all')}}';
                }
            });

            @if(request('type') != "")
            $('#sortbyrating').find('option[value="' + "{{request('type')}}" + '"]').attr('selected', true);
            @endif
      
        //----------------------sort by level------------------------------//

      $(document).on('click', '#level', function () {
                 var id = $(this).val();
                     if (id != "") { 
                     location.href = "{{url('/searchCoursebylevel/')}}"+"/"+id;
                    //alert(url);
                } 
            });
    //----------------------sort by ratting-------------------------------//
      // $(document).on('click', '#level', function () {
      //            var id = $(this).val();
      //                if (id != "") { 
      //                location.href = "{{url('/searchCoursebylevel/')}}"+"/"+id;
      //               //alert(url);
      //           } 
      //       });
      
      });

    </script>
@endpush
