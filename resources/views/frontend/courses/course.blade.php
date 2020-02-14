@extends('frontend.layouts.app'.config('theme_layout'))

@section('title', ($course->meta_title) ? $course->meta_title : app_name() )
@section('meta_description', $course->meta_description)
@section('meta_keywords', $course->meta_keywords)

@push('after-styles')
    <style>
        .leanth-course.go {
            right: 0;
        }

    </style>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.5.3/plyr.css"/>

@endpush

@section('content')

    <!-- Start of breadcrumb section
        ============================================= -->
    <!-- <section id="breadcrumb" class="breadcrumbSection">
        
       <div class="container">
        <nav class="breadcrumb">
  <a class="breadcrumb-item" href="{{url('/')}}"><strong>Home</strong></a>
  <a class="breadcrumb-item" href="#">{{$course->category->name}}</a>
  <span class="breadcrumb-item active">{{$course->title}}</span>
</nav>
       </div> 
    </section> -->
    <!-- End of breadcrumb section
        ============================================= -->
        
        
        
        <!-- ================================
    START banner AREA
================================= -->
<section class="breadcrumb-area breadcrumb-area2" style="height: 220px;">
	<div class="inner_home_icon">
                        <a href="{{url('/')}}">
                        <i class="fa fa-home"></i>
                    </a>
                    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content">
                    <p class="breadcrumb__meta"><span class="seller-badge">E-LEARNING</span></p>
                    <h2 class="breadcrumb__title">{{$course->title}}</h2>
                    <!--<h3>{!! $course->description !!}</h3>-->
                    <ul class="breadcrumb__list">
                        <li><b>@lang('labels.frontend.course.ratings')</b></li>
                        <li>
                            <div class="starMarking">
                            	@for($i=1; $i<=(int)$course->rating; $i++)
                            		<span class="fa fa-star"></span>
                            	@endfor
                        	</div>
                            ({{(int)$course->rating}} @lang('labels.frontend.course.ratings'))
                        </li>
                        <li>{{ $course->students()->count() }}  @lang('labels.frontend.course.enrolled') </li>
                       
                    </ul>
                </div><!-- end breadcrumb-content -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END banner AREA
================================= -->
        
 <!--======================================
        START COURSE DETAIL
