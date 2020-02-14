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
        <div class="col vMiddle">
            <div class="form-group">
                <select class="form-control" name="department_role">
                    <option value="">Department Role</option>
                </select>
            </div>
        </div>
        <!--/01-->
        <div class="col vMiddle">
            <div class="form-group">
                <input type="hidden" value="{{auth()->user()->id}}" id="login_user_id">
                <select class="form-control" name="designationid">
                    <option value="">Select Designation</option>
                    @if(isset($designation))
                    @foreach($designation as $designationdata)
                    <option value="{{$designationdata->id}}">{{$designationdata->designation}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <!--/01--> 

        <!--/01-->
        <!--        <div class="col vMiddle">
            <div class="form-group">
                <select class="form-control" name="category_id">
                    <option value="">Select Users</option>
                    @if(isset($users))
                    @foreach($users as $usr)
                    <option value="{{$usr->id}}">{{$usr->name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
                </div>-->
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

<!--box-->
<div class="row">
    <div class="col-md-12">
        <button class="togglebtn">Expand</button>
    </div>
</div>


<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-statistic-4 heightSt-1">
                <div class="align-items-center justify-content-between">
                    <div class="row ">
                        <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0">
                            <div class="card-content">
                                <h5 class="font-13">Training</h5>
                                <h2 class="font-18"></h2>
                               <!-- <p class="mb-0"><span class="col-green">10%</span> Increase</p> -->
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="{{asset('images/banner/teaching.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-statistic-4 heightSt-1">
                <div class="align-items-center justify-content-between">
                    <div class="row ">
                        <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0">
                            <div class="card-content">
                                <h5 class="font-13"> Institutes</h5>
                                <h2 class="font-18"></h2>
                              <!--  <p class="mb-0"><span class="col-orange">09%</span> Decrease</p> -->
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="{{asset('images/banner/penitentiary.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-statistic-4 heightSt-1">
                <div class="align-items-center justify-content-between">
                    <div class="row ">
                        <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0">
                            <div class="card-content">
                                <h5 class="font-13">Institutes/Faculties</h5>
                                <h2 class="font-18"></h2>
                             <!--   <p class="mb-0"><span class="col-green">18%</span> Increase</p> -->
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="{{asset('images/banner/conference.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-statistic-4 heightSt-1">
                <div class="align-items-center justify-content-between">
                    <div class="row ">
                        <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0">
                            <div class="card-content">
                                <h5 class="font-13">Industries</h5>
                                <h2 class="font-18"></h2>
                             <!--   <p class="mb-0"><span class="col-green">42%</span> Increase</p> -->
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="{{asset('images/banner/factory.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-statistic-4 heightSt-1">
                <div class="align-items-center justify-content-between">
                    <div class="row ">
                        <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0">
                            <div class="card-content">
                                <h5 class="font-13">Industries/Faculties</h5>
                                <h2 class="font-18"></h2>
                             <!--   <p class="mb-0"><span class="col-green">42%</span> Increase</p> -->
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="{{asset('images/banner/conference.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="togglesection">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-statistic-4 heightSt-2">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0">
                                <div class="card-content">
                                    <h5 class="font-13">Total Completed Courses</h5>
                                    <h2 class="font-18">2511</h2>
                                   <!-- <p class="mb-0"><span class="col-green">10%</span> Increase</p> -->
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="{{asset('images/banner/certificate.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-statistic-4 heightSt-2">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0">
                                <div class="card-content">
                                    <h5 class="font-13">Course in Progress</h5>
                                    <h2 class="font-18">500</h2>
                                  <!--  <p class="mb-0"><span class="col-orange">09%</span> Decrease</p> -->
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="{{asset('images/banner/2.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-statistic-4 heightSt-2">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0">
                                <div class="card-content">
                                    <h5 class="font-13">Courses yet to be Started</h5>
                                    <h2 class="font-18">500</h2>
                                 <!--   <p class="mb-0"><span class="col-green">18%</span> Increase</p> -->
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="{{asset('images/banner/3.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-statistic-4 heightSt-2">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0">
                                <div class="card-content">
                                    <h5 class="font-13">In House Courses Accepted</h5>
                                    <h2 class="font-18">2511</h2>
                                 <!--   <p class="mb-0"><span class="col-green">42%</span> Increase</p> -->
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="{{asset('images/banner/4.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-statistic-4 heightSt-2">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0">
                                <div class="card-content">
                                    <h5 class="font-13">In House Courses Completed</h5>
                                    <h2 class="font-18">2546</h2>
                                 <!--   <p class="mb-0"><span class="col-green">42%</span> Increase</p> -->
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="{{asset('images/banner/4.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0">
                                <div class="card-content">
                                    <h5 class="font-13">Total Assigned Courses</h5>
                                    <h2 class="font-18">2511</h2>
                                   <!-- <p class="mb-0"><span class="col-green">10%</span> Increase</p> -->
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="{{asset('images/banner/1.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0">
                                <div class="card-content">
                                    <h5 class="font-13">CRT Training Attended</h5>
                                    <h2 class="font-18">500</h2>
                                  <!--  <p class="mb-0"><span class="col-orange">09%</span> Decrease</p> -->
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="{{asset('images/banner/2.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--./box-->

<!--<div class="row">
   <div class="col-12 col-sm-12 col-lg-12">
       <div class="card ">
           <div class="card-header">
               <h4>Revenue chart</h4>

           </div>
           <div class="card-body">
               <div class="row">
                   <div class="col-lg-9">
                       <div id="chart1"> <apexchart type=line height=250 :options="chartOptions" :series="series" /></div>
                       <div class="row mb-0">
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                               <div class="list-inline text-center">
                                   <div class="list-inline-item p-r-30"><i data-feather="arrow-up-circle"
                                                                           class="col-green"></i>
                                       <h5 class="m-b-0">$675</h5>
                                       <p class="text-muted font-14 m-b-0">Weekly Earnings</p>
                                   </div>
                               </div>
                           </div>
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                               <div class="list-inline text-center">
                                   <div class="list-inline-item p-r-30"><i data-feather="arrow-down-circle"
                                                                           class="col-orange"></i>
                                       <h5 class="m-b-0">$1,587</h5>
                                       <p class="text-muted font-14 m-b-0">Monthly Earnings</p>
                                   </div>
                               </div>
                           </div>
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                               <div class="list-inline text-center">
                                   <div class="list-inline-item p-r-30"><i data-feather="arrow-up-circle"
                                                                           class="col-green"></i>
                                       <h5 class="mb-0 m-b-0">$45,965</h5>
                                       <p class="text-muted font-14 m-b-0">Yearly Earnings</p>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="col-lg-3">
                       <div class="row mt-5">
                           <div class="col-7 col-xl-7 mb-3">Total customers</div>
                           <div class="col-5 col-xl-5 mb-3">
                               <span class="text-big">8,257</span>
                               <sup class="col-green">+09%</sup>
                           </div>
                           <div class="col-7 col-xl-7 mb-3">Total Income</div>
                           <div class="col-5 col-xl-5 mb-3">
                               <span class="text-big">$9,857</span>
                               <sup class="text-danger">-18%</sup>
                           </div>
                           <div class="col-7 col-xl-7 mb-3">Project completed</div>
                           <div class="col-5 col-xl-5 mb-3">
                               <span class="text-big">28</span>
                               <sup class="col-green">+16%</sup>
                           </div>
                           <div class="col-7 col-xl-7 mb-3">Total expense</div>
                           <div class="col-5 col-xl-5 mb-3">
                               <span class="text-big">$6,287</span>
                               <sup class="col-green">+09%</sup>
                           </div>
                           <div class="col-7 col-xl-7 mb-3">New Customers</div>
                           <div class="col-5 col-xl-5 mb-3">
                               <span class="text-big">684</span>
                               <sup class="col-green">+22%</sup>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
         </div> -->


<div class="row"> 
    <!--<div class="col-sm-12 col-lg-12">
        <div class="card">
            <div class="card-tittle" id="populationPanel">Upcoming Trainings </div>
            <!--filter Box-->
            <!--            <div class="filterPanel f-box">
                            <div class="row">
                                <div class="col-md-4">
                                    <p>Training Filter</p>
                                    <select class="form-control" name="training_filter">
                                        <option value="1">Next Week</option>
                                        <option value="2">Next Month</option>
                                        <option value="3">Next Quearter</option>
                                        <option value="4">Full Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>-->
            <?php
                $id = Auth::user()->id;
                $officeLocation = 1;
                if(isset($id)){
                    $user = DB::table('user_details')->where('user_id',$id)->select('office_id')->get();
                    if(count($user) > 0){
                        $location = DB::table('locations')->where('id',$user[0]->office_id)->select('parent_office_id','state_id')->get();
                        $officeLocation = $location[0]->parent_office_id;
                        $stateId = $location[0]->state_id;
                    }
                }
            ?>

            <!-- <div class="filterPanel f-box">
                <div class="row">
                    <div class="col-md-4">
                        <p>Training Filter</p>                
                        <select class="form-control"  name="training_filter">
                            <option value="1">Next Week</option>
                            <option value="2">Next Month</option>
                            <option value="3">Next Quarter</option>
                            <option value="4">Current Year</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <p>&nbsp;</p>
                        <select class="form-control" name="training_filter_2">
                            <option value="0">All</option>
                            <option value="1">National Training</option>
                            @if($officeLocation == 0)
                            <option value="2">HQ Training</option>                           
                            @endif
                            @if($officeLocation != 0)
                            <option value="2">State Training</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <p>&nbsp;</p>
                        <button type="button" class="btn  btn-success training_filter_btn">Submit</button>
                    </div>
                </div>
            </div>
            <!--filter Box-->

            <!--<div class="card-body">
                <table id="myTable"
                       class="table table-bordered table-striped  dt-select ">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Training Title</th>
                            <th>To be Organised by</th>
                            <th>Venue</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Last Date of Nomination</th>
                            <th>Actions</th>
                        </tr>
                        <?php $i = 1; ?>
                        @foreach ($trainings as $training)

                        <tr>
                            <td>{{$i}}</td>
                            <td>{{ $training->title }}</td>
                            <td>{{ $training->parent_office_id }}</td>
                            <td>{{ $training->address }}</td>
                            <td>{{ $training->start_date }}</td>
                            <td>{{ $training->end_date }}</td>
                            <td>{{ $training->lastnominne }}</td>
                            <td>
<!--                                <a href="http://companydemo.in/dev/vidyakosh/public/user/nominate?trainings=12" class="btn btn-xs btn-success mb-1">Request for nomination</a>-->
                                <!--<a href="{{url('user/nominate')}}?trainings={{$training->id}}" class="btn btn-xs btn-success mb-1">Request for Nomination</a>
<!--                                <a href="http://companydemo.in/dev/vidyakosh/public/user/view?trainings=12" class="btn btn-xs btn-warning mb-1">View Detail</a>-->
                                <!--<a href="{{url('user/view')}}?trainings={{$training->id}}" class="btn btn-xs btn-warning mb-1">View Details</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach

                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>-->
    <!--chart 01-->
    <div class="col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-tittle" id="populationPanel">E-Learning Courses<span> 
                    <span class="rdPanel">
                        <i class="fa fa-angle-down btn-slide"></i> <i class="fa fa-times btn-close"></i>
                    </span>
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
            <div class="card-tittle" id="cetTrainingsBox">CRT Trainings
                    <span class="rdPanel">
                        <i class="fa fa-angle-down btn-slide"></i> <i class="fa fa-times btn-close"></i>
                    </span>
            </div>

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
            <div class="card-tittle" id="schoolCollagePanel">Seminar
                <span>
                    <i class="fa fa-angle-down btn-slide"></i> 
                    <i class="fa fa-times btn-close"></i>
                </span></div>

            <div class="card-body">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
<!--                <canvas id="webinarsChart" class="chartjs-render-monitor" width="479" height="239" style="display: block; width: 479px; height: 239px;"></canvas>-->
                <canvas id="seminarChart" class="chartjs-render-monitor" width="479" height="239" style="display: block; width: 479px; height: 239px;"></canvas>
            </div>
        </div>
    </div>
    <!--chart 01--> 

    <!--chart 01-->
    <div class="col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-tittle" id="constituencyPanel">Executive Briefing  
              <!--  <span class="chartIcon"><img src="{{asset('assets/images/icon/filter.svg')}}" class="filterBtn-2"> </span>  --> 
                    <span><i class="fa fa-angle-down btn-slide"></i> <i class="fa fa-times btn-close"></i></span>
            </div>

            <div class="card-body">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
<!--                <canvas id="constituencyDetailsChart" class="chartjs-render-monitor" width="479" height="239" style="display: block; width: 479px; height: 239px;"></canvas>-->
                <canvas id="executiveBriefingChart" class="chartjs-render-monitor" width="479" height="239" style="display: block; width: 479px; height: 239px;"></canvas>
            </div>
        </div>
    </div>
    <!--chart 01--> 

</div>
<div class="modal fade bd-example-modal-lg crt_details" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Training View</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body crt-details-modal">
                    
                </div>
            </div>
        </div>
    </div>
<script>
 

    $(document).ready(function(){
        $("button.togglebtn").click(function(){
            $(".togglesection").toggle(1000);
        });
    });

    $(document).ready(function() {
        $(".training_filter_btn").click(function(){
            var trainingFilter = $('select[name="training_filter"]').val();
            var training_filter_2 = $('select[name="training_filter_2"]').val();
            var route = '{{route('admin.trainings.index')}}';
            window.location.replace(route+"?p="+trainingFilter+','+training_filter_2);
        });
        //        $('select[name="training_filter"]').change(function(){
        //            var trainingFilter = $(this).val();
        //            var route = '{{route('admin.trainings.index')}}';
        //            console.log(route);
        //            window.location.replace(route+"?p="+trainingFilter);
        //        });
    
        var loginUserId = $("#login_user_id").val(); 
       
        if(loginUserId) {
            $.ajax({
                url: 'login-user-designation-ajax/'+loginUserId,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    var designationHtml = '<option value="">Designation</option>';
                    var deptRoleHtml = '<option value="">Department Role</option>';
                    $.each(data, function(ddKey, ddVal) {
                        $.each(ddVal, function(key, val) {
                            if(ddKey == "designation"){
                                designationHtml += '<option value="'+ key +'">'+ val +'</option>';
                            }
                            if(ddKey == "department_role"){
                                deptRoleHtml += '<option value="'+ key +'">'+ val +'</option>';
                            }
                        });
                    });
                        
                    $('select[name="designation_id"]').html(designationHtml);
                    $('select[name="department_role"]').html(deptRoleHtml);
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
                    /*For CRT Chart*/
                    var category = new Array();
                    var crtCnt = new Array();
                    var catIds = new Array();
                    var chartArr = jQuery.parseJSON(data.crt_chart);
                    $.each(chartArr, function(key, val) {
                        category.push(key);
                        crtCnt.push(val.count);
                        catIds.push(val.cat_id);
                    });
                    var dataCRT = {
                        labels: category,
                        datasets: [{
                                label: 'CRT Training',
                                backgroundColor: ["#1a2b4a", "#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],
                                data: crtCnt
                            }]
                    };            
                    var optionCRT = {
                        legend: {
                            display: false
                        },                
                        scales: {
                            xAxes: [{
                                stacked: true,
                                gridLines: {
                                    display: false
                                }
                            }],
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    stepSize: 1,
                                    beginAtZero: true
                                },
                                type: 'linear'
                            }]
                    }};
            
                $(document).ready(function() {
                    var canvas = document.getElementById("cetTrainings");
                    var ctx = canvas.getContext("2d");
                    var myNewChart = new Chart(ctx, {
                        type: 'bar',
                        options:optionCRT,
                        data: dataCRT,
                        cat_id: catIds
                    });
                    canvas.onclick = function(evt) {
                        var activePoints = myNewChart.getElementsAtEvent(evt);
                        if (activePoints[0]) {
                                var chartData = activePoints[0]['_chart'].config.data;
                                var idx = activePoints[0]['_index'];
                                var catId = chartData.datasets[0].cat_id[idx];
                                $.ajax({
                                    url: 'crtDetails-ajax/'+loginUserId+','+catId+',crt_training',
                                    type: "GET",
                                    dataType: "json",
                                    success:function(data) {
                                        var html = "";
                                        html +='<table class="table table-striped table-bordered" width="100%" border="0" cellspacing="0" cellpadding="0">';
                                            html +='<thead>';
                                                html +='<tr>';
                                                    html +='<td>SR No.</td>';
                                                    html +='<td>Title</td>';
                                                    html +='<td>Duration</td>';
                                                    html +='<td>Venue</td>';
                                                html +='</tr>';
                                            html +='</thead>';
                                            html +='<tbody>';
                                                $.each(data, function(key, val) {
                                                    html +='<tr>';
                                                        html +='<td>'+(key + 1)+'</td>';
                                                        html +='<td>'+val.name+'</td>';
                                                        html +='<td>'+val.duration+'</td>';
                                                        html +='<td>'+val.venue+'</td>';
                                                    html +='</tr>';
                                                });
                                            html +='</tbody>';
                                        html +='</table>';
                                        $('.crt-details-modal').html(html);
                                        $('.crt_details').modal('show');
                                    }
                                });                            
                            }
                    };
                });
                /*For ELearning Chart*/
                    var category = new Array();
                    var elCnt = new Array();
                    var catIds = new Array();
                    var chartArr = jQuery.parseJSON(data.eLearning_chart);
                    $.each(chartArr, function(key, val) {
                        category.push(key);
                        elCnt.push(val.count);
                        catIds.push(val.cat_id);
                    });
                    var dataEL = {
                        labels: category,
                        datasets: [{
                                label: 'E-Learning',
                                backgroundColor: ["#1a2b4a", "#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677","#1a2b4a"],
                                data: elCnt,
//                                data: [2,3,4,5,6,7,8,9,1,5],
                                cat_id: catIds
                            }]
                    };            
                    var optionEL = {
                        legend: {
                            display: false
                        },                
                        scales: {
                            xAxes: [{
                                stacked: true,
                                gridLines: {
                                    display: false
                                }
                            }],
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    stepSize: 1,
                                    beginAtZero: true
                                },
                                type: 'linear'
                            }]
                    }};
            
                $(document).ready(function() {
                    var canvas = document.getElementById("trainingChart");
                    var ctx = canvas.getContext("2d");
                    var myNewChart = new Chart(ctx, {
                        type: 'bar',
                        options:optionEL,
                        data: dataEL
                    });
                    canvas.onclick = function(evt) {
                        var activePoints = myNewChart.getElementsAtEvent(evt);
                        if (activePoints[0]) {
                            var chartData = activePoints[0]['_chart'].config.data;
                            var idx = activePoints[0]['_index'];
                            var catId = chartData.datasets[0].cat_id[idx];
                            $.ajax({
                                url: 'crtDetails-ajax/'+loginUserId+','+catId+',e_learning',
                                type: "GET",
                                dataType: "json",
                                success:function(data) {
                                    var html = "";
                                    html +='<table class="table table-striped table-bordered" width="100%" border="0" cellspacing="0" cellpadding="0">';
                                        html +='<thead>';
                                            html +='<tr>';
                                                html +='<td>SR No.</td>';
                                                html +='<td>Title</td>';
                                            html +='</tr>';
                                        html +='</thead>';
                                        html +='<tbody>';
                                            $.each(data, function(key, val) {
                                                html +='<tr>';
                                                    html +='<td>'+(key + 1)+'</td>';
                                                    html +='<td>'+val.name+'</td>';
                                                html +='</tr>';
                                            });
                                        html +='</tbody>';
                                    html +='</table>';
                                    $('.crt-details-modal').html(html);
                                    $('.crt_details').modal('show');
                                }
                            });                            
                        }
                    };
                });
                /*For Seminar Chart*/
                    var category = new Array();
                    var smCnt = new Array();
                    var catIds = new Array();
                    var chartArr = jQuery.parseJSON(data.seminar_chart);
                    $.each(chartArr, function(key, val) {
                        category.push(key);
                        smCnt.push(val.count);
                        catIds.push(val.cat_id);
                    });
                    var dataSM = {
                        labels: category,
                        datasets: [{
                                label: 'Seminar',
                                backgroundColor: ["#1a2b4a", "#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],
                                data: smCnt,
                                cat_id: catIds
                            }]
                    };            
                    var optionSM = {
                        legend: {
                            display: false
                        },                
                        scales: {
                            xAxes: [{
                                stacked: true,
                                gridLines: {
                                    display: false
                                }
                            }],
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    stepSize: 1,
                                    beginAtZero: true
                                },
                                type: 'linear'
                            }]
                    }};
            
                $(document).ready(function() {
                    var canvas = document.getElementById("seminarChart");
                    var ctx = canvas.getContext("2d");
                    var myNewChart = new Chart(ctx, {
                        type: 'bar',
                        options:optionSM,
                        data: dataSM
                    });
                    canvas.onclick = function(evt) {
                        var activePoints = myNewChart.getElementsAtEvent(evt);
                        if (activePoints[0]) {
                            var chartData = activePoints[0]['_chart'].config.data;
                            var idx = activePoints[0]['_index'];
                            var catId = chartData.datasets[0].cat_id[idx];
                            $.ajax({
                                url: 'crtDetails-ajax/'+loginUserId+','+catId+',seminar',
                                type: "GET",
                                dataType: "json",
                                success:function(data) {
                                    var html = "";
                                    html +='<table class="table table-striped table-bordered" width="100%" border="0" cellspacing="0" cellpadding="0">';
                                        html +='<thead>';
                                            html +='<tr>';
                                                html +='<td>SR No.</td>';
                                                html +='<td>Title</td>';
                                                html +='<td>Duration</td>';
                                                html +='<td>Venue</td>';
                                            html +='</tr>';
                                        html +='</thead>';
                                        html +='<tbody>';
                                            $.each(data, function(key, val) {
                                                html +='<tr>';
                                                    html +='<td>'+(key + 1)+'</td>';
                                                    html +='<td>'+val.name+'</td>';
                                                    html +='<td>'+val.duration+'</td>';
                                                    html +='<td>'+val.venue+'</td>';
                                                html +='</tr>';
                                            });
                                        html +='</tbody>';
                                    html +='</table>';
                                    $('.crt-details-modal').html(html);
                                    $('.crt_details').modal('show');
                                }
                            });                            
                        }
                    };
                });
                /*For Executive Briefing Chart*/
                    var category = new Array();
                    var ebCnt = new Array();
                    var catIds = new Array();
                    var chartArr = jQuery.parseJSON(data.executiveBriefing_chart);
                    $.each(chartArr, function(key, val) {
                        category.push(key);
                        ebCnt.push(val.count);
                        catIds.push(val.cat_id);
                    });
                    var dataEB = {
                        labels: category,
                        datasets: [{
                                label: 'Executive Briefing',
                                backgroundColor: ["#1a2b4a", "#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],
                                data: ebCnt,
                                cat_id: catIds
                            }]
                    };            
                    var optionEB = {
                        legend: {
                            display: false
                        },                
                        scales: {
                            xAxes: [{
                                stacked: true,
                                gridLines: {
                                    display: false
                                }
                            }],
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    stepSize: 1,
                                    beginAtZero: true
                                },
                                type: 'linear'
                            }]
                    }};
            
                    $(document).ready(function() {
                        var canvas = document.getElementById("executiveBriefingChart");
                        var ctx = canvas.getContext("2d");
                        var myNewChart = new Chart(ctx, {
                            type: 'bar',
                            options:optionEB,
                            data: dataEB
                        });
                        canvas.onclick = function(evt) {
                            var activePoints = myNewChart.getElementsAtEvent(evt);
                            if (activePoints[0]) {
                                var chartData = activePoints[0]['_chart'].config.data;
                                var idx = activePoints[0]['_index'];
                                var catId = chartData.datasets[0].cat_id[idx];
                                $.ajax({
                                    url: 'crtDetails-ajax/'+loginUserId+','+catId+',executing_briefing',
                                    type: "GET",
                                    dataType: "json",
                                    success:function(data) {
                                        var html = "";
                                        html +='<table class="table table-striped table-bordered" width="100%" border="0" cellspacing="0" cellpadding="0">';
                                            html +='<thead>';
                                                html +='<tr>';
                                                    html +='<td>SR No.</td>';
                                                    html +='<td>Title</td>';
                                                    html +='<td>Duration</td>';
                                                    html +='<td>Venue</td>';
                                                html +='</tr>';
                                            html +='</thead>';
                                            html +='<tbody>';
                                                $.each(data, function(key, val) {
                                                    html +='<tr>';
                                                        html +='<td>'+(key + 1)+'</td>';
                                                        html +='<td>'+val.name+'</td>';
                                                        html +='<td>'+val.duration+'</td>';
                                                        html +='<td>'+val.venue+'</td>';
                                                    html +='</tr>';
                                                });
                                            html +='</tbody>';
                                        html +='</table>';
                                        $('.crt-details-modal').html(html);
                                        $('.crt_details').modal('show');
                                    }
                                });                            
                            }
                        };
                    });

                    
                    
                    /*For CRT Chart*/
