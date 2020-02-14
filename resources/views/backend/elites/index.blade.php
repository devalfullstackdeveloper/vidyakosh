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

<div class="tracks">
    <ul>
        <li><a href="#track1" onclick="changeTab('CRT','{{$deptRole}}');">CRT</a></li>
        <li><a href="#track2" onclick="changeTab('E-learning','{{$deptRole}}');">E-learning</a></li>
        <li><a href="#track3" onclick="changeTab('Seminar','{{$deptRole}}');">Seminar</a></li>  
        <li><a href="#track4" onclick="changeTab('Executive-Briefing','{{$deptRole}}');">Executive Briefing</a></li>  
        <li><a href="#track5" onclick="changeTab('Tabular-Report','{{$deptRole}}');">Tabular Report</a></li>  
    </ul>

    <div class="tabContainer">
        <div id="track1"  class="tabtrackContent">
            @if($deptRole == "DG")
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-1 mt-4">
                <div class="row">
                    <div class="sliderBoxItems" style="padding-top:0 !important;" id="level-1-box">

                        <!--01-->
                        <div class="col-12  environmentColorBox showBox-1 boxTab" onmouseenter="boxTabs(7,'CRT');" data-id ="7">
                            <div class="environmentBox" id="box1">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$hogCount}}</h3>
                                <span>HOG</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=7,1,CRT">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                        <!--01-->
                        <div class="col-12 environmentColorBox showBox-2 boxTab" onmouseenter="boxTabs(8,'CRT');" data-id ="9">
                            <div class="environmentBox" id="box2">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$hodCount}}</h3>
                                <span>HOD</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=8,1,CRT">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                        <!--01-->
                        <div class="col-12  environmentColorBox showBox-3 boxTab" onmouseenter="boxTabs(9,'CRT');" data-id ="13">
                            <div class="environmentBox" id="box3">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$sioCount}}</h3>
                                <span>SIO</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=9,1,CRT">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                        <!--01-->
                        <div class="col-12  environmentColorBox showBox-3 boxTab" onmouseenter="boxTabs(13,'CRT');" data-id ="13">
                            <div class="environmentBox" id="box4">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$scoCount}}</h3>
                                <span>SCO</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=13,1,CRT">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                    </div>
                </div>
            </div>
            @endif
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-2 mt-4">
                <div class="row level-2-box" id="">
                    <div class="sliderBoxItems" style="padding-top:0 !important;">
                        @if(count($deptroleArr) > 0)
                        <div class="col-12 environmentColorBox showBox-3 boxTab" onmouseenter="boxTabs1({{$deptroleArr['crt']['dept_role']}},{{$deptroleArr['crt']['user_id']}},'CRT');" data-id ="{{$deptroleArr['crt']['dept_role']}}">
                            <div class="environmentBox" id="box4">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$deptroleArr['crt']['count']}}</h3>
                                <span>{{$deptroleArr['crt']['name']}}</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id={{$deptroleArr['crt']['user_id']}},2,CRT">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-3 mt-4">
                <div class="row level-3-box" id="">
                    <div class="sliderBoxItems" style="padding-top:0 !important;"></div>
                </div>
            </div>
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-4 mt-4">
                <div class="row level-4-box" id="">
                    <div class="sliderBoxItems" style="padding-top:0 !important;"></div>
                </div>
            </div>
        </div>
        <div id="track2"  class="tabtrackContent">
            @if($deptRole == "DG")
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-1 mt-4">
                <div class="row">
                    <div class="sliderBoxItems" style="padding-top:0 !important;" id="level-1-box">

                        <!--01-->
                        <div class="col-12  environmentColorBox showBox-1 boxTab" onmouseenter="boxTabs(7,'E-learning');" data-id ="7">
                            <div class="environmentBox" id="box1">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$hogElearningCount}}</h3>
                                <span>HOG</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=7,1,E-learning">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                        <!--01-->
                        <div class="col-12 environmentColorBox showBox-2 boxTab" onmouseenter="boxTabs(8,'E-learning');" data-id ="9">
                            <div class="environmentBox" id="box2">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$hodElearningCount}}</h3>
                                <span>HOD</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=8,1,E-learning">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                        <!--01-->
                        <div class="col-12  environmentColorBox showBox-3 boxTab" onmouseenter="boxTabs(9,'E-learning');" data-id ="13">
                            <div class="environmentBox" id="box3">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$sioElearningCount}}</h3>
                                <span>SIO</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=9,1,E-learning">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                        <!--01-->
                        <div class="col-12  environmentColorBox showBox-3 boxTab" onmouseenter="boxTabs(13,'E-learning');" data-id ="13">
                            <div class="environmentBox" id="box4">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$scoElearningCount}}</h3>
                                <span>SCO</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=13,1,E-learning">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                    </div>
                </div>
            </div>
            @endif
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-2 mt-4">
                <div class="row level-2-box" id="">
                    <div class="sliderBoxItems" style="padding-top:0 !important;">
                        @if(count($deptroleArr) > 0)
                        <div class="col-12 environmentColorBox showBox-3 boxTab" onmouseenter="boxTabs1({{$deptroleArr['e_learning']['dept_role']}},{{$deptroleArr['e_learning']['user_id']}},'E-learning');" data-id ="{{$deptroleArr['e_learning']['dept_role']}}">
                            <div class="environmentBox" id="box4">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$deptroleArr['e_learning']['count']}}</h3>
                                <span>{{$deptroleArr['e_learning']['name']}}</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id={{$deptroleArr['e_learning']['user_id']}},2,E-learning">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-3 mt-4">
                <div class="row level-3-box" id="">
                    <div class="sliderBoxItems" style="padding-top:0 !important;"></div>
                </div>
            </div>
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-4 mt-4">
                <div class="row level-4-box" id="">
                    <div class="sliderBoxItems" style="padding-top:0 !important;"></div>
                </div>
            </div>
        </div>
        <div id="track3"  class="tabtrackContent">
            @if($deptRole == "DG")
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-1 mt-4">
                <div class="row">
                    <div class="sliderBoxItems" style="padding-top:0 !important;" id="level-1-box">

                        <!--01-->
                        <div class="col-12  environmentColorBox showBox-1 boxTab" onmouseenter="boxTabs(7,'seminar');" data-id ="7">
                            <div class="environmentBox" id="box1">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$hogSeminarCount}}</h3>
                                <span>HOG</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=7,1,seminar">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                        <!--01-->
                        <div class="col-12 environmentColorBox showBox-2 boxTab" onmouseenter="boxTabs(8,'seminar');" data-id ="9">
                            <div class="environmentBox" id="box2">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$hodSeminarCount}}</h3>
                                <span>HOD</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=8,1,seminar">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                        <!--01-->
                        <div class="col-12  environmentColorBox showBox-3 boxTab" onmouseenter="boxTabs(9,'seminar');" data-id ="13">
                            <div class="environmentBox" id="box3">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$sioSeminarCount}}</h3>
                                <span>SIO</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=9,1,seminar">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                        <!--01-->
                        <div class="col-12  environmentColorBox showBox-3 boxTab" onmouseenter="boxTabs(13,'seminar');" data-id ="13">
                            <div class="environmentBox" id="box4">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$scoSeminarCount}}</h3>
                                <span>SCO</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=13,1,seminar">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                    </div>
                </div>
            </div>
            @endif
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-2 mt-4">
                <div class="row level-2-box" id="">
                    <div class="sliderBoxItems" style="padding-top:0 !important;">
                        @if(count($deptroleArr) > 0)
                        <div class="col-12 environmentColorBox showBox-3 boxTab" onmouseenter="boxTabs1({{$deptroleArr['seminar']['dept_role']}},{{$deptroleArr['seminar']['user_id']}},'seminar');" data-id ="{{$deptroleArr['seminar']['dept_role']}}">
                            <div class="environmentBox" id="box4">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$deptroleArr['seminar']['count']}}</h3>
                                <span>{{$deptroleArr['seminar']['name']}}</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id={{$deptroleArr['seminar']['user_id']}},2,seminar">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-3 mt-4">
                <div class="row level-3-box" id="">
                    <div class="sliderBoxItems" style="padding-top:0 !important;"></div>
                </div>
            </div>
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-4 mt-4">
                <div class="row level-4-box" id="">
                    <div class="sliderBoxItems" style="padding-top:0 !important;"></div>
                </div>
            </div>
        </div> 
        <div id="track4"  class="tabtrackContent">
            @if($deptRole == "DG")
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-1 mt-4">
                <div class="row">
                    <div class="sliderBoxItems" style="padding-top:0 !important;" id="level-1-box">

                        <!--01-->
                        <div class="col-12  environmentColorBox showBox-1 boxTab" onmouseenter="boxTabs(7,'Executive-Briefing');" data-id ="7">
                            <div class="environmentBox" id="box1">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$hogExecutiveBriefingCount}}</h3>
                                <span>HOG</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=7,1,Executive-Briefing">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                        <!--01-->
                        <div class="col-12 environmentColorBox showBox-2 boxTab" onmouseenter="boxTabs(8,'Executive-Briefing');" data-id ="9">
                            <div class="environmentBox" id="box2">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$hodExecutiveBriefingCount}}</h3>
                                <span>HOD</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=8,1,Executive-Briefing">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                        <!--01-->
                        <div class="col-12  environmentColorBox showBox-3 boxTab" onmouseenter="boxTabs(9,'Executive-Briefing');" data-id ="13">
                            <div class="environmentBox" id="box3">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$sioExecutiveBriefingCount}}</h3>
                                <span>SIO</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=9,1,Executive-Briefing">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                        <!--01-->
                        <div class="col-12  environmentColorBox showBox-3 boxTab" onmouseenter="boxTabs(13,'Executive-Briefing');" data-id ="13">
                            <div class="environmentBox" id="box4">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$scoExecutiveBriefingCount}}</h3>
                                <span>SCO</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=13,1,Executive-Briefing">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <!--01-->
                    </div>
                </div>
            </div>
            @endif
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-2 mt-4">
                <div class="row level-2-box" id="">
                    <div class="sliderBoxItems" style="padding-top:0 !important;">
                        @if(count($deptroleArr) > 0)
                        <div class="col-12 environmentColorBox showBox-3 boxTab" onmouseenter="boxTabs1({{$deptroleArr['executive_briefing']['dept_role']}},{{$deptroleArr['executive_briefing']['user_id']}},'Executive-Briefing');" data-id ="{{$deptroleArr['executive_briefing']['dept_role']}}">
                            <div class="environmentBox" id="box4">
                                <i class="fa fa-times-circle-o"></i>
                                <h3>{{$deptroleArr['executive_briefing']['count']}}</h3>
                                <span>{{$deptroleArr['executive_briefing']['name']}}</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id={{$deptroleArr['executive_briefing']['user_id']}},2,Executive-Briefing">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-3 mt-4">
                <div class="row level-3-box" id="">
                    <div class="sliderBoxItems" style="padding-top:0 !important;"></div>
                </div>
            </div>
            <div class="environmentSection environmentHoverPanel showBoxPanel-1 level-4 mt-4">
                <div class="row level-4-box" id="">
                    <div class="sliderBoxItems" style="padding-top:0 !important;"></div>
                </div>
            </div>
        </div>
        <div id="track5"  class="tabtrackContent">
            <div class="filterPanelSt">
                <div class="row mb-2"> 
                    <!--01-->
                    <div class="col-xs-12 col-md-1 filtBg">Filter by</div>
                    <!--./01--> 
                    <div class="col vMiddle">
                        <div class="form-group">
                            {!! Form::select('department_role', $departmentRole, old('department_role'), ['class' => 'form-control js-example-placeholder-single', 'multiple' => false, 'required']) !!}
