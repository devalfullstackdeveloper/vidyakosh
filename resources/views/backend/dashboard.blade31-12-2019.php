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
<div class="filterPanelSt">
  <div class="row"> 
    <!--01-->
    <div class="col-xs-12 col-md-1 filtBg">Filter by</div>
    <!--./01--> 
    <!--/01-->
    <div class="col vMiddle">
      <div class="form-group">
          <input type="hidden" value="{{auth()->user()->id}}" id="login_user_id">
        <select class="form-control" name="designation_id">
          <option value="1">Select Designation</option>
          <option value="2">DG </option>
          <option value="4">Scientist H </option>
          <option value="5">Scientist G </option>
          <option value="7">Scientist F </option>
          <option value="9">Scientist E </option>
          <option value="13">Scientist D </option>
          <option value="25">Scientist C </option>
        </select>
      </div>
    </div>
    <!--/01--> 
    
    <!--/01-->
    <div class="col vMiddle">
      <div class="form-group">
        <select class="form-control" name="category_id">
          <option value="">Select Users</option>
          <option value="2">All </option>
          <option value="4">Kamal </option>
          <option value="5">Bharat </option>
          <option value="7">Shubham </option>
        </select>
      </div>
    </div>
    <!--/01--> 
    <!--/01-->
    <div class="col vMiddle ">
      <div class="form-group">
        <div class="input-group toText">
          <div class="input-group date datepicker" data-date-format="mm-dd-yyyy">
            <input class="form-control" type="text" readonly="">
            <span class="input-group-addon"><i class="fa fa-calendar dicion" style="padding: 10px;"></i></span> </div>
        </div>
      </div>
    </div>
    <!--/01--> 
    
    <!--/01-->
    <div class="col vMiddle">
      <div class="form-group">
        <div class="input-group">
          <div class="input-group date datepicker" data-date-format="mm-dd-yyyy">
            <input class="form-control" type="text" readonly="">
            <span class="input-group-addon"> <i class="fa fa-calendar dicion" style="padding: 10px;"></i></span> </div>
        </div>
      </div>
    </div>
    <!--/01--> 
    <!--/01-->
    <div class="col vMiddle text-left">
      <button type="submit" class="btn  btn-success">Go</button>
      &nbsp; &nbsp; <a href="#" class="btn btn-info">Reset</a> </div>
    <!--/01--> 
    
  </div>
</div>
<div class="totalViewSection">
  <div class="row"> 
    <!--box 1-->
    <div class="col">
      <div class="cardPanel training_tab"> <i class="fa fa-file-text float-left"></i> 2511 <span>Trainings</span> </div>
    </div>
    <!--./box 1--> 
    <!--box 1-->
    <div class="col">
      <div class="cardPanel institute_tab"> <i class="fa fa-university float-left"></i>500 <span>Institutes</span> </div>
    </div>
    <!--./box 1--> 
    <!--box 1-->
    <div class="col">
      <div class="cardPanel institute_faculty_tab"> <i class="fa fa-users float-left"></i> 500 <span>Institutes Faculites</span> </div>
    </div>
    <!--./box 1--> 
    <!--box 1-->
    <div class="col">
      <div class="cardPanel industry_tab"> <i class="fa fa-industry float-left"></i> 2511 <span>Industries</span> </div>
    </div>
    <!--./box 1--> 
    <!--box 1-->
    <div class="col">
      <div class="cardPanel industry_faculty_tab"> <i class="fa fa-user-plus float-left"></i>2546 <span>Indusrty Faculties</span> </div>
    </div>
    <!--./box 1--> 
    
  </div>
</div>

<div class="totalViewSection">
  <div class="row"> 
    <!--box 1-->
    <div class="col">
      <div class="cardPanel total_completed_cources"> <i class="fa fa-file-text float-left"></i> 2511 <span>Total Completed Courses</span> </div>
    </div>
    <!--./box 1--> 
    <!--box 1-->
    <div class="col">
      <div class="cardPanel course_inprogress"> <i class="fa fa-university float-left"></i>500 <span>Courses in Progress</span> </div>
    </div>
    <!--./box 1--> 
    <!--box 1-->
    <div class="col">
      <div class="cardPanel cource_yet_to_start"> <i class="fa fa-users float-left"></i> 500 <span>Courses yet to be Started</span> </div>
    </div>
    <!--./box 1--> 
    <!--box 1-->
    <div class="col">
      <div class="cardPanel in_house_accepted"> <i class="fa fa-industry float-left"></i> 2511 <span>In House Courses Accepted</span> </div>
    </div>
    <!--./box 1--> 
    <!--box 1-->
    <div class="col">
      <div class="cardPanel in_house_completed"> <i class="fa fa-user-plus float-left"></i>2546 <span>In House Courses Completed</span> </div>
    </div>
    <!--./box 1--> 
    
  </div>
