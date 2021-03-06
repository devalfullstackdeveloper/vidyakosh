@extends('backend.layouts.app')

@section('title', __('strings.backend.dashboard.title').' | '.app_name())

@push('after-styles')
<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
    <style>
        .trend-badge-2 {
            top: -10px;
            left: -52px;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            position: absolute;
            padding: 40px 40px 12px;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            background-color: #ff5a00;
        }

        .progress {
            background-color: #b6b9bb;
            height: 2em;
            font-weight: bold;
            font-size: 0.8rem;
            text-align: center;
        }

        .best-course-pic {
            background-color: #333333;
            background-position: center;
            background-size: cover;
            height: 150px;
            width: 100%;
            background-repeat: no-repeat;
        }


    </style>
@endpush

@section('content')

    <div class="row">
        <div class="col">
        <form method="GET">
        <div class="filterPanelSt">
            <div class="row">
                <!--01-->
                  <div class="col-xs-12 col-md-1 filtBg">Filter by</div>
                  <!--./01-->
                  <!--/01-->
                
                    <div class="col vMiddle">
                        <div class="form-group">
                            <select class="form-control" name="course_year">
                                <option value="0">Select Course Status Tracker</option>
                                <option value="2019">Current Year Courses </option>
                                <option value="2018">Previous Year Courses </option>
                            </select>   
                        </div>
                    </div>
                    <!--/01-->
          
                    <!--/01-->
                    <div class="col vMiddle">
                        <div class="form-group">
                            <select class="form-control" name="course_type">
                                <option value="">Select Courses</option>
                                <option value="1">Off the Shell (OTS) Courses  </option>
                                <option value="2">In House Courses  </option>
                            </select>   
                        </div>
                    </div>
                    <!--/01-->
                     <!--/01-->
        <div class="col vMiddle ">
            <div class="form-group">
                <div class="input-group toText">
                    <div class="input-group date">
                        <input class="form-control" id="start_date" type="text" readonly="">
                        <span class="input-group-addon"><i class="fa fa-calendar dicion" style="padding: 10px;"></i></span> </div>
                </div>
            </div>
        </div>
        <!--/01--> 
                    <!--/01-->
                    <div class="col vMiddle">
                        <div class="form-group">  
                            <div class="input-group">
                                 <div class="input-group date">
                        <input class="form-control" type="text" readonly="" id="end_date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar dicion" style="padding: 10px;"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/01-->
                    <!--/01-->
                    <div class="col vMiddle text-left">
                        <button type="submit" class="btn  btn-success">Go</button> &nbsp; &nbsp;
                        <a href="#" class="btn btn-info">Reset</a>
                    </div>
                    <!--/01-->
                
            </div>
        </div>
        </form>
  <!--  <div class="totalViewSection">
        <div class="row">
            <!--box 1-
            <div class="col">
                <div class="cardPanel">
                    <i class="fa fa-file-text float-left"></i>{{ count($completed_course) }}
                    <span>Total Completed Courses </span> 
                </div>
            </div>  
             <!--./box 1-
             <!--box 1-
    <div class="col">
    <div class="cardPanel">
        <i class="fa fa-university float-left"></i>@if(count($purchased_courses) > count($completed_course)) {{  count($purchased_courses) - count($completed_course)}} @else {{count($purchased_courses)}} @endif
        
        <span>Courses in Progress</span> 
    </div>  
    </div>  
     <!--./box 1
     <!--box 1
    <div class="col">
    <div class="cardPanel">
        <i class="fa fa-users float-left"></i> @if(count($purchased_courses) > count($completed_course)){{ count($purchased_courses) - count($completed_course) }}@else {{count($purchased_courses)}} @endif
        
        <span>Courses yet to be Started</span> 
    </div>  
    </div>  
     <!--./box 1
     <!--box 1
    <div class="col">
    <div class="cardPanel">
        <i class="fa fa-industry float-left"></i>
         {{count($in_house_purchased_courses)}}  
        <span>In House Courses Accepted</span> 
    </div>  
    </div>  
     <!--./box 1
     <!--box 1
    <div class="col">
    <div class="cardPanel">
        <i class="fa fa-user-plus float-left"></i>{{count($in_house_completed_course)}} 
      
        <span>In House Courses Completed</span> 
    </div>  
    </div>  
     <!--./box 1
    </div>
		
		
		 
