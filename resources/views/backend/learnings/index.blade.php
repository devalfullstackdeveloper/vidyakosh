@extends('backend.layouts.app')
@push('after-styles')
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/jquery-ui.css')}}">
                 
@endpush

@push('after-styles')
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
<!-- new banner starts-->
<body>
<div class="tracks">
  <ul>
    @if(isset($elementsdata))
       @foreach($elementsdata as $trackdata)
    <li><a href="#track{{$trackdata['track']['id']}}">{{$trackdata['track']['name']}}</a></li>
      @endforeach
    @endif
  </ul>

  @if(isset($elementsdata))
         @foreach($elementsdata as $trackdata)
  <div class="tabContainer">
    <div id="track{{$trackdata['track']['id']}}"  class="tabtrackContent">
      <div class="category">
        <ul>
          @if(isset($trackdata['track']['categories']))
             @foreach($trackdata['track']['categories'] as $categorydata)
          <li><a href="#category{{$categorydata['category']['id']}}">{{$categorydata['category']['category_name']}}</a></li>
            @endforeach
          @endif
        </ul>
        @if(isset($trackdata['track']['categories']))
             @foreach($trackdata['track']['categories'] as $categorydata)
        <div class="tabContainer">
              <div id="category{{$categorydata['category']['id']}}"  class="tabContent">
                <div class="subcategory">
                  <ul>
                    <?php $i = 0;?>
                      @foreach($categorydata['category']['subcategory'] as $sub_catdata)  
                    <li><a href="#subcategory{{$sub_catdata['id']}}">{{$sub_catdata['subcategory_name']}}</a></li>
                      @endforeach
                  </ul>
                       
                  @foreach($categorydata['category']['subcategory'] as $sub_catdata)  
                    <div id="subcategory{{$sub_catdata['id']}}"  class="subtabContent">
                    
                      <div class="row">
                       
                      <?php $i++;?>
                      @foreach($sub_catdata['courses'] as $coursedata)
                        <div class="col-md-3">
                          <div class="best-course-pic-text position-relative border">
                              <div class="best-course-pic position-relative overflow-hidden"
                                   @if($coursedata->course_image != "") style="background-image: url({{asset('storage/uploads/'.$coursedata->course_image)}})" @endif>

                                                @if(isset($level))
												@foreach($level as $leveldata)
												@if(($coursedata->difficulty_id)==($leveldata->id))
												<div class="course-tooltip1">
													<span class="tooltip-label1 float-right">{{$leveldata->name}}</span>
												</div>
												@endif
												@endforeach
												@endif

                                  <div class="course-rate ul-li">
                                      <ul>
                                          @for($i=1; $i<=(int)$coursedata->rating; $i++)
                                              <li><i class="fas fa-star"></i></li>
                                          @endfor
                                      </ul>
                                  </div>
                              </div>
                              <div class="best-course-text d-inline-block w-100 p-2">
                                  <div class="course-title headline relative-position">
                                      <h5>
                                          <a class="customtooltip" title="{{$coursedata->title}}" href="{{ route('courses.show', [$coursedata->slug]) }}"> @if(strlen(strip_tags($coursedata->title))>25){{substr(strip_tags(ucwords($coursedata->title)), 0, 22)}}...@else{{strip_tags(ucwords($coursedata->title))}}@endif</a>
                                      </h5>
                                  </div>
                                  <div class="course-meta d-inline-block w-100 ">
                                      <div class="d-inline-block w-100 0 mt-2">
										  
										  
										  
                                       <span class="course-category float-left">
                                        @if(isset($rating))
                                        @foreach($rating as $item)
                                        @if(($item->reviewable_id)==($coursedata->id))
                                        <div class="course-rate">
                                          <h6>Average Rating</h6>
                                            <ul>
                                                @for($i=1; $i<=(int)$item->rating; $i++)
                                                    <li><i class="fa fa-star"></i></li>
                                                @endfor
                                            </ul>
                                          </div>
                                          @endif
                                          @endforeach
                                          @endif


                             <!--      <a href="{{ route('courses.show', [$coursedata->slug]) }}"
                                     class="bg-success text-decoration-none px-2 p-1">{{$sub_catdata['categoryname']}}</a> -->
                              </span>
                                <span class="course-author float-right">
                                   {{$coursedata->students()->count()}}
                                  @lang('labels.backend.dashboard.students')
                              </span>
                                      </div>

                                      <div class="progress my-2">
                                          <div class="progress-bar"
                                               style="width:{{$coursedata->progress() }}%">{{ $coursedata->progress()  }}
                                              %
                                              @lang('labels.backend.dashboard.completed')
                                          </div>
                                      </div>
                                      @if($coursedata->progress() == 100)
                                          @if(!$coursedata->isUserCertified())
                                              <form method="post"
                                                    action="{{route('admin.certificates.generate')}}">
                                                  @csrf
                                                  <input type="hidden" value="{{$coursedata->id}}"
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
                      </div>


                    </div>
                  @endforeach
                </div>
              </div>
        </div>
            @endforeach
          @endif
      </div>
    </div>
  </div>
    @endforeach
  @endif
</div>  
 
 
</body>
<!-- new banner ends -->
  
     <script src="{{asset('assets/js/jquery-ui.js')}}"></script>
     <script src="{{asset('assets/js/jquery-1.12.4.js')}}"></script>
     
    
    <script>
  $( function() {
    $( ".tracks" ).tabs({
      collapsible: true
    });
    $( ".category" ).tabs({
      collapsible: true
    });
    $( ".subcategory" ).tabs({
      collapsible: true
    });
    openParentTab();
  } );

  function openParentTab() {
  locationHash = location.hash.substring( 1 );
  console.log(locationHash);
  // Check if we have an location Hash
  if (locationHash) {
    // Check if the location hash exsist.
    var hash = jQuery('#'+locationHash);
    if (hash.length) {
      // Check of the location Hash is inside a tab.
      if (hash.closest(".tabContent").length) {
        // Grab the index number of the parent tab so we can activate it
        var tabNumber = hash.closest(".tabContent").index();
        jQuery(".tabs.fix").tabs({ active: tabNumber });
        // Not need but this puts the focus on the selected hash
        hash.get(0).scrollIntoView();
        setTimeout(function() {
          hash.get(0).scrollIntoView();
        }, 1000);
      }
    }
  }
}
  </script>
@endsection




