@extends('frontend.layouts.app'.config('theme_layout'))

@section('title', 'Course List| '.app_name())
@section('meta_description', '')
@section('meta_keywords','')

@push('after-styles')
 
@endpush

@section('content')

<?//php foreach ($items as $data) {
  //foreach ($data['course'] as $course) {
  //echo $course['title'];
 // }
  
//} die;?>

<div class="innerlist">
            <div class=container> 
                 <div class="row">
                     <div class="col-md-12 col-lg-12 col-sm-6 page-banner text-center">
                       <h1>Course List</h1>
                       <ul>
                          <li><a href="{{url('/')}}">Home</a></li>
                        @foreach($category as $categorydata)
                                <li><a href="">{{$categorydata->name}}</a></li>
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
         @foreach($category as $categorydata)
                                <h5>{{$categorydata->name}}</h5>
                       @endforeach
            <h5></h5>
               
            <div class="categories">
              <ul class="list list-border angle-double-right">
                @foreach($subcategory as $subcategorydata)
                                        <li class="">
                                           <a href="{{route('courselist',['id'=>$subcategorydata['id']])}}" title="About Hurl">{{$subcategorydata->name}}</a>
                                       </li>
                                       @endforeach
              </ul>
                  
            </div>
            </div>
            <!--right section-->
            <div class="col-sm-12 col-lg-10 col-md-10 RightSection">
              <div class="row">
                    
                   @foreach($courses as $couselist)
                    <div class="col-md-3">
                        <div class="item pd-0">
                            <div class="box_grid">
                              <figure> <a href="{{route('coursedetail',['id'=>$couselist->id])}}" class="wish_bt"></a> <a href="#">
                                <div class="preview"><a href="{{route('coursedetail',['id'=>$couselist->id])}}"><span>Preview course</span></a></div>
                                <img src="{{asset('storage/uploads/'.$couselist->course_image)}}" class="img-fluid" alt=""></a> </figure>
                            
                              <div class="wrapper"> 
                              
                             
                           
                                <h3>Beginner</h3>
                                <p>{{$couselist->title}}</p>
                              </div>
                              <ul>
                                <li><a href="{{route('coursedetail',['id'=>$couselist->id])}}">View Now</a></li>
                              </ul>
                            </div>
                          </div>
                    </div>
                    @endforeach
                 
              </div>  
            </div>
          </div>
        </div>  
        @endsection 