</div> -->
        
        
              
            <div class="card mt-4">               
                <div class="card-tittle"> @lang('labels.backend.dashboard.my_courses') </div>
				
                     <!-- <div class="dropdown pull-right coursesStatusBox">
								<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
								  Courses Status <span>({{count($purchased_courses)}})</span>
								</button>
								<div class="dropdown-menu">
								  <a class="dropdown-item" href="{{route('admin.mycourse.index')}}">Assigned ({{count($purchased_courses)}})</a>
								  <a class="dropdown-item" href="{{route('admin.mycourse.completedcourses')}}">Completed ({{count($completed_course)}})</a>
								  <a class="dropdown-item" href="{{route('admin.mycourse.ongoingcourses')}}">In Progress (@if(count($purchased_courses) > count($completed_course)){{ count($purchased_courses) - count($completed_course) }}@else {{count($purchased_courses)}} @endif)</a>
								  <a class="dropdown-item" href="{{route('admin.mycourse.ongoingcourses')}}">Yet to be Started (@if(count($purchased_courses) > count($completed_course)){{ count($purchased_courses) - count($completed_course) }}@else {{count($purchased_courses)}} @endif)</a>
								</div>
							</div>  -->
				
                  <!--filter Box-->
          <div class="filterPanel f-box-2">
           <div class="row totalViewSection" style="margin-bottom:0">
            <!--box 1-->   
    <div class="col">
		<a href="{{route('admin.mycourse.index')}}">
    <div class="cardPanel">
        <i class="fa fa-users float-left"></i>
		{{count($purchased_courses)}}       
        <span>Assigned</span> 
    </div>  
		</a>
    </div>  
     <!--./box 1-->    
        
     <!--box 1-->   
    <div class="col">
			<a href="{{route('admin.mycourse.completedcourses')}}">
    <div class="cardPanel">
        <i class="fa fa-check float-left"></i>
		{{count($completed_course)}}        
        <span>Completed</span> 
    </div>  
		</a>
    </div>  
     <!--./box 1-->
     <!--box 1-->   
    <!--<div class="col">
		<a href="{{route('admin.mycourse.ongoingcourses')}}">
    <div class="cardPanel">
        <i class="fa fa-spinner float-left"></i>
      @if(count($purchased_courses) > count($completed_course)){{ count($purchased_courses) - count($completed_course) }}@else {{count($purchased_courses)}} @endif
        <span>In Progress</span> 
    </div>  
		</a>
    </div>-->  
			    <div class="col" id = "inprg">
    <div class="cardPanel">
        <i class="fa fa-spinner float-left"></i>
      @if(count($purchased_courses) > count($completed_course)){{ count($purchased_courses) - count($completed_course) }}@else {{count($purchased_courses)}} @endif
        <span>In Progress</span> 
    </div>  
	
    </div>
     <!--./box 1-->
     <!--box 1-->   
    <div class="col">
		<a href="{{route('admin.mycourse.ongoingcourses')}}">
    <div class="cardPanel">
        <i class="fa fa-user-plus float-left"></i> 
		@if(count($purchased_courses) > count($completed_course)){{ count($purchased_courses) - count($completed_course) }}@else {{count($purchased_courses)}} @endif   
        <span>Yet to be Started</span> 
    </div>  
		</a>
    </div>  
     <!--./box 1-->	
    </div>
          </div>
          <!--filter Box-->
                   
               <!--card-header-->
                <div class="card-body">
                    <div class="row">
                        @if(auth()->user()->hasRole('student'))


                            @if(count($pending_orders) > 0)
                                <div class="col-12">
                                    <h4>@lang('labels.backend.dashboard.pending_orders')</h4>
                                </div>
                                <div class="col-12 text-center">
									
                                    <table class="table table table-bordered table-striped">
                                        <thead>
                                        <tr>

                                            <th>@lang('labels.general.sr_no')</th>
                                            <th>@lang('labels.backend.orders.fields.reference_no')</th>
                                            <th>@lang('labels.backend.orders.fields.items')</th>
                                            <th>@lang('labels.backend.orders.fields.amount')
                                                <small>(in {{$appCurrency['symbol']}})</small>
                                            </th>
                                            <th>@lang('labels.backend.orders.fields.payment_status.title')</th>
                                            <th>@lang('labels.backend.orders.fields.date')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pending_orders as $key=>$item)
                                            @php $key++ @endphp
                                            <tr>
                                                <td>
                                                    {{$key}}
                                                </td>
                                                <td>
                                                    {{$item->reference_no}}
                                                </td>
                                                <td>
                                                    @foreach($item->items as $key=>$subitem)
                                                        @php $key++ @endphp
                                                        @if($subitem->item != null)
                                                            {{$key.'. '.$subitem->item->title}} <br>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{$item->amount}}
                                                </td>
                                                <td>
                                                    @if($item->status == 0)
                                                        @lang('labels.backend.dashboard.pending')
                                                    @elseif($item->status == 1)
                                                        @lang('labels.backend.dashboard.success')
                                                    @elseif($item->status == 2)
                                                        @lang('labels.backend.dashboard.failed')
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$item->created_at->format('d-m-Y h:i:s')}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            @endif

                            

							
                            @if(count($purchased_courses) > 0)
                                @foreach($purchased_courses as $item)
                                @php
                                $item->progress=$item->progress();
                                $moodle_course_ref_id=$item['moodle_course_ref_id'];
                                if($moodle_course_ref_id>0 && $item->progress < 100){
                                    $is_btn=1;
                                    $laravel_course_id=$item['id'];
                                    $course_id=$moodle_course_ref_id;
                                    $user_id=$logged_in_user['id'];
                                    //echo '<pre>'; print_r('user_id'. $user_id); print_r('course_id'.  $course_id);print_r('lcourse_id'.  $laravel_course_id );echo '</pre>';
                                    
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, "http://companydemo.in/apps/moodle/new-course-completion-status.php?userid=".$user_id."&course=".$course_id);
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                                    $output = curl_exec($ch);
                                    curl_close($ch);
                                    $res = json_decode($output);
                                    //print_r($res);
                                    if(!empty($res))
                                    {
                                        $user_grade=$res->user_grade;
                                        //$user_grade=0;
                                        $item->progress=$user_grade;
                                    }else
                                    {
                                        $user_grade=0;
                                        $user_grade=$res->user_grade_cal;
                                        $item->progress=$user_grade;
                                    }
                                    
                                }
                                else
                                {
                                    $is_btn=0;
                                }
                                @endphp
                                    <div class="col-md-3">
                                        <div class="best-course-pic-text position-relative border">
                                            <div class="best-course-pic position-relative overflow-hidden"
                                                 @if($item->course_image != "") style="background-image: url({{asset('storage/uploads/'.$item->course_image)}})" @endif>

                                                @if($item->trending == 1)
                                                    <div class="trend-badge-2 text-center text-uppercase">
                                                        <i class="fas fa-bolt"></i>
                                                        <span>@lang('labels.backend.dashboard.trending') </span>
                                                    </div>
                                                @endif

                                                <!-- <div class="course-rate ul-li">
                                                    <ul>
                                                        @for($i=1; $i<=(int)$item->rating; $i++)
                                                            <li><i class="fas fa-star"></i></li>
                                                        @endfor
                                                    </ul>
                                                </div> -->
                                            </div>
                                            <div class="best-course-text d-inline-block w-100 p-2">
                                                <div class="course-title mb20 headline relative-position">
                                                     @if($completionArr[$item->id]['active'] == 0)
                                                     <h5>
                                                        <a href="javascript:void(0);">{{$item->title}}</a>
                                                    </h5>
                                                    @endif
                                                     @if($completionArr[$item->id]['active'] > 0)
                                                    <h5>
                                                        <a href="{{ route('courses.show', [$item->slug]) }}">{{$item->title}}</a>
                                                    </h5>
                                                    @endif
                                                </div>
                                                 
                                                <div class="course-meta d-inline-block w-100 ">
                                                    <div class="d-inline-block w-100 0 mt-2">
														
														 <div class="row">
														 <div class="col-md-12">
                                                     <span class="course-category">
                                                        <!-- <div class="course-rate ul-li"> -->
                                                    <h6>Average Rating</h6>        
                                                    @if(isset($item->rating))
                                                    <ul class="ratingStar" style="float: right;position: relative;margin-bottom: -20px;top: -25px;">
                                                        @for($i=1; $i<=(int)$item->rating; $i++)
                                                            <li><i class="fa fa-star"></i></li>
                                                        @endfor
                                                    </ul>
                                                    @endif
                                               <!--  </div> -->
                                                <!-- <a href="{{route('courses.category',['category'=>$item->category->slug])}}"
                                                   class="bg-success text-decoration-none px-2 p-1">{{$item->category->name}}</a> -->
                                            </span>
														 </div>
															 </div>
															  <div class="row">
                                            <div class="col-md-12">
                                                        <span class="course-author float-right">
                                                 {{ $item->students()->count() }}
                                                            @lang('labels.backend.dashboard.students')
                                            </span>
                                            <span class="course-category">
                                            @if($completionArr[$item->id]['completion_days'] > 0)
                                            	Will expire on {{$completionArr[$item->id]['completion_date']}}
                                            @endif
                                            @if($completionArr[$item->id]['active'] == 0)
                                            	INACTIVE
                                            @endif
                                            </span>
														 </div>
															 </div>
                                                    </div>

                                                    <div class="progress my-2">

                                                        <div class="progress-bar"
                                                             style="width:{{$item->progress }}%">{{ $item->progress  }}
                                                            %
                                                            @lang('labels.backend.dashboard.completed')
                                                        </div>
                                                    </div>
                                                    @if($item->progress() == 100)
                                                        @if(!$item->isUserCertified())
                                                            <form method="post"
                                                                  action="{{route('admin.certificates.generate')}}">
                                                                @csrf
                                                                <input type="hidden" value="{{$item->id}}"
                                                                       name="course_id">
                                                                <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                                                        id="finish">@lang('labels.frontend.course.finish_course')</button>
                                                            </form>
                                                        @else
                                                            <div class="alert alert-success px-1 text-center mb-0">
                                                                @lang('labels.frontend.course.certified')
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @if($is_btn)
                                                    <form method="post"
                                                          action="{{route('admin.mycourse.completeMoodle')}}">
                                                        @csrf
                                                        <input type="hidden" value="{{$laravel_course_id}}"
                                                               name="course_id">
                                                        <input type="hidden" value="{{$user_id}}"
                                                               name="user_id">
                                                        <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                                                id="finish">Complete Course</button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                @endforeach
                            @else
                                <div class="col-12 text-center">
                                    <h4 class="text-center">@lang('labels.backend.dashboard.no_data')</h4>
                                    <a class="btn btn-primary"
                                       href="{{route('courses.all')}}">@lang('labels.backend.dashboard.buy_course_now')
                                        <i class="fa fa-arrow-right"></i></a>
                                </div>
                            @endif
                            @if(count($purchased_bundles) > 0)

                                <div class="col-12 mt-5">
                                    <h4>@lang('labels.backend.dashboard.my_course_bundles')</h4>
                                </div>
                                @foreach($purchased_bundles as $key=>$bundle)
                                    @php $key++ @endphp
                                    <div class="col-12"><h5><a
                                                    href="{{route('bundles.show',['slug'=>$bundle->slug ])}}">
                                                {{$key.'. '.$bundle->title}}</a></h5>
                                    </div>
                                    @if(count($bundle->courses) > 0)
                                        @foreach($bundle->courses as $item)
                                            <div class="col-md-3 mb-5">
                                                <div class="best-course-pic-text position-relative border">
                                                    <div class="best-course-pic position-relative overflow-hidden"
                                                         @if($item->course_image != "") style="background-image: url({{asset('storage/uploads/'.$item->course_image)}})" @endif>

                                                        @if($item->trending == 1)
                                                            <div class="trend-badge-2 text-center text-uppercase">
                                                                <i class="fas fa-bolt"></i>
                                                                <span>@lang('labels.backend.dashboard.trending') </span>
                                                            </div>
                                                        @endif

                                                        <div class="course-rate ul-li">
                                                            <ul>
                                                                @for($i=1; $i<=(int)$item->rating; $i++)
                                                                    <li><i class="fas fa-star"></i></li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="best-course-text d-inline-block w-100 p-2">
                                                        <div class="course-title mb20 headline relative-position">
                                                            <h5>
                                                                <a href="{{ route('courses.show', [$item->slug]) }}">{{$item->title}}</a>
                                                            </h5>
                                                        </div>
                                                        <div class="course-meta d-inline-block w-100 ">
                                                            <div class="d-inline-block w-100 0 mt-2">
                                                     <span class="course-category float-left">
                                                <a href="{{route('courses.category',['category'=>$item->category->slug])}}"
                                                   class="bg-success text-decoration-none px-2 p-1">{{$item->category->name}}</a>
                                            </span>
                                                                <span class="course-author float-right">
                                                 {{ $item->students()->count() }}
                                                                    @lang('labels.backend.dashboard.students')
                                            </span>
                                                            </div>

                                                            <div class="progress my-2">
                                                                <div class="progress-bar"
                                                                     style="width:{{$item->progress() }}%">{{ $item->progress()  }}
                                                                    %
                                                                    @lang('labels.backend.dashboard.completed')
                                                                </div>
                                                            </div>
                                                            @if($item->progress() == 100)
                                                                @if(!$item->isUserCertified())
                                                                    <form method="post"
                                                                          action="{{route('admin.certificates.generate')}}">
                                                                        @csrf
                                                                        <input type="hidden" value="{{$item->id}}"
                                                                               name="course_id">
                                                                        <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                                                                id="finish">@lang('labels.frontend.course.finish_course')</button>
                                                                    </form>
                                                                @else
                                                                    <div class="alert alert-success px-1 text-center mb-0">
                                                                        @lang('labels.frontend.course.certified')
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                    </div>
                    @endif
                    @elseif(auth()->user()->hasRole('teacher'))
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-3 col-12 border-right">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card text-white bg-primary text-center">
                                                <div class="card-body">
                                                    <h2 class="">{{count(auth()->user()->courses) + count(auth()->user()->bundles)}}</h2>
                                                    <h5>@lang('labels.backend.dashboard.your_courses_and_bundles')</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card text-white bg-success text-center">
                                                <div class="card-body">
                                                    <h2 class="">{{$students_count}}</h2>
                                                    <h5>@lang('labels.backend.dashboard.students_enrolled')</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-12 border-right">
                                    <div class="d-inline-block form-group w-100">
                                        <h4 class="mb-0">@lang('labels.backend.dashboard.recent_reviews') <a
                                                    class="btn btn-primary float-right"
                                                    href="{{route('admin.reviews.index')}}">@lang('labels.backend.dashboard.view_all')</a>
                                        </h4>

                                    </div>
                                    <table class="table table-responsive-sm table-striped">
                                        <thead>
                                        <tr>
                                            <td>@lang('labels.backend.dashboard.course')</td>
                                            <td>@lang('labels.backend.dashboard.review')</td>
                                            <td>@lang('labels.backend.dashboard.time')</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($recent_reviews) > 0)
                                            @foreach($recent_reviews as $item)
                                                <tr>
                                                    <td>
                                                        <a target="_blank"
                                                           href="{{route('courses.show',[$item->reviewable->slug])}}">{{$item->reviewable->title}}</a>
                                                    </td>
                                                    <td>{{$item->content}}</td>
                                                    <td>{{$item->created_at->diffforhumans()}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">@lang('labels.backend.dashboard.no_data')</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="d-inline-block form-group w-100">
                                        <h4 class="mb-0">@lang('labels.backend.dashboard.recent_messages') <a
                                                    class="btn btn-primary float-right"
                                                    href="{{route('admin.messages')}}">@lang('labels.backend.dashboard.view_all')</a>
                                        </h4>
                                    </div>


                                    <table class="table table-responsive-sm table-striped">
                                        <thead>
                                        <tr>
                                            <td>@lang('labels.backend.dashboard.message_by')</td>
                                            <td>@lang('labels.backend.dashboard.message')</td>
                                            <td>@lang('labels.backend.dashboard.time')</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($threads) > 0)
                                            @foreach($threads as $item)
                                                <tr>
                                                    <td>
                                                        <a target="_blank"
                                                           href="{{asset('/user/messages/?thread='.$item->id)}}">{{$item->title}}</a>
                                                    </td>
                                                    <td>{{$item->lastMessage->body}}</td>
                                                    <td>{{$item->lastMessage->created_at->diffForHumans() }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">@lang('labels.backend.dashboard.no_data')</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    @elseif(auth()->user()->hasRole('administrator'))
                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-dark text-center py-3">
                                <div class="card-body">
                                    <h1 class="">{{$courses_count}}</h1>
                                    <h3>@lang('labels.backend.dashboard.course_and_bundles')</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-light text-dark text-center py-3">
                                <div class="card-body">
                                    <h1 class="">{{$students_count}}</h1>
                                    <h3>@lang('labels.backend.dashboard.students')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-primary text-center py-3">
                                <div class="card-body">
                                    <h1 class="">{{$teachers_count}}</h1>
                                    <h3>@lang('labels.backend.dashboard.teachers')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 border-right">
                            <div class="d-inline-block form-group w-100">
                                <h4 class="mb-0">@lang('labels.backend.dashboard.recent_orders') <a
                                            class="btn btn-primary float-right"
                                            href="{{route('admin.orders.index')}}">@lang('labels.backend.dashboard.view_all')</a>
                                </h4>

                            </div>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <td>@lang('labels.backend.dashboard.ordered_by')</td>
                                    <td>@lang('labels.backend.dashboard.amount')</td>
                                    <td>@lang('labels.backend.dashboard.time')</td>
                                    <td>@lang('labels.backend.dashboard.view')</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($recent_orders) > 0)
                                    @foreach($recent_orders as $item)
                                        <tr>
                                            <td>
                                                {{$item->user->full_name}}
                                            </td>
                                            <td>{{$item->amount.' '.$appCurrency['symbol']}}</td>
                                            <td>{{$item->created_at->diffforhumans()}}</td>
                                            <td><a class="btn btn-sm btn-primary"
                                                   href="{{route('admin.orders.show', $item->id)}}" target="_blank"><i
                                                            class="fa fa-arrow-right"></i></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">@lang('labels.backend.dashboard.no_data')</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="d-inline-block form-group w-100">
                                <h4 class="mb-0">@lang('labels.backend.dashboard.recent_contact_requests') <a
                                            class="btn btn-primary float-right"
                                            href="{{route('admin.contact-requests.index')}}">@lang('labels.backend.dashboard.view_all')</a>
                                </h4>

                            </div>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <td>@lang('labels.backend.dashboard.name')</td>
                                    <td>@lang('labels.backend.dashboard.email')</td>
                                    <td>@lang('labels.backend.dashboard.message')</td>
                                    <td>@lang('labels.backend.dashboard.time')</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($recent_contacts) > 0)
                                    @foreach($recent_contacts as $item)
                                        <tr>
                                            <td>
                                                {{$item->name}}
                                            </td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->message}}</td>
                                            <td>{{$item->created_at->diffforhumans()}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">@lang('labels.backend.dashboard.no_data')</td>

                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                    @else
                        <div class="col-12">
                            <h1>@lang('labels.backend.dashboard.title')</h1>
                        </div>
                    @endif
                </div>
            </div><!--card-body-->
        </div><!--card-->
    </div><!--col-->
    <script>

    $(document).ready(function () {
        $('#start_date').datepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}"
        });

        $(".js-example-placeholder-single").select2({
            placeholder: "{{trans('labels.backend.courses.select_category')}}",
        });

        $(".js-example-placeholder-multiple").select2({
            placeholder: "{{trans('labels.backend.courses.select_teachers')}}",
        });
    });
		
    $(document).ready(function () {
        $('#end_date').datepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}"
        });

        $(".js-example-placeholder-single").select2({
            placeholder: "{{trans('labels.backend.courses.select_category')}}",
        });

        $(".js-example-placeholder-multiple").select2({
            placeholder: "{{trans('labels.backend.courses.select_teachers')}}",
        });
		
		
		//------------------------in progress-----------------------------------//
		$('#inprg').click(function(){
		//alert('hello');
			 $.ajax({
               type:'get',
               url:'inprogress',
               success:function(data) {
                  $("#msg").html(data.msg);
               }
            });
		});
    });
</script>
@endsection