======================================-->
<section class="course-detail">
    <div class="container">
        <div class="row course-item-wrap">
            <div class="col-lg-8">
                <div class="course-item-content">

                  <div class="iconMoveBox">
                    <ul id="myNavbar">
                        <li><a href="#CourseContent"> <i class="la la-user feature__icon"></i>
                            <span>Course Content</span></a>
                        </li>

                        <li><a href="#CourseFeatures"> <i class="la la-graduation-cap feature__icon"></i>
                            <span>Course Features</span></a>
                        </li>
                        
                         <li><a href="#RelatedCourses"> <i class="fa fa-file-text-o" aria-hidden="true"></i>
                            <span>Related courses</span></a>
                        </li>
                        
                         <li><a href="#ReviewsContent"> <i class="fa fa-comments-o" aria-hidden="true"></i>
                            <span>Reviews</span></a>
                        </li>
                        
                          </ul>
                        </div>

                   @if(session()->has('success'))
                        <div class="alert alert-dismissable alert-success fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{session('success')}}
                        </div>
                    @endif


                 <!-- <div class="what-you-get">
                        <h3 class="what-you-get__title course-detail__title">What you'll learn?</h3>
                        <ul class="what-you-get__items">
                            <li class="what-you-get__item">
                                <span class="la la-check-circle-o what-you-get__icon"></span>
                                <span class="what-you-get__text">Proven Tips and Tricks of the Digital Marketing Trade</span>
                            </li>
                            <li class="what-you-get__item">
                                <span class="la la-check-circle-o what-you-get__icon"></span>
                                <span class="what-you-get__text">How to Generate More Traffic and Leads for Your Brand</span>
                            </li>
                            <li class="what-you-get__item">
                                <span class="la la-check-circle-o what-you-get__icon"></span>
                                <span class="what-you-get__text">Growth Hacking</span>
                            </li>
                            <li class="what-you-get__item">
                                <span class="la la-check-circle-o what-you-get__icon"></span>
                                <span class="what-you-get__text">Marketing Strategy</span>
                            </li>
                            <li class="what-you-get__item">
                                <span class="la la-check-circle-o what-you-get__icon"></span>
                                <span class="what-you-get__text">Unique Ways of Promoting a Business from Scratch</span>
                            </li>
                            <li class="what-you-get__item">
                                <span class="la la-check-circle-o what-you-get__icon"></span>
                                <span class="what-you-get__text">Digital Marketing Tools and Strategies</span>
                            </li>
                            <li class="what-you-get__item">
                                <span class="la la-check-circle-o what-you-get__icon"></span>
                                <span class="what-you-get__text">Inbound Marketing</span>
                            </li>
                            <li class="what-you-get__item">
                                <span class="la la-check-circle-o what-you-get__icon"></span>
                                <span class="what-you-get__text">Income Statements</span>
                            </li>
                        </ul>
                    </div>--> <!-- end what-you-get -->
                 
                    <div class="description-wrap mt-4">
                        <h3 class="description__title course-detail__title">Description</h3>
                        
                         <p> <?=nl2br($course->description)?> </p>
                        
                        
                    </div><!-- end description-wrap -->
					@if($course->mediaVideo && $course->mediavideo->count() > 0)
						<div class="course-single-text">
							@if($course->mediavideo != "")
								<div class="course-details-content mt-3">
									<div class="video-container mb-5" data-id="{{$course->mediavideo->id}}">
										@if($course->mediavideo->type == 'youtube')
											<div id="player" class="js-player" data-plyr-provider="youtube"
												 data-plyr-embed-id="{{$course->mediavideo->file_name}}"></div>
										@elseif($course->mediavideo->type == 'vimeo')
											<div id="player" class="js-player" data-plyr-provider="vimeo"
												 data-plyr-embed-id="{{$course->mediavideo->file_name}}"></div>
										@elseif($course->mediavideo->type == 'upload')
											<video poster="" id="player" class="js-player" playsinline controls>
												<source src="{{$course->mediavideo->url}}" type="video/mp4"/>
											</video>
										@elseif($course->mediavideo->type == 'embed')
											{!! $course->mediavideo->url !!}
										@endif
									</div>
								</div>
							@endif
						</div>
					@endif
                    <div class="curriculum-wrap" id="CourseContent">
                        <div class="curriculum-header d-flex align-items-center">
                            <div class="curriculum-header-left">
                                <h3 class="requirements__title course-detail__title">Course Content</h3>
                            </div>
                            <div class="curriculum-header-right ml-auto">
                                <span class="curriculum-total__text"><strong>Total:</strong> {{$course->chapterCount()}} Lessons</span>
                                <!--span class="curriculum-total__hours"><strong>Total hours:</strong> 02:35:47</span-->
                            </div>
                        </div><!-- end curriculum-header -->
                        <div class="curriculum-content">
                            <div class="accordion course-accordion" id="accordionExample">
								@if(count($lessons)  > 0)
									@php $count = 0; @endphp
									@foreach($lessons as $key=> $lesson)
										@if($lesson->model && $lesson->model->published == 1)
											@php $count++ @endphp
										
											<div class="card">
												<div class="card-header" id="headingOne">
													<h2 class="mb-0">
														<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne{{$count}}" aria-expanded="true" aria-controls="collapseOne">
															<i class="la la-angle-up"></i>
															<i class="la la-angle-down"></i>
															{{ sprintf("%02d", $count)}} {{$lesson->model->title}}
															<span>
																@if($lesson->model_type == 'App\Models\Test')
																	@lang('labels.frontend.course.test')
																@endif
															</span>
															@if(auth()->check())
																@if(in_array($lesson->model->id,$completed_lessons))
															   <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Open Modal</button>-->
														       <span class="btn-text">
																   <a href="#" data-toggle="modal" data-target="#myModal12"><i class="fa fa-file-text-o"></i> </a> / 
																	@lang('labels.frontend.course.completed')
																	
																</span>
																@endif
															@endif
														</button>
													</h2>
												</div><!-- end card-header -->

												<div id="collapseOne{{$count}}" class="collapse show" aria-labelledby="headingOne" data-	parent="#accordionExample">
													<div class="card-body">
														<ul class="card-list">
															<li class="card-list-item">
																<span class="course-duration">
																@if(auth()->check())
																	@if(in_array($lesson->model->id,$completed_lessons))
																		<div class="pull-right df">
																			<a href="{{route('lessons.show',['id' => $lesson->course->id,'slug'=>$lesson->model->slug])}}"> <span                                                                            class="content-summary">@lang('labels.frontend.course.go') ></span></a>
																		</div>
																	@endif
																@endif
																</span>
																<p>
																	<i class="la la-play-circle-o course-play__icon"></i> 
																	@if($lesson->model_type == 'App\Models\Test')
																		<?=nl2br(mb_substr($lesson->model->full_text,0,20).'...')?>
																	@else
																	@if(auth()->check())
																		@if($lesson->model->scorm_lesson == 1)
																				<a href="javascript:;" onClick="PopUpWindows('{{config('app.scorm_url')}}launch/index.php?cid=																					{{$lesson->model->lessoncode}}&lid={{Auth::user()->id}}&type=lesson','Launcher');" 																								 title="Launch Course"><?=$lesson->model->title;?></a>
																		@endif
																	  @if($lesson->model->mediaPDF)
																		<div class="course-single-text mb-2">
																			{{--<iframe src="{{asset('storage/uploads/'.$lesson->model->mediaPDF->name)}}" width="100%"--}}
																			{{--height="500px">--}}
																			{{--</iframe>--}}
																			<div id="myPDF"></div>

																		</div>
																	@endif

																	<!--@if($lesson->model->mediaVideo && $lesson->model->mediavideo->count() > 0)
																		<div class="course-single-text">
																			@if($lesson->model->mediavideo != "")
																				<div class="course-details-content mt-3">
																					<div class="video-container mb-5" data-id="{{$lesson->model->mediavideo->id}}">
																						@if($lesson->model->mediavideo->type == 'youtube')
																							<div id="player" class="js-player" data-plyr-provider="youtube"
																								 data-plyr-embed-id="{{$lesson->model->mediavideo->file_name}}"></div>
																						@elseif($lesson->model->mediavideo->type == 'vimeo')
																							<div id="player" class="js-player" data-plyr-provider="vimeo"
																								 data-plyr-embed-id="{{$lesson->model->mediavideo->file_name}}"></div>
																						@elseif($lesson->model->mediavideo->type == 'upload')
																							<video poster="" id="player" class="js-player" playsinline controls>
																								<source src="{{$lesson->model->mediavideo->url}}" type="video/mp4"/>
																							</video>
																						@elseif($lesson->model->mediavideo->type == 'embed')
																							{!! $lesson->model->mediavideo->url !!}
																						@endif
																					</div>
																				</div>
																			@endif
																		</div>
																	@endif-->




																	@if(($lesson->model->downloadableMedia != "") && ($lesson->model->downloadableMedia->count() > 0))
																			@foreach($lesson->model->downloadableMedia as $media)
																				<div class="course-details-content text-white mb-2">
																					<p class="form-group">
																						<i class="la la-play-circle-o course-play__icon"></i><a href="{{ route('download',                      																			['filename'=>$media->name,'lesson'=>$lesson->model->id]) }}"
																						   class="">Download Here <i
																									class="fa fa-download" aria-hidden="true"></i></a>
																					</p>
																				</div>
																			@endforeach
																
																
																	@if($lesson->model->mediaAudio)
																            <audio id="audioPlayer" controls>
																				<source src="{{$lesson->model->mediaAudio->url}}" type="audio/mp3"/>
																			</audio>
																	@endif
																		
																	@endif
																
																
                            <!-----------------------------------------------------lesson description end---------------------------------------------->
																
																	@else
																	<?=nl2br($lesson->model->short_text)?>
																	   @endif
																	@endif
																</p>
															</li>
														</ul>
													</div><!-- end card-body -->
												</div><!-- end collapse -->
											</div><!-- end card -->
										@endif
									@endforeach
								@endif
							</div><!-- end accordion -->
                        </div><!-- end curriculum-content -->
                    </div><!-- end curriculum-wrap -->
                    <div class="view-more-courses" id="RelatedCourses">
                        <h3 class="view-more-courses__title course-detail__title">Related courses</h3>
                        <div class="course-block" id="relatedCoursesSd">

                            @foreach($subcourse as $subcoursedata)
  
                             <div class="col-12">
                            <div class="course-item">
                                <div class="course-img">
                                    <a href="{{ route('courses.show', [$course->slug]) }}" class="course__img"><img src="{{asset('storage/uploads/'.$course->course_image)}}" alt=""></a>
                                    <div class="course-tooltip">
                                        <span class="tooltip-label">E-learning</span>
                                    </div>
                                </div><!-- end course-img -->
                                <div class="course-content">
                                    <p class="course__label">
                                        <span class="course__label-text">{{$subcoursedata->name}}</span>
                                        <a href="#" class="course__collection-icon" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="la la-heart-o"></span></a>
                                    </p>
                                    <h3 class="course__title">
                                        <a href="{{ route('courses.show', [$course->slug]) }}" class="customtooltip" title="{{$subcoursedata->title}}">@if(strlen(strip_tags($subcoursedata->title))>25){{substr(strip_tags(ucwords($subcoursedata->title)), 0, 22)}}...@else{{strip_tags(ucwords($subcoursedata->title))}}@endif</a>
                                    </h3>
                                    <p class="course__author">
                                        <a href="{{ route('courses.show', [$course->slug]) }}"> @if(strlen(strip_tags($subcoursedata->description))>=25){{substr(strip_tags($subcoursedata->description), 0, 65)}}...@else{{strip_tags($subcoursedata->description)}} @endif</a>
                                    </p>
                                    <div class="rating-wrap d-flex">
                                        <ul class="review-stars d-flex">
                                           @for($i=1; $i<=5; $i++)
                                              <li><i class="la la-star"></i></li>
                                              @endfor
                                              </ul>
                                              <ul class="review-stars d-flex overlaystar">
                                            @foreach($rating as $item)
                                            @if(($item->reviewable_id)==($subcoursedata->id))
                                            @for($i=1; $i<=(int)$item->rating; $i++)
                                            <li><span class="la la-star"></span></li>
                                             @endfor
                                             @endif
                                             @endforeach 

                                        </ul>
                                        <span class="star-rating-wrap"> 
                                            <!-- <span class="star__rating">4.2</span> -->
                                            @foreach($rating as $item)
                                            @if(($item->reviewable_id)==($subcoursedata->id))
                                            <span class="star__count">({{(int)$item->rating}})</span>
                                            @endif
                                             @endforeach
                                        </span>
                                    </div><!-- end rating-wrap -->
                                    <div class="course-meta">
                                        <ul class="course__list d-flex">
                                            <li><span class="meta__date"><i class="la la-play-circle"></i> {{$course->chapterCount()}} Lessons</span></li>
                                            <li><span class="meta__date"><i class="la la-clock-o"></i> 3 hours 20 min</span></li>
                                        </ul>
                                    </div><!-- end course-meta -->
                                    <div class="course-price-wrap">
                                        <span class="course__price"><span class="StudentsNo">{{ $course->students()->count() }}</span> <span class="course__before-price">Enrolled</span></span>
                                        <a href="#" class="course__btn">Read More</a>
                                    </div><!-- end course-price-wrap -->
                                </div><!-- end course-content -->
                            </div><!-- end course-item -->
                            </div>

                            @endforeach
                        </div><!-- end view-more-carousel -->
                    </div><!-- end view-more-courses -->
                    <!-- end instructor-wrap -->
                    <div class="review-wrap" id="ReviewsContent">
                        <h3 class="review-wrap__title course-detail__title">@lang('labels.frontend.course.course_reviews')</h3>
                        <div class="review-content d-flex">
                            <div class="review-rating-summary" style="width:560px;">
                                <div class="review-rating-summary-inner d-flex align-items-end">
                                    <div class="stats-average__count">
                                        <span class="stats-average__count-count">{{$course_rating}}</span>
                                    </div><!-- end stats-average__count -->
                                    <div class="stats-average__rating d-flex">
                                    <ul class="d-flex ratingsColor">
                                                    @for($r=1; $r<=$course_rating; $r++)
                                                        <li><i class="fa fa-star"></i></li>
                                                    @endfor
                                                </ul>
                                     <p class="stats-average__rating-rating">{{$course_rating}} @lang('labels.frontend.course.ratings')</p>
                                    </div><!-- end stats-average__rating -->
                                </div><!-- end review-rating-summary-inner -->
                                <div class="course-rating-text">
                                    <p class="course-rating-text__text">@lang('labels.frontend.course.average_rating')</p>
                                </div><!-- end course-rating-text -->
                            </div><!-- end review-rating-summary -->
                            <div class="review-rating-widget">
                                <div class="review-rating-rate">
                                        
                     <ul>
                                    @for($r=5; $r>=1; $r--)
                                        <li class="review-rating-rate__items">
                                            <div class="review-rating-inner__item">
                                                <div class="review-rating-rate__item-text">{{$r}} @lang('labels.frontend.course.stars')</div>
                                                <div class="review-rating-rate__item-fill">
                                                    <span class="review-rating-rate__item-fill__fill rating-fill-width1" style="width:{{$course_rating}}% !important"></span>
                                                </div>
                                                <div class="review-rating-rate__item-percent-text">{{$course->reviews()->where('rating','=',$r)->get()->count()}}</div>
                                            </div>
                                        </li>
                                         @endfor
                                        
                                    
                                    </ul>
                                </div><!-- end review-rating-rate -->
                            </div><!-- end review-rating-widget -->
                        </div><!-- end review-content -->
                        <div class="comments-wrapper">
                            <h3 class="comments-title">Reviews</h3>
                              @if(count($course->reviews) > 0)
                            <ul class="comments-list">
                             @foreach($course->reviews as $item)
                                <li>
                                    <div class="comment">
                                     <img class="avatar__img" alt="" src="{{$item->user->picture}}">
                                    
                                        <div class="comment-body">
                                            <div class="meta-data">
                                                <h3 class="comment__author">@lang('labels.frontend.course.by') : {{$item->user->full_name}}</h3>
                                                <p class="comment__date">{{$item->created_at->diffforhumans()}}</p>
                                           
                                             <ul class="review-stars review-stars1">
                                                            @for($i=1; $i<=(int)$item->rating; $i++)
                                                                <li><i class="fa fa-star"></i></li>
                                                            @endfor
                                                        </ul>
                                                  
                                               </div>
                                            <p class="comment-content">
                                                {{$item->content}}
                                            </p>
                                           <div class="comment-reply">
                                                
                                                  @if(auth()->check() && ($item->user_id == auth()->user()->id))
                                                <p class="helpful__action">
                                                    
                                                     <a href="{{route('courses.review.edit',['id'=>$item->id])}}"
                                                               class="mr-2">@lang('labels.general.edit')</a>
                                                            <a href="{{route('courses.review.delete',['id'=>$item->id])}}"
                                                               class="text-danger">@lang('labels.general.delete')</a>
                                                </p>
                                                  @endif
                                                  
                                                  
                                            </div>
                                        </div>
                                    </div><!-- end comment -->
                                   
                                </li>
                                @endforeach
                            </ul>
                           
                            @else
                                <h4> @lang('labels.frontend.course.no_reviews_yet')</h4>
                            @endif
                            @if ($purchased_course)
                                @if(isset($review) || ($is_reviewed == false))
                                    <div class="reply-comment-box">
                                        <div class="review-option">
                                            <div class="section-title-2  headline text-left float-left">
                                                <h2>@lang('labels.frontend.course.add_reviews')</h2>
                                            </div>
                                            <div class="review-stars-item float-right mt15">
                                                <span>@lang('labels.frontend.course.your_rating'): </span>
                                                <div class="rating">
                                                    <label>
                                                        <input type="radio" name="stars" value="1"/>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="2"/>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="3"/>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="4"/>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="5"/>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                        <span class="icon"><i class="fa fa-star"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="teacher-faq-form">
                                            @php
                                                if(isset($review)){
                                                    $route = route('courses.review.update',['id'=>$review->id]);
                                                }else{
                                                    $route = route('courses.review',['course'=>$course->id]);
                                                }
                                            @endphp
                                            <form method="POST"
                                                  action="{{$route}}"
                                                  data-lead="Residential">
                                                @csrf
                                                <input type="hidden" name="rating" id="rating">
                                                <label for="review">@lang('labels.frontend.course.message')</label>
                                                <textarea name="review" class="mb-2" id="review" rows="2"
                                                          cols="20">@if(isset($review)){{$review->content}} @endif</textarea>
                                                <span class="help-block text-danger">{{ $errors->first('review', ':message') }}</span>
                                             
                                                    <button type="submit"
                                                            value="Submit" class="theme-btn">@lang('labels.frontend.course.add_review_now')
                                                    </button>
                                            
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endif
                           
                        </div><!-- end comments-wrapper -->
                    </div><!-- end review-wrap -->
                   
                </div><!-- end course-item-content -->
            </div><!-- end col-lg-8 -->
            <div class="col-lg-4">
                <div class="sidebar-component">
                    <div class="sidebar">
                        <div class="sidebar-widget sidebar-preview">
                           <div class="sidebar-preview-titles">
                               <h3 class="widget__title">Preview this course</h3>
                               <span class="section__divider"></span>
                           </div>
                            <div class="preview-video-and-details">
                                <div class="preview-course-video">
                                     @if($course->course_image != "")
                                <img src="{{asset('storage/uploads/'.$course->course_image)}}"
                                     alt="">
                            @endif
                                </div>
                                <div class="preview-course-content">
                                    
                                    <div class="course-side-bar-widget pb-3">


                        @if (!$purchased_course)
                                <h3>
                                     @if($course->free == 1)
                                        <!-- <span> {{trans('labels.backend.courses.fields.free')}}</span> -->
                                        @else
                                        @lang('labels.frontend.course.price')<span>   {{$appCurrency['symbol'].' '.$course->price}}</span>
                                        @endif</h3>

                                @if(auth()->check() && (auth()->user()->hasRole('student')) && (Cart::session(auth()->user()->id)->get( $course->id)))
                                    <button class="theme-btn w-100 text-center"
                                            type="submit">@lang('labels.frontend.course.added_to_cart')
                                    </button>
                                @elseif(!auth()->check())
                                    @if($course->free == 1)
										

                                        <a id="openLoginModal"
                                           class="theme-btn w-100 text-center"
                                           data-target="#myModal" href="#">@lang('labels.frontend.course.get_now') <i
                                                    class="fa fa-caret-right"></i></a>
                                    @else
                                    <a id="openLoginModal"
                                       class="theme-btn w-100 text-center"
                                       data-target="#myModal" href="#">@lang('labels.frontend.course.buy_now') <i
                                                class="fa fa-caret-right"></i></a>

                                    <a id="openLoginModal"
                                       class="theme-btn w-100 text-center"
                                       data-target="#myModal" href="#">@lang('labels.frontend.course.add_to_cart') <i
                                                class="fa fa-shopping-bag"></i></a>
                                    @endif
                                @elseif(auth()->check() && (auth()->user()->hasRole('student')))

                                    @if($course->free == 1)
                                        <form action="{{ route('cart.getnow') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course->id }}"/>
                                            <input type="hidden" name="amount" value="{{($course->free == 1) ? 0 : $course->price}}"/>
                                           
                                            <button class="theme-btn w-100 text-center"
                                                    href="#">@lang('labels.frontend.course.get_now') <i
                                                        class="fa fa-caret-right"></i></button>
                                        </form>
                                    @else
                                        <form action="{{ route('cart.checkout') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course->id }}"/>
                                            <input type="hidden" name="amount" value="{{($course->free == 1) ? 0 : $course->price}}"/>
                                            <button class="theme-btn w-100 text-center"
                                                    href="#">@lang('labels.frontend.course.buy_now') <i
                                                        class="fa fa-caret-right"></i></button>
                                        </form>
                                        <form action="{{ route('cart.addToCart') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course->id }}"/>
                                            <input type="hidden" name="amount" value="{{($course->free == 1) ? 0 : $course->price}}"/>
                                            <button type="submit"
                                                    class="theme-btn w-100 text-center ">
                                                @lang('labels.frontend.course.add_to_cart') <i
                                                        class="fa fa-shopping-bag"></i></button>
                                        </form>
                                    @endif


                                @else
                                    <h6 class="alert alert-danger"> @lang('labels.frontend.course.buy_note')</h6>
                                @endif
                            @else

                                @if(1)

                              @if($course->course_type_id == 1)
									<?php
									///print_r($course);die;
									$user_id_details = Auth::user()->id;
									/*if(Auth::user()->id == '34')
										$user_id_details = "3";
									else if (Auth::user()->id == '35')
										$user_id_details = "4";*/

									?>
                              <a href="http://companydemo.in/apps/moodle/autologin.php?userid={{$user_id_details}}&course={{$course->id}}"
                                   class="theme-btn w-100 text-center" target="_blank">
               
                                    Moodle Course
                                    <i class="fa fa-arow-right"></i></a>
                              @else

                                <a href="JavaScript:void(0);"
                                   class="theme-btn w-100 text-center">
                                   @lang('labels.frontend.course.course_detail')
                                    <i class="fa fa-arow-right"></i></a>
                                    @endif
                                 @endif

                            @endif

                        </div>
                                    
                                    
                             <!--  <div class="preview-course-incentives">                                       
                                        <p class="preview-course-incentives__title" id="RevCourseContent2">This course includes</p>
                                        <ul class="preview-course-incentives__list">
                                            <li><span class="la la-play-circle-o"></span>2.5 hours on-demand video</li>
                                            <li><span class="fa fa-file-video-o"></span> {{$course->chapterCount()}} Lectures</li>
                                           <!-- <li><span class="la la-file"></span>34 articles</li> 
                                            <!--<li><span class="la la-key"></span>Full lifetime access</li>
                                            <li><span class="la la-television"></span>Access to any Device</li>
                                            <li><span class="la la-certificate"></span>Certificate of Completion</li>
                                             <li><span class="la la-user"></span>{{ $course->students()->count() }}  @lang('labels.frontend.course.enrolled')</li>
											@for($i=1; $i<=(int)$course->rating; $i++)
                                        	<li><span class="la la-star"></span></li>
                                   			 @endfor
                                        </ul>
                                    </div> --><!-- end preview-course-incentives -->
                                </div><!-- end preview-course-content -->
                            </div><!-- end preview-video-and-details -->
                        </div><!-- end sidebar-widget -->
                        <!-- <div class="sidebar-widget sidebar-feature">
                            <h3 class="widget__title">Course Features</h3>
                            <span class="section__divider"></span>
                        
                         <div class="enrolled-student">
                            <div class="comment-ratting float-left ul-li">
                                <ul>
                                    @for($i=1; $i<=(int)$course->rating; $i++)
                                        <li><i class="fa fa-star"></i></li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="student-number bold-font">
                                {{ $course->students()->count() }}  @lang('labels.frontend.course.enrolled')
                            </div>
                        </div>
                        </div> -->
                        
                        
                        <!-- <div class="sidebar-widget sidebar-feature">
                            <h3 class="widget__title">Course Features</h3>
                            <span class="section__divider"></span>
                        
                       
                            <ul class="widget__list">
                                <li> @lang('labels.frontend.course.chapters')
                                    <span class="course-feature__meta"> {{$course->chapterCount()}} </span></li>
                                {{--<li>Language <span>English</span></li>--}}
                                <li> @lang('labels.frontend.course.category') <span class="course-feature__meta"><a
                                                href="{{route('courses.category',['category'=>$course->category->slug])}}"
                                                target="_blank">{{$course->category->name}}</a> </span></li>
                                <!--li> @lang('labels.frontend.course.author') <span>

                                        @foreach($course->teachers as $key=>$teacher)
                                            @php $key++ @endphp
                                            <a href="{{route('teachers.show',['id'=>$teacher->id])}}" target="_blank">
                                                {{$teacher->full_name}}@if($key < count($course->teachers )), @endif
                                            </a>
                                        @endforeach

                                       </span>
                                </li
                            </ul>

                  
                        
                         </div>-->
                        
                        
                        
                        
                        <div class="sidebar-widget sidebar-feature" id="CourseFeatures">
                            <h3 class="widget__title">Course Features</h3>
                            <span class="section__divider"></span>
                            <ul class="widget__list">
								  <li>
                                    <span class="fa fa-clock-o course-feature__icon"></span>Duration
                                    <span class="course-feature__meta">2.5 hours</span>
                                </li>
                                <li>
                                    <span class="fa fa-list-alt course-feature__icon"></span>@lang('labels.frontend.course.category')
                                    <span class="course-feature__meta">
									<a href="{{route('courses.category',['category'=>$course->category->slug])}}" target="_blank">{{$course->category->name}}</a>
									</span>
                                </li>
                                <li>
                                    <span class="fa fa-play-circle-o course-feature__icon"></span>Lessons								
                                    <span class="course-feature__meta">{{$course->chapterCount()}}</span></li>
                                <!--<li>
                                    <span class="la la-puzzle-piece course-feature__icon"></span>Quizzes
                                    <span class="course-feature__meta">26</span>
                                </li>-->
                                <!--<li>
                                    <span class="fa fa-eye course-feature__icon"></span>Preview Lessons
                                    <span class="course-feature__meta">4</span>
                                </li>-->
                                <li>
                                    <span class="fa fa-language course-feature__icon"></span>Language
                                    <span class="course-feature__meta">English</span>
                                </li>
                                <li>
                                    <span class="la la-level-up course-feature__icon"></span>Skill level
                                    <span class="course-feature__meta">{{$diffname->name}}</span>
                                </li>
                                <li>
                                    <span class="la la-users course-feature__icon"></span>Students
                                    <span class="course-feature__meta">{{ $course->students()->count() }}</span>
                                </li>
                                <li>
                                    <span class="la la-certificate course-feature__icon"></span>Certificate
                                    <span class="course-feature__meta">Yes</span>
                                </li>
								 <li>
                                    <span class="la la-television course-feature__icon"></span>Access to any Device
                                    <span class="course-feature__meta">Yes</span>
                                </li>
                            </ul>
                        </div><!-- end sidebar-widget -->
                        
                        
                          
                        
                        
                        
                        
                        
                        
                        <!--<div class="sidebar-widget category-widget">
                            <h3 class="widget__title">Categories</h3>
                            <span class="section__divider"></span>
                            <ul class="widget__list">
                                <li><a href="#">Internet & N/W</a></li>
                                <li><a href="#">DB Systems</a></li>
                                <li><a href="#">Python</a></li>
                                <li><a href="#">Data Analytics</a></li>
                                <li><a href="#">Misc</a></li>
                                <li><a href="#">IT & Software</a></li>
                                <li><a href="#">backend</a></li>
                                <li><a href="#">marketing</a></li>
                            </ul>
                        </div> --><!-- end sidebar-widget -->
                       <!-- <div class="sidebar-widget recent-widget">
                            <h3 class="widget__title">Latest Courses</h3>
                            <span class="section__divider"></span>
                            <div class="recent-item">
                                <div class="recent-img">
                                    <a href="#">
                                        <img src="{{asset('assets/images/img19.jpg')}}" alt="blog image">
                                    </a>
                                </div>
                                <div class="recentpost-body">
                                    <span class="recent__meta"> 12 Jan, 2019 by <a href="#">Jhon Deo</a></span>
                                    <h4 class="recent__link">
                                        <a href="#">Become a PHP Master and Make Money</a>
                                    </h4>
                                  <p class="recent-course__price">$30.00</p>
                                </div>
                            </div>
                            <div class="recent-item">
                                <div class="recent-img">
                                    <a href="#">
                                        <img src="{{asset('assets/images/img20.jpg')}}" alt="blog image">
                                    </a>
                                </div>
                                <div class="recentpost-body">
                                    <span class="recent__meta"> 14 Jan, 2019 by <a href="#">Alex Smith</a></span>
                                    <h4 class="recent__link">
                                        <a href="#">Learning jQuery Mobile for Beginners</a>
                                    </h4>
                                  
                                </div>
                            </div>
                            <div class="recent-item">
                                <div class="recent-img">
                                    <a href="#">
                                        <img src="{{asset('assets/images/img21.jpg')}}" alt="blog image">
                                    </a>
                                </div>
                                <div class="recentpost-body">
                                    <span class="recent__meta"> 15 Jan, 2019 by <a href="#">Mark Doe</a></span>
                                    <h4 class="recent__link">
                                        <a href="#">Introduction LearnPress – LMS plugin</a>
                                    </h4>
                                
                                </div>
                            </div>
                            <div class="recent-item">
                                <div class="button-shared text-center">
                                    <a href="{{url('courses')}}" class="theme-btn">view all courses</a>
                                </div>
                            </div>
                        </div>--><!-- end sidebar-widget -->
                       <!-- <div class="sidebar-widget tag-widget">
                            <h3 class="widget__title">Course Tags</h3>
                            <span class="section__divider"></span>
                            <ul class="widget__list">
                                <li><a href="#">beginner</a></li>
                                <li><a href="#">advanced</a></li>
                                <li><a href="#">tips</a></li>
                                <li><a href="#">photoshop</a></li>
                                <li><a href="#">software</a></li>
                                <li><a href="#">backend</a></li>
                                <li><a href="#">freelance</a></li>
                                <li><a href="#">technology</a></li>
                            </ul>
                        </div>--><!-- end sidebar-widget -->
                        <div class="sidebar-widget social-widget">
                            <h3 class="widget__title">Share with</h3>
                            <span class="section__divider"></span>
                            <ul class="social__links">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div><!-- end sidebar-widget -->
                        
                        @if($global_featured_course != "")
                        <div class="sidebar-widget sidebar-feature">
                            <h3 class="widget__title">@lang('labels.frontend.course.featured_course')</h3>
                            <span class="section__divider"></span>
                       
                              
                                <div class="featured-course">
                                    <div class="best-course-pic-text relative-position pt-0">
                                        <div class="best-course-pic relative-position "
                                             @if($global_featured_course->course_image != "") style="background-image: url({{asset('storage/uploads/'.$global_featured_course->course_image)}})" @endif>
                                                 <div class="overlay">
                                                    <div class="text">
                                                        HEllo
                                                    </div>
                                                  </div>

                                            @if($global_featured_course->trending == 1)
                                                <div class="trend-badge-2 text-center text-uppercase">
                                                    <i class="fa fa-bolt"></i>
                                                    <span>@lang('labels.frontend.badges.trending')</span>
                                                </div>
                                            @endif
                                               
                                        </div>
                                        <div class="best-course-text" style="padding:10px;">
                                            <div class="course-title mb-2 headline relative-position">
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
                        @endif
                        
                        
                    </div><!-- end sidebar -->
                </div><!-- end sidebar-component -->
            </div><!-- end col-lg-4 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end course-detail -->