//                    var state = new Array();
//                    var crtCnt = new Array();
//                    var chartArr = jQuery.parseJSON(data.crt_chart);
//                    $.each(chartArr, function(key, val) {
//                        state.push(key);
//                        crtCnt.push(val);
//                    });
//                            
//                    var config = {
//                        type: 'bar',
//                        data: {
//                            labels: state,
//                            datasets: [{
//                                    label: "CRT Training",
//                                    data: crtCnt,
//                                    fill: true,
//                                    borderColor: "rgba(49,172,170,0.9)",
//                                    backgroundColor: ["#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],
//                                    fill: false,
//                                    pointRadius: 4,
//                                    pointHitRadius: 10
//                                }
//                            ]
//                        },
//                        options: {
//                            responsive: true,
//                            legend: {
//                                display: false,
//                                position: 'bottom'
//                            },
//                            scales: {
//                                yAxes: [{
//                                        ticks: {
//                                            stepSize: 1,
//                                            beginAtZero: true
//                                        },
//                                        scaleLabel: {
//                                            labelString: 'Total CRT',
//                                            display: true
//                                        }
//                                    }]
//                            },
//                            title: {
//                                fontSize: 12,
//                                display: true,
//                                text: 'CRT Training',
//                                position: 'bottom'
//                            }
//                        }
//                    };
//                    var myChart;
//                    change('bar');                                
//                    function change(newType) {
//                        var ctx = document.getElementById("cetTrainings").getContext("2d");
//                        if (myChart) {
//                            myChart.destroy();
//                        }
//                        var temp = jQuery.extend(true, {}, config);
//                        temp.type = newType;
//                        myChart = new Chart(ctx, temp);
//                    };
                                
                    /*For ELearning Chart*/