</div>

<div class="totalViewSection">
  <div class="row"> 
    <!--box 1-->
    <div class="col">
      <div class="cardPanel total_assigned"> <i class="fa fa-file-text float-left"></i> 2511 <span>Total Assigned Courses</span> </div>
    </div>
    <!--./box 1--> 
    <!--box 1-->
    <div class="col">
      <div class="cardPanel total_crt_attended"> <i class="fa fa-university float-left"></i>500 <span>CRT Training Attended</span> </div>
    </div>
    <!--./box 1--> 
    
  </div>
</div>

<div class="row"> 
  <!--chart 01-->
  <div class="col-sm-12 col-lg-6">
    <div class="card">
      <div class="card-tittle" id="populationPanel">E-Learning Courses<span> <span class="rdPanel">
        <input type="radio">
        expert </span> <span class="rdPanel">
        <input type="radio">
        Beginner </span> <span class="rdPanel">
        <input type="radio">
        Intermediate </span> <span class="chartIcon"><img src="{{asset('assets/images/icon/bar-chart.svg')}}" id="barChartBtn"></span> <span class="chartIcon"><img src="{{asset('assets/images/icon/line.svg')}}" id="lineChartBtn"></span> 
        <!--   <span class="chartIcon"><img src="{{asset('assets/images/icon/filter.svg')}}" class="filterBtn"> </span>  --> 
        <i class="fa fa-arrows-alt btn-fullscreen"></i> <i class="fa fa-angle-down btn-slide"></i> <i class="fa fa-times btn-close"></i></span></div>
      <!--filter Box-->
      <div class="filterPanel f-box" style="display:none;">
        <div class="row">
          <div class="col-md-4">
            <p>Filter by Course</p>
            <select class="form-control">
              <option value="#">Select Course Categories</option>
              <option value="#">Army Institute of Technology</option>
              <option value="#">Army Institute of Hotel Management and Catering Technology </option>
              <option value="#">Army Institute of Management </option>
              <option value="#">Army Institute of Law</option>
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
        <canvas id="trainingChart" class="chartjs-render-monitor" width="1013" height="470" style="display: block; width: 1013px; height: 470px;"></canvas>
      </div>
    </div>
  </div>
  <!--chart 01--> 
  <div class="col-sm-12 col-lg-6">
    <div class="card">
      <div class="card-tittle" id="cetTrainingsBox">CRT Trainings<span> <span class="rdPanel">
        <input type="radio">
        expert </span> <span class="rdPanel">
        <input type="radio">
        Beginner </span> <span class="rdPanel">
        <input type="radio">
        Intermediate </span> <span class="chartIcon"><img src="{{asset('assets/images/icon/bar-chart.svg')}}" id="barChartBtn"></span> <span class="chartIcon"><img src="{{asset('assets/images/icon/line.svg')}}" id="lineChartBtn"></span> 
        <!--   <span class="chartIcon"><img src="{{asset('assets/images/icon/filter.svg')}}" class="filterBtn"> </span>  --> 
        <i class="fa fa-arrows-alt btn-fullscreen"></i> <i class="fa fa-angle-down btn-slide"></i> <i class="fa fa-times btn-close"></i></span></div>
      <!--filter Box-->
      <div class="filterPanel f-box" style="display:none;">
        <div class="row">
          <div class="col-md-4">
            <p>Filter by Course</p>
            <select class="form-control">
              <option value="#">Select Course Categories</option>
              <option value="#">Army Institute of Technology</option>
              <option value="#">Army Institute of Hotel Management and Catering Technology </option>
              <option value="#">Army Institute of Management </option>
              <option value="#">Army Institute of Law</option>
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
        <canvas id="cetTrainings" class="chartjs-render-monitor" width="1013" height="470" style="display: block; width: 1013px; height: 470px;"></canvas>
      </div>
    </div>
  </div>
  <!--chart 01-->
  <div class="col-sm-12 col-lg-6">
    <div class="card">
      <div class="card-tittle" id="schoolCollagePanel">Webinars<span> <span class="chartIcon"><img src="{{asset('assets/images/icon/line.svg')}}" id="lineChartBtn"></span> <span class="chartIcon"><img src="{{asset('assets/images/icon/bar-chart.svg')}}" id="barChartBtn"></span> 
        
        <!--  <span class="chartIcon"><img src="{{asset('assets/images/icon/filter.svg')}}" class="filterBtn-1"> </span>  --> 
        <i class="fa fa-arrows-alt btn-fullscreen"></i> <i class="fa fa-angle-down btn-slide"></i> <i class="fa fa-times btn-close"></i></span></div>
      <!--filter Box-->
      <div class="filterPanel f-box-1" style="display:none;">
        <div class="row">
          <div class="col-md-4">
            <p>Filter by Course</p>
            <select class="form-control">
              <option value="#">Select Course Categories</option>
              <option value="#">Army Institute of Technology</option>
              <option value="#">Army Institute of Hotel Management and Catering Technology </option>
              <option value="#">Army Institute of Management </option>
              <option value="#">Army Institute of Law</option>
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
        <canvas id="webinarsChart" class="chartjs-render-monitor" width="479" height="239" style="display: block; width: 479px; height: 239px;"></canvas>
      </div>
    </div>
  </div>
  <!--chart 01--> 
  
  <!--chart 01-->
  <div class="col-sm-12 col-lg-6">
    <div class="card">
      <div class="card-tittle" id="constituencyPanel">Expenditure <span> <span class="chartIcon"><img src="{{asset('assets/images/icon/line.svg')}}" id="lineChartBtn"></span> <span class="chartIcon"><img src="{{asset('assets/images/icon/bar-chart.svg')}}" id="barChartBtn"></span> 
        <!--  <span class="chartIcon"><img src="{{asset('assets/images/icon/filter.svg')}}" class="filterBtn-2"> </span>  --> 
        <i class="fa fa-arrows-alt n-fullscreen"></i> <i class="fa fa-angle-down btn-slide"></i> <i class="fa fa-times btn-close"></i></span></div>
      <!--filter Box-->
      <div class="filterPanel f-box-2" style="display:none;">
        <div class="row">
          <div class="col-md-4">
            <p>Filter by Course</p>
            <select class="form-control">
              <option value="#">Select Course Categories</option>
              <option value="#">Army Institute of Technology</option>
              <option value="#">Army Institute of Hotel Management and Catering Technology </option>
              <option value="#">Army Institute of Management </option>
              <option value="#">Army Institute of Law</option>
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
        <canvas id="constituencyDetailsChart" class="chartjs-render-monitor" style="width: 479px; height: 378px; display: block;" width="479" height="378"></canvas>
      </div>
    </div>
  </div>
  <!--chart 01--> 
  
