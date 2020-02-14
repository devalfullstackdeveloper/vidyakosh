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
                          <h2 class="font-18">2511</h2>
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
                          <h2 class="font-18">500</h2>
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
                          <h5 class="font-13">Institutes Faculities</h5>
                          <h2 class="font-18">500</h2>
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
                          <h2 class="font-18">2511</h2>
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
                          <h5 class="font-13">Industry Faculties</h5>
                          <h2 class="font-18">2546</h2>
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

 <div class="row">
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
 

    $(document).ready(function(){
  $("button.togglebtn").click(function(){
    $(".togglesection").toggle(1000);
  });
});

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
                            
                    /*For CRT Chart*/
                    var state = new Array();
                    var crtCnt = new Array();
                    var chartArr = jQuery.parseJSON(data.crt_chart);
                    $.each(chartArr, function(key, val) {
                        state.push(key);
                        crtCnt.push(val);
                    });
                            
                    var config = {
                        type: 'bar',
                        data: {
                            labels: state,
                            datasets: [{
                                    label: "Limit",
                                    data: crtCnt,

                                    fill: true,
                                    borderColor: "rgba(49,172,170,0.9)",
                                    backgroundColor: ["#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],
                                    fill: false,
                                    pointRadius: 4,
                                    pointHitRadius: 10,

                                },
                                {
                                    type: 'line',
                                    label: 'B',
                                    // the 1st and last value are placeholders and never get displayed on the chart
                                    // to get a straight line, the 1st and last values must match the same value as
                                    // the next/prev respectively
                                    data: [100, 130, 217, 150, 200, 97, 160, 120, 230, 300, 310, 40, 10, 13, 17, 12, 30, 47, 60, 120, 230, 300, 310, 40],
                                    fill: false,
                                    borderWidth: 3,
                                    borderColor: "rgba(49,172,170,0.9)",
                                    backgroundColor: ["#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],
                                    borderDash: [5, 4],
                                    lineTension: 0,
                                    //steppedLine: true
                                }

                            ]
                        },

                        options: {
                            responsive: true,
                            legend: {
                                display: false,
                                position: 'bottom',
                            },

                            scales: {
                                yAxes: [{
                                        ticks: {
                                            beginAtZero: false
                                        },
                                        scaleLabel: {
                                            labelString: 'ton',
                                            display: true,
                                        },
                                    }]
                            },

                            title: {
                                fontSize: 12,
                                display: true,
                                text: 'States',
                                position: 'bottom'
                            }
                        },

                    };

                    var myChart;
                    change('bar');
                                
                    function change(newType) {
                        //                                    var ctx = document.getElementById("trainingChart").getContext("2d");
                        var ctx = document.getElementById("cetTrainings").getContext("2d");

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
                                
                    /*For ELearning Chart*/
                    var category = new Array();
                    var elCnt = new Array();
                    var chartArr = jQuery.parseJSON(data.eLearning_chart);
                    $.each(chartArr, function(key, val) {
                        category.push(key);
                        elCnt.push(val);
                    });
                            
                    var config1 = {
                        type: 'bar',
                        data: {
                            labels: category,
                            datasets: [{
                                    label: "Limit",
                                    data: elCnt,

                                    fill: true,
                                    borderColor: "rgba(49,172,170,0.9)",
                                    backgroundColor: ["#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],
                                    fill: false,
                                    pointRadius: 4,
                                    pointHitRadius: 10,

                                },
                                {
                                    type: 'line',
                                    label: 'B',
                                    // the 1st and last value are placeholders and never get displayed on the chart
                                    // to get a straight line, the 1st and last values must match the same value as
                                    // the next/prev respectively
                                    data: [100, 130, 217, 150, 200, 97, 160, 120, 230, 300, 310, 40, 10, 13, 17, 12, 30, 47, 60, 120, 230, 300, 310, 40],
                                    fill: false,
                                    borderWidth: 3,
                                    borderColor: "rgba(49,172,170,0.9)",
                                    backgroundColor: ["#36a2eb", "#ff6384", "#ff9f40", "#ffcd56", "#4bc0c0", "#aedb7c", "#9666ba", "#fd9677"],
                                    borderDash: [5, 4],
                                    lineTension: 0,
                                    //steppedLine: true
                                }

                            ]
                        },

                        options: {
                            responsive: true,
                            legend: {
                                display: false,
                                position: 'bottom',
                            },

                            scales: {
                                yAxes: [{
                                        ticks: {
                                            beginAtZero: false
                                        },
                                        scaleLabel: {
                                            labelString: 'ton',
                                            display: true,
                                        },
                                    }]
                            },

                            title: {
                                fontSize: 12,
                                display: true,
                                text: 'States',
                                position: 'bottom'
                            }
                        },

                    };

                    var myChart1;
                    change1('bar');
                                
                    function change1(newType) {
                        //                                    var ctx = document.getElementById("trainingChart").getContext("2d");
                        var ctx = document.getElementById("trainingChart").getContext("2d");

                        // Remove the old chart and all its event handles
                        if (myChart1) {
                            myChart1.destroy();
                        }

                        // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
                        var temp = jQuery.extend(true, {}, config1);
                        temp.type = newType;
                        //temp.type = newType;
                        myChart1 = new Chart(ctx, temp);
                    };

                        
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

@endsection 