//                    var category = new Array();
//                    var elCnt = new Array();
//                    var chartArr = jQuery.parseJSON(data.eLearning_chart);
//                    $.each(chartArr, function(key, val) {
//                        category.push(key);
//                        elCnt.push(val);
//                    });
//                    var config1 = {
//                        type: 'bar',
//                        data: {
//                            labels: category,
//                            datasets: [{
//                                    label: "E-Learning",
//                                    data: elCnt,
//                                    fill: true,
//                                    borderColor: "rgba(49,172,170,0.9)",
//                                    backgroundColor: ["#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],
//                                    fill: false,
//                                    pointRadius: 4,
//                                    pointHitRadius: 10
//                                }
//                            ]
//                        },
//                        options: {
//                            responsive: true,
//                            legend: {
//                                display: false,
//                                position: 'bottom'
//                            },
//                            scales: {
//                                yAxes: [{
//                                        ticks: {
//                                            stepSize: 1,
//                                            beginAtZero: true
//                                        },
//                                        scaleLabel: {
//                                            labelString: 'Total E-Learning',
//                                            display: true
//                                        }
//                                    }]
//                            },
//                            title: {
//                                fontSize: 12,
//                                display: true,
//                                text: 'E-Learning',
//                                position: 'bottom'
//                            }
//                        }
//                    };
//                    var myChart1;
//                    change1('bar');                                
//                    function change1(newType) {
//                        var ctx = document.getElementById("trainingChart").getContext("2d");
//                        if (myChart1) {
//                            myChart1.destroy();
//                        }
//                        var temp = jQuery.extend(true, {}, config1);
//                        temp.type = newType;
//                        myChart1 = new Chart(ctx, temp);
//                    }                       
                    /*For Seminar Chart*/