</div>
<script>
    $(document).ready(function() {
       var loginUserId = $("#login_user_id").val(); 
       
       if(loginUserId) {
                $.ajax({
                    url: 'login-user-designation-ajax/'+loginUserId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        var designationHtml = '<option value="">Select Designation</option>';
                        $.each(data, function(key, val) {
                            designationHtml += '<option value="'+ key +'">'+ val +'</option>';
                        });
                        
                        $('select[name="designation_id"]').html(designationHtml);
                    }
                });
                
                $.ajax({
                    url: 'login-user-tabs-ajax/'+loginUserId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
//                        $.each(data, function(key, val) {
                            $(".training_tab").html('<i class="fa fa-file-text float-left"></i> ' + data.trainings + ' <span>Trainings</span>');
                            $(".institute_tab").html('<i class="fa fa-university float-left"></i>  ' + data.institutes + ' <span>Institutes</span>');
                            $(".institute_faculty_tab").html('<i class="fa fa-users float-left"></i> ' + data.industries + ' <span>Institutes Faculites</span>');
                            $(".industry_tab").html('<i class="fa fa-industry float-left"></i> ' + data.instituteFaculties + ' <span>Industries</span>');
                            $(".industry_faculty_tab").html('<i class="fa fa-user-plus float-left"></i>' + data.industrieFaculties + ' <span>Indusrty Faculties</span>');
                            $(".total_completed_cources").html('<i class="fa fa-file-text float-left"></i> ' + data.completed_cources + ' <span>Total Completed Courses</span>');
                            $(".course_inprogress").html('<i class="fa fa-university float-left"></i>' + data.course_inprogress + ' <span>Courses in Progress</span>');
                            $(".cource_yet_to_start").html('<i class="fa fa-users float-left"></i> ' + data.course_yet_to_start + '  <span>Courses yet to be Started</span>');
                            $(".in_house_accepted").html('<i class="fa fa-industry float-left"></i> ' + data.in_house_courses_accepted + '  <span>In House Courses Accepted</span>');
                            $(".in_house_completed").html('<i class="fa fa-user-plus float-left"></i>' + data.in_house_courses_completed + '  <span>In House Courses Completed</span>');
                            $(".total_assigned").html('<i class="fa fa-file-text float-left"></i> ' + data.total_assigned_cources + ' <span>Total Assigned Courses</span>');
                            $(".total_crt_attended").html('<i class="fa fa-university float-left"></i>' + data.crt_attended + ' <span>CRT Training Attended</span>');
                            $(".total_crt_attended").html('<i class="fa fa-university float-left"></i>' + data.crt_attended + ' <span>CRT Training Attended</span>');
//                        });
                    }
                });
       }
       
    });
</script>
@endsection 
