@extends('frontend.layouts.app'.config('theme_layout'))

@section('title', 'Course List| '.app_name())
@section('meta_description', '')
@section('meta_keywords','')

@push('after-styles')
 
@endpush

@section('content')
<div class="innerlist">
            <div class=container> 
                 <div class="row">
                     <div class="col-md-12 col-lg-12 col-sm-6 page-banner text-center">
                      <h1>Course List</h1>
                        <ul>
                          <li><a href="{{url('/')}}">Home</a></li>
                          @foreach($category as $categories)
                          <li><a href="">{{$categories->name}}</a></li>
                          @endforeach
                        </ul>
                     </div>
                 </div>
            </div> 
      </div>
        <!--left section-->
        <div class="container">
          <div class="row">
            <div class="col-sm-12 col-lg-2 col-md-2  leftSection">
             @foreach($category as $categories)
            <h5>{{$categories->name}}</h5>
            @endforeach
            <div class="categories">
              <ul class="list list-border angle-double-right">
                @foreach($subcategory as $subcategories)
                <li class="">
                   <a href="{{route('courselist',['id'=>$subcategories['id']])}}" title="About Hurl">{{$subcategories->name}}</a>
               </li>
               @endforeach
              </ul>
            </div>
            </div>
            <!--right section-->
            <div class="col-sm-12 col-lg-10 col-md-10 RightSection">
              <!--01-->
              <div class="row">
                  <!--01-->
                  <div class="col-md-3">
                      <div class="item pd-0">
                        <div class="box_grid enroll-form">
                          <figure> <!-- <a href="#0" class="wish_bt"></a> --> <a href="">
                            @foreach($course as $coursedata)
                            <img src="{{asset('storage/uploads/'.$coursedata->course_image)}}" class="img-fluid" alt=""></a> 
                          @endforeach</figure>
                            @foreach($category as $categories)
                          <div class="wrapper wrapper-content"> <small>{{$categories->name}}</small>
                            @endforeach
                            <h3>Beginner</h3>
                              @foreach($course as $coursedata)
                            <p>{{$coursedata->title}}</p>
                            @endforeach
                          </div>
                          <ul>
                            <li><a href="#">Enroll Now</a></li>
                          </ul>
                        </div>
                      </div>
                  </div> 
                    @foreach($course as $coursedata)
                  <div class="col-md-9 col-lg-9 col-sm-6"> 
                      <div class="box-design mgt-0">
                          <div class="contact-detail">
                             <h3>Objective</h3>
                             <h4 class="detail-heading">Course Title:</h4>
                             <p class="big-text font-title"> 
                                {{$coursedata->title}}
                              </p>
                              <h4 class="detail-heading">Brief Description:</h4>
                             <p class="big-text font-title"> 
                               {{$coursedata->slug}}
                              </p>
                          </div>
                      </div>
                  </div>
                  @endforeach

              </div>  
              <!--02-->
              <div class="row">
                  <div class="col-md-12 col-lg-12 col-sm-6"> 
                      <div class="box-design mgt-0">
                          <div class="contact-detail">
                             <h3>OWASP Overview</h3>
                             @foreach($course as $coursedata)
                             <h4 class="detail-heading">Description:</h4>
                             <p class="big-text font-title"> 
                           {{$coursedata->description}}
                              </p>
                            @endforeach
                          </div>
                      </div>
                  </div>
                  

              </div>  
            </div>
          </div>
        </div>   
        @endsection 