//                    var category = new Array();
//                    var elCnt = new Array();
//                    var chartArr = jQuery.parseJSON(data.seminar_chart);
//                    $.each(chartArr, function(key, val) {
//                        category.push(key);
//                        elCnt.push(val);
//                    });
//                    var config2 = {
//                        type: 'bar',
//                        data: {
//                            labels: category,
//                            datasets: [{
//                                    label: "Seminar",
//                                    data: elCnt,
//                                    fill: true,
//                                    borderColor: "rgba(49,172,170,0.9)",
//                                    backgroundColor: ["#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],
//                                    fill: false,
//                                    pointRadius: 4,
//                                    pointHitRadius: 10
//                                }
//                            ]
//                        },
//                        options: {
//                            responsive: true,
//                            legend: {
//                                display: false,
//                                position: 'bottom'
//                            },
//                            scales: {
//                                yAxes: [{
//                                        ticks: {
//                                            stepSize: 1,
//                                            beginAtZero: true
//                                        },
//                                        scaleLabel: {
//                                            labelString: 'Total Seminar',
//                                            display: true
//                                        }
//                                    }]
//                            },
//                            title: {
//                                fontSize: 12,
//                                display: true,
//                                text: 'Seminar',
//                                position: 'bottom'
//                            }
//                        }
//                    };
//                    var myChart2;
//                    change2('bar');                                
//                    function change2(newType) {
//                        var ctx = document.getElementById("seminarChart").getContext("2d");
//                        if (myChart2) {
//                            myChart2.destroy();
//                        }
//                        var temp = jQuery.extend(true, {}, config2);
//                        temp.type = newType;
//                        myChart2 = new Chart(ctx, temp);
//                    }                       
                    /*For Executive Briefing Chart*/