<!--                            <select class="form-control" name="department_role">
                                <option value="">Department</option>
                            </select>-->
    </div>
                    </div>
                    <!--/01-->
                    <div class="col vMiddle">
                        <div class="form-group">
                            {!! Form::select('designation', $designation, old('designation'), ['class' => 'form-control js-example-placeholder-single', 'multiple' => false, 'required']) !!}
<!--                            <select class="form-control" name="designation">
                                <option value="">Designation</option>
                            </select>-->
                        </div>
                    </div>
                    <!--/01-->  
                    <!--/01-->
                    <div class="col vMiddle">
                        <div class="form-group">
                            {!! Form::select('state', $state, old('state'), ['class' => 'form-control js-example-placeholder-single', 'multiple' => false, 'required']) !!}
<!--                            <select class="form-control" name="state">
                                <option value="">State</option>
                            </select>-->
                        </div>
                    </div>
                    <!--/01-->  
                    <!--/01-->
                    <div class="col vMiddle">
                        <div class="form-group">
                            {!! Form::select('training_type', $trainingTypes, old('training_type'), ['class' => 'form-control js-example-placeholder-single', 'multiple' => false, 'required']) !!}
<!--                            <select class="form-control" name="training_type">
                                <option value="">Training Type</option>
                            </select>-->
                        </div>
                    </div>
                    <!--/01-->  
                    <!--/01-->
                    <div class="col vMiddle text-left">
                        <button type="submit" class="btn btn-success filterBtn">Go</button>
                        &nbsp; &nbsp; <a href="javascript:void(0);" class="btn btn-info" onclick="reset();">Reset</a> </div>
                    <!--/01--> 
                </div>
                <div class="environmentSection environmentHoverPanel showBoxPanel-1 mt-4">
                <div class="row">
                    <div class="sliderBoxItems" style="padding-top:0 !important;" id="level-1-box">
                        <!--01-->
                        <div class="col-12  environmentColorBox showBox-1 boxTab">
                            <div class="environmentBox" id="box1">
                                <i class="fa fa-times-circle-o"></i>
                                <h3 id="tabularCrtCnt">0</h3>
                                <span>CRT Trainings</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=7,1,Executive-Briefing">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <div class="col-12  environmentColorBox showBox-1 boxTab">
                            <div class="environmentBox" id="box1">
                                <i class="fa fa-times-circle-o"></i>
                                <h3 id="tabularSeminarCnt">0</h3>
                                <span>Seminar</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=7,1,Executive-Briefing">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <div class="col-12  environmentColorBox showBox-1 boxTab">
                            <div class="environmentBox" id="box1">
                                <i class="fa fa-times-circle-o"></i>
                                <h3 id="tabularExeBriefCnt">0</h3>
                                <span>Executive Breifing</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=7,1,Executive-Briefing">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <div class="col-12  environmentColorBox showBox-1 boxTab">
                            <div class="environmentBox" id="box1">
                                <i class="fa fa-times-circle-o"></i>
                                <h3 id="tabularWebinarCnt">0</h3>
                                <span>Webinar</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=7,1,Executive-Briefing">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                        <div class="col-12  environmentColorBox showBox-1 boxTab">
                            <div class="environmentBox" id="box1">
                                <i class="fa fa-times-circle-o"></i>
                                <h3 id="tabularElearningCnt">0</h3>
                                <span>E-Learnings</span>
                                <a href="{{url('user/elitedashboard_chart')}}?id=7,1,Executive-Briefing">More Info <i class="fa fa-arrow-right"></i></a>   
                            </div>
                        </div>
                    </div>
                </div>
                        
                <div class="row mt-2">
                    <div class="col-lg-12">
                        <table id="tabular_report_table" class="table table-bordered table-striped  dt-select ">
                            <thead>
                                <tr>
                                    <th>@lang('labels.general.sr_no')</th>
                                    <th>Employee Code</th>
                                    <th>Name</th>
                                    <th>Designation</th>  
                                    <th>Department</th>
                                    <th>CRT Trainings</th>
                                    <th>Seminar</th>
                                    <th>Executive Breifing</th>
                                    <th>Webinar</th>
                                    <th>E-Learnings</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div>

    <div class="tabContainer">


    </div>