<!--======================================
        END COURSE DETAIL
======================================-->       

    <!-- End of course details section
        ============================================= -->


@foreach($lessons as $key=> $lesson)
<div class="modal fade" id="myModal12" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<p><?=$lesson->model->full_text?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
@endforeach
@endsection

@push('after-scripts')
    <script src="https://cdn.plyr.io/3.5.3/plyr.polyfilled.js"></script>

    <script>
        const player = new Plyr('#player');

        $(document).on('change', 'input[name="stars"]', function () {
            $('#rating').val($(this).val());
        })
                @if(isset($review))
        var rating = "{{$review->rating}}";
        $('input[value="' + rating + '"]').prop("checked", true);
        $('#rating').val(rating);
        @endif
    </script>

    {{--<script src="//www.youtube.com/iframe_api"></script>--}}
    <script src="{{asset('plugins/sticky-kit/sticky-kit.js')}}"></script>
    <script src="https://cdn.plyr.io/3.5.3/plyr.polyfilled.js"></script>
    <script src="{{asset('plugins/touchpdf-master/pdf.compatibility.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/pdf.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/jquery.touchSwipe.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/jquery.touchPDF.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/jquery.panzoom.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/jquery.mousewheel.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>


    <script>
        var storedDuration = 0;
        var storedLesson;
        storedDuration = Cookies.get("duration_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}");
        storedLesson = Cookies.get("lesson" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}");
        var user_lesson;

        if (parseInt(storedLesson) != parseInt("{{$lesson->id}}")) {
            Cookies.set('lesson', parseInt('{{$lesson->id}}'));
        }


                @if($lesson->mediaVideo && $lesson->mediaVideo->type != 'embed')
        var current_progress = 0;


        @if($lesson->mediaVideo->getProgress(auth()->user()->id) != "")
            current_progress = "{{$lesson->mediaVideo->getProgress(auth()->user()->id)->progress}}";
        @endif

        @if($lesson->mediaPDF)
        $(function () {
            $("#myPDF").pdf({
                source: "{{asset('storage/uploads/'.$lesson->mediaPDF->name)}}",
                loadingHeight: 800,
                loadingWidth: 800,
                loadingHTML: ""
            });

        });
                @endif

        const player2 = new Plyr('#audioPlayer');

        const player = new Plyr('#player');
        duration = 10;
        var progress = 0;
        var video_id = $('#player').parents('.video-container').data('id');
        player.on('ready', event => {
            player.currentTime = parseInt(current_progress);
            duration = event.detail.plyr.duration;


            if (!storedDuration || (parseInt(storedDuration) === 0)) {
                Cookies.set("duration_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}", duration);
            }

        });

        {{--if (!storedDuration || (parseInt(storedDuration) === 0)) {--}}
        {{--Cookies.set("duration_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}", player.duration);--}}
        {{--}--}}


        setInterval(function () {
            player.on('timeupdate', event => {
                if ((parseInt(current_progress) > 0) && (parseInt(current_progress) < parseInt(event.detail.plyr.currentTime))) {
                    progress = current_progress;
                } else {
                    progress = parseInt(event.detail.plyr.currentTime);
                }
            });

            saveProgress(video_id, duration, parseInt(progress));
        }, 10000);


        function saveProgress(id, duration, progress) {
            $.ajax({
                url: "{{route('update.videos.progress')}}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'video': parseInt(id),
                    'duration': parseInt(duration),
                    'progress': parseInt(progress)
                },
                success: function (result) {
                    if (progress === duration) {
                        location.reload();
                    }
                }
            });
        }


        $('#notice').on('hidden.bs.modal', function () {
            location.reload();
        });

        @endif

        $("#sidebar").stick_in_parent();


        @if((int)config('lesson_timer') != 0)
        //Next Button enables/disable according to time

        var readTime, totalQuestions, testTime;
        user_lesson = Cookies.get("user_lesson_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}");

        @if ($test_exists )
            totalQuestions = '{{count($lesson->questions)}}'
        readTime = parseInt(totalQuestions) * 30;
        @else
            readTime = parseInt("{{$lesson->readTime()}}") * 60;
        @endif

                @if(!$lesson->isCompleted())
            storedDuration = Cookies.get("duration_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}");
        storedLesson = Cookies.get("lesson" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}");


        var totalLessonTime = readTime + (parseInt(storedDuration) ? parseInt(storedDuration) : 0);
        var storedCounter = (Cookies.get("storedCounter_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}")) ? Cookies.get("storedCounter_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}") : 0;
        var counter;
        if (user_lesson) {
            if (user_lesson === 'true') {
                counter = 1;
            }
        } else {
            if ((storedCounter != 0) && storedCounter < totalLessonTime) {
                counter = storedCounter;
            } else {
                counter = totalLessonTime;
            }
        }
        var interval = setInterval(function () {
            counter--;
            // Display 'counter' wherever you want to display it.
            if (counter >= 0) {
                // Display a next button box
                $('#nextButton').html("<a class='btn btn-block bg-danger font-weight-bold text-white' href='#'>@lang('labels.frontend.course.next') (in " + counter + " seconds)</a>")
                Cookies.set("duration_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}", counter);

            }
            if (counter === 0) {
                Cookies.set("user_lesson_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}", 'true');
                Cookies.remove('duration');

                @if ($test_exists && (is_null($test_result)))
                $('#nextButton').html("<a class='btn btn-block bg-danger font-weight-bold text-white' href='#'>@lang('labels.frontend.course.complete_test')</a>")
                @else
                @if($next_lesson)
                $('#nextButton').html("<a class='btn btn-block gradient-bg font-weight-bold text-white'" +
                    " href='{{ route('lessons.show', [$next_lesson->course_id, $next_lesson->model->slug]) }}'>@lang('labels.frontend.course.next')<i class='fa fa-angle-double-right'></i> </a>");
                @else
                $('#nextButton').html("<form method='post' action='{{route("admin.certificates.generate")}}'>" +
                    "<input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}' />" +
                    "<input type='hidden' value='{{$lesson->course->id}}' name='course_id'> " +
                    "<button class='btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold' id='finish'>@lang('labels.frontend.course.finish_course')</button></form>");

                @endif

                @if(!$lesson->isCompleted())
                courseCompleted("{{$lesson->id}}", "{{get_class($lesson)}}");
                @endif
                @endif
                clearInterval(counter);
            }
        }, 1000);

        @endif
        @endif

        function courseCompleted(id, type) {
            $.ajax({
                url: "{{route('update.course.progress')}}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'model_id': parseInt(id),
                    'model_type': type,
                },
            });
        }
// 
        function PopupCenter(pageURL, title,w,h) {
			var left = (screen.width/2)-(w/2);
			var top = (screen.height/2)-(h/2);
			var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
		}
		 function popup(url)
		 {
			params = 'width='+screen.width;
			params += ', height='+screen.height;
			params += ', top=0, left=0'
			params += ', fullscreen=yes';
			newwin=window.open(url,'windowname4', params);
			if (window.focus) {newwin.focus()}
			return false;
		 }
		 function PopUpWindows(url,id)
		 {
			window.open(url, id, 'fullscreen=yes, scrollbars=yes' );
			return false;
		 }
					// 
    </script>

@endpush