//                    var category = new Array();
//                    var elCnt = new Array();
//                    var chartArr = jQuery.parseJSON(data.executiveBriefing_chart);
//                    $.each(chartArr, function(key, val) {
//                        category.push(key);
//                        elCnt.push(val);
//                    });
//                    var config3 = {
//                        type: 'bar',
//                        data: {
//                            labels: category,
//                            datasets: [{
//                                    label: "Executive-Briefing",
//                                    data: elCnt,
//                                    fill: true,
//                                    borderColor: "rgba(49,172,170,0.9)",
//                                    backgroundColor: ["#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],
//                                    fill: false,
//                                    pointRadius: 4,
//                                    pointHitRadius: 10
//                                }
//                            ]
//                        },
//                        options: {
//                            responsive: true,
//                            legend: {
//                                display: false,
//                                position: 'bottom'
//                            },
//                            scales: {
//                                yAxes: [{
//                                        ticks: {
//                                            stepSize: 1,
//                                            beginAtZero: true
//                                        },
//                                        scaleLabel: {
//                                            labelString: 'Total Executive Briefing',
//                                            display: true
//                                        }
//                                    }]
//                            },
//                            title: {
//                                fontSize: 12,
//                                display: true,
//                                text: 'Executive Briefing',
//                                position: 'bottom'
//                            }
//                        }
//                    };
//                    var myChart3;
//                    change3('bar');                                
//                    function change3(newType) {
//                        var ctx = document.getElementById("executiveBriefingChart").getContext("2d");
//                        if (myChart3) {
//                            myChart3.destroy();
//                        }
//                        var temp = jQuery.extend(true, {}, config3);
//                        temp.type = newType;
//                        myChart3 = new Chart(ctx, temp);
//                    }                       
                }
            });
        }
       
    });