</div> 

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
    
    function boxTabs(id, tab){
        var level = 1;
        var uid = 0;
        $.ajax({
            url: 'eliteTab-ajax/'+id+","+level+","+uid+","+tab,
            type: "GET",
            dataType: "json",
            success:function(data) {
                $(".level-2").show();
                $(".level-3").hide();
                $(".level-4").hide();
                $('.level-2-box').html('<div class="sliderBoxItems sliderBoxItems-lvl-2" id="testing" style="padding-top:0 !important;"></div>');
                $.each(data, function(key, value) {
                    var html = '';
                    html +='<div class="col-12 environmentColorBox showBox-1 boxTab" onmouseenter="boxTabs1('+value.dept_role+','+key+',\''+value.tab+'\');" data-id="'+value.dept_role+'">';
                    html +='<div class="environmentBox">';
                    html +='<i class="fa fa-times-circle-o"></i>';
                    html +='<h3>'+value.count+'</h3>';
                    html +='<span>'+value.name+'</span>';
                    html +='<a href="{{url('user/elitedashboard_chart')}}?id='+key+',2,'+tab+'">More Info <i class="fa fa-arrow-right"></i></a>';   
                    html +='</div>';
                    html +='</div>';
                    $(".sliderBoxItems-lvl-2").append(html);
                });
                var owl = $(".sliderBoxItems-lvl-2");
                owl.owlCarousel({
                    items :4,
                    itemsDesktopSmall : [1024, 2],
                    itemsTablet : [768, 2],
                    itemsTabletSmall : [640, 2],
                    itemsMobile : [480, 1],
                    lazyLoad : true,
                    navigation : true,
                    pagination : false,
                    autoPlay : false
                });
            }
        });
    }
    
    function boxTabs1(id,uid,tab){
        var level = 2;
        $.ajax({
            url: 'eliteTab-ajax/'+id+","+level+","+uid+","+tab,
            type: "GET",
            dataType: "json",
            success:function(data) {
                $(".level-3").show();
                $(".level-4").hide();
                $('.level-3-box').html('<div class="sliderBoxItems sliderBoxItems-lvl-3" style="padding-top:0 !important;"></div>');
                $.each(data, function(key, value) {
                    var html = '';
                    html +='<div class="col-12 environmentColorBox showBox-1 boxTab" onmouseenter="boxTabs2('+value.dept_role+','+key+',\''+value.tab+'\');" data-id="'+value.dept_role+'">';
                    html +='<div class="environmentBox">';
                    html +='<i class="fa fa-times-circle-o"></i>';
                    html +='<h3>'+value.count+'</h3>';
                    html +='<span>'+value.name+'</span>';
                    html +='<a href="{{url('user/elitedashboard_chart')}}?id='+key+',2,'+tab+'">More Info <i class="fa fa-arrow-right"></i></a>';   
                    html +='</div>';
                    html +='</div>';
                    $(".sliderBoxItems-lvl-3").append(html);
                });
                var owl = $(".sliderBoxItems-lvl-3");
                owl.owlCarousel({
                    items :4,
                    itemsDesktopSmall : [1024, 2],
                    itemsTablet : [768, 2],
                    itemsTabletSmall : [640, 2],
                    itemsMobile : [480, 1],
                    lazyLoad : true,
                    navigation : true,
                    pagination : false,
                    autoPlay : false
                });
            }
        });
    }
    function boxTabs2(id,uid,tab){
        var level = 2;
        $.ajax({
            url: 'eliteTab-ajax/'+id+","+level+","+uid+","+tab,
            type: "GET",
            dataType: "json",
            success:function(data) {
                $(".level-4").show();
                $('.level-4-box').html('<div class="sliderBoxItems sliderBoxItems-lvl-4" style="padding-top:0 !important;"></div>');
                $.each(data, function(key, value) {
                    var html = '';
//                    html +='<div class="col-12 environmentColorBox showBox-1 boxTab" onmouseenter="boxTabs1('+value.dept_role+','+key+',\''+value.tab+'\');" data-id="'+value.dept_role+'">';
                    html +='<div class="col-12 environmentColorBox showBox-1 boxTab" data-id="'+value.dept_role+'">';
                    html +='<div class="environmentBox">';
                    html +='<i class="fa fa-times-circle-o"></i>';
                    html +='<h3>'+value.count+'</h3>';
                    html +='<span>'+value.name+'</span>';
                    html +='<a href="{{url('user/elitedashboard_chart')}}?id='+key+',2,'+tab+'">More Info <i class="fa fa-arrow-right"></i></a>';   
                    html +='</div>';
                    html +='</div>';
                    $(".sliderBoxItems-lvl-4").append(html);
                });
                var owl = $(".sliderBoxItems-lvl-4");
                owl.owlCarousel({
                    items :4,
                    itemsDesktopSmall : [1024, 2],
                    itemsTablet : [768, 2],
                    itemsTabletSmall : [640, 2],
                    itemsMobile : [480, 1],
                    lazyLoad : true,
                    navigation : true,
                    pagination : false,
                    autoPlay : false
                });
            }
        });
    }
    
    function changeTab(tab, deptRole){
    console.log(deptRole);
    if(deptRole == 'DG'){
        $(".level-1").show();
        $(".level-2").hide();
        $(".level-3").hide();
        $(".level-4").hide();
    }
    if(deptRole == 'HOG'){
        $(".level-1").hide();
        $(".level-2").show();
        $(".level-3").hide();
        $(".level-4").hide();
    }
    if(deptRole == 'HOD'){
        $(".level-1").hide();
        $(".level-2").show();
        $(".level-3").hide();
        $(".level-4").hide();
    }
    if(deptRole == 'EMP'){
        $(".level-1").hide();
        $(".level-2").show();
        $(".level-3").hide();
        $(".level-4").show();
    }
    }
    function reset(){
        $('select[name="department_role"]').val("");
        $('select[name="designation"]').val("");
        $('select[name="state"]').val("");
         $('select[name="training_type"]').val("");
    }
    
    
    
    $(document).ready(function(){
        $(".filterBtn").click(function(){
            var deptRole = $('select[name="department_role"]').val();
            var designation = $('select[name="designation"]').val();
            var state = $('select[name="state"]').val();
            var trainingType = $('select[name="training_type"]').val();
            $.ajax({
//                url: 'tabularReport-ajax/',
                url: 'tabularReport-data/',
                type: "GET",
                data: {
                  'deptRole' : deptRole,  
                  'designation' : designation, 
                  'state' : state,  
                  'trainingType' : trainingType  
                },
                dataType: "json",
                success:function(data) {
                    var myTable = $('#tabular_report_table').DataTable();
                    myTable.clear();
                    var i = 0;
                    $.each(data.tabular_data, function(key, val) {
                        console.log(val);
                        myTable.row.add( [(i + 1), val.emp_code, val.user_name, val.designation, val.department, val.crt, val.seminar, val.executive_breifing, val.webinar, val.e_learning] );
                        i = i + 1;
                    });
                    $('#tabular_report_table tbody').html('');
                    myTable.draw();
                    $("#tabularCrtCnt").html(data.crt_cnt);
                    $("#tabularSeminarCnt").html(data.seminar_cnt);
                    $("#tabularExeBriefCnt").html(data.exeBrief_cnt);
                    $("#tabularWebinarCnt").html(data.webinar_cnt);
                    $("#tabularElearningCnt").html(data.elearning_cnt);
                }
            });
        });
    });
    
</script>
@endsection