</script>

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

        $('.togglebtn').click(function(){
            var $this = $(this);
            $this.toggleClass('SeeMore2');
            if($this.hasClass('SeeMore2')){
                $this.text('Shrink');     
            } else {
                $this.text('Expand');
            }
        });


    });
</script>

<script>
    //School Collage
    $(document).ready(function(){
        var config = {
            type: 'line',
            data: {
                labels: ["Kotputli", "Viratnagar", "Shahpura ", "Phulera", "Jhotwara", "Amer", "Ramgarh", "Bansur", "Baran", "Barmer", "Bikaner", "Churu"],
                datasets: [{
                        label: "Population",
                        data: [10, 13, 17, 12, 30, 47, 60, 120, 230, 300, 310, 400],
	   
                        fill: true,
                        borderColor: "rgba(49,172,170,0.9)",
                        backgroundColor:[ "#36a2eb","#ff6384","#ff9f40","#ffcd56","#4bc0c0","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
                        //	   borderCapStyle: 'square',
                        //    pointBorderColor: "white",
                        //    pointBackgroundColor: "green",
                        //    pointBorderWidth: 1,
                        //    pointHoverRadius: 8,
                        //    pointHoverBackgroundColor: "yellow",
                        //    pointHoverBorderColor: "green",
                        //    pointHoverBorderWidth: 2,
                        fill: false,
                        pointRadius: 4,
                        pointHitRadius: 10,
                    },]
            },
  
            options: {
                responsive: true,
                legend: {
                    display: false,
                    // position: 'bottom',
                },
		
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: false
                            },
                            scaleLabel: {
                                labelString: 'Attendees',
                                display: true,
                            },
                        }]
                },
                title: {
                    fontSize: 12,
                    display: true,
                    text: 'Webinars Categories',
                    position: 'bottom'
                }
            },
  
        };

        var myChart;
        change('line');
        $("#schoolCollagePanel #barChartBtn").click(function() {
            change('bar');
        });

        $("#schoolCollagePanel #pieChartBtn").click(function() {
            change('polarArea');
            //backgroundColor:[ "#ff4243","#ffd13e","#45c27e","#42c4f5","#ff4342","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
  
        });

        $("#schoolCollagePanel #lineChartBtn").click(function() {
            change('line');
        });

        function change(newType) {
            var ctx = document.getElementById("webinarsChart").getContext("2d");

            // Remove the old chart and all its event handles
            if (myChart) {
                myChart.destroy();
            }

            // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
            var temp = jQuery.extend(true, {}, config);
            temp.type = newType;
            //temp.type = newType;
            myChart = new Chart(ctx, temp);
        };

    });
</script>

<script>
    //Constituency Details
    $(document).ready(function(){
        var config = {
            type: 'bar',
            data: {
                labels: ["2005", "2006", "2007", "2008", "2009", "2010", "2011", "2012", "2013", "2014", "2015", "2016"],
                datasets: [{
                        label: "Population",
                        data: [10, 13, 17, 12, 30, 47, 60, 120, 230, 300, 310, 400],
	   
                        fill: true,
                        borderColor: "rgba(49,172,170,0.9)",
                        backgroundColor:[ "#36a2eb","#ff6384","#ff9f40","#ffcd56","#4bc0c0","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
                        //	   borderCapStyle: 'square',
                        //    pointBorderColor: "white",
                        //    pointBackgroundColor: "green",
                        //    pointBorderWidth: 1,
                        //    pointHoverRadius: 8,
                        //    pointHoverBackgroundColor: "yellow",
                        //    pointHoverBorderColor: "green",
                        //    pointHoverBorderWidth: 2,
                        fill: false,
                        pointRadius: 4,
                        pointHitRadius: 10,
                    },]
            },
  
            options: {
                responsive: true,
                legend: {
                    display: false,
                    // position: 'bottom',
                },
		
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: false
                            },
                            scaleLabel: {
                                labelString: 'INR',
                                display: true,
                            },
                        }]
                },
                title: {
                    fontSize: 12,
                    display: true,
                    text: 'Month',
                    position: 'bottom'
                }
            },
  
        };

        var myChart;
        change('bar');
        $("#constituencyPanel #barChartBtn").click(function() {
            change('bar');
        });

        $("#constituencyPanel #pieChartBtn").click(function() {
            change('polarArea');
            //backgroundColor:[ "#ff4243","#ffd13e","#45c27e","#42c4f5","#ff4342","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
  
        });

        $("#constituencyPanel #lineChartBtn").click(function() {
            change('line');
        });

        function change(newType) {
            var ctx = document.getElementById("constituencyDetailsChart").getContext("2d");

            // Remove the old chart and all its event handles
            if (myChart) {
                myChart.destroy();
            }

            // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
            var temp = jQuery.extend(true, {}, config);
            temp.type = newType;
            //temp.type = newType;
            myChart = new Chart(ctx, temp);
        };

    });

</script>





@endsection 
