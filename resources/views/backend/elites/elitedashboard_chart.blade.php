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
<?php
    $param = explode(",", $_GET['id']);
    $id = $param[0];
    $level = $param[1];
    $tab = $param[2];
?>
<div class="row mt-4">	
    <!---graph 1-->
    <div class="col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-tittle" id="schoolCollagePanel"> Chart 1</div>
            <div class="card-body">			  
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>

                <canvas id="WebinarChartSt-5" class="chartjs-render-monitor" width="479" height="255" style="display: block; width: 479px; height: 255px;"></canvas>
            </div>
        </div>
    </div>
    <!---./graph 1-->
    <!---graph 2-->
    <div class="col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-tittle" id="schoolCollagePanel"> Chart 2</div>
            <div class="card-body">			  
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>

                <canvas id="opportunitiesChart-A" class="chartjs-render-monitor" width="479" height="255" style="display: block; width: 479px; height: 255px;"></canvas>
            </div>
        </div>
    </div>
    <!---./graph 2-->

</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="card chart1_table">
            <div class="card-body">
                <table id="chart1Table" class="table table-bordered table-striped  dt-select ">
                    <thead>
                        <tr>
                            <th>@lang('labels.general.sr_no')</th>
                            <th>Employee Code</th>
                            <th>Name</th>
                            <th>Designation</th>  
                            <th>Department</th>
                            <th>Total <?php echo $tab; ?></th>
                        </tr>
                    </thead>
                    <tbody>                
                        <?php $sr = 1; ?>
                        @foreach($chart1Arr AS $chart1)
                        <tr>
                            <td><?php echo $sr; ?></td>
                            <td><?php echo $chart1['emp_code']; ?></td>
                            <td><?php echo $chart1['name']; ?></td>
                            <td><?php echo $chart1['designation']; ?></td>  
                            <td><?php echo $chart1['department']; ?></td>
                            <td><a href="javascript:void(0);" onclick=userCrt(<?php echo $chart1['id']; ?>,<?php echo "'".$tab."'"; ?>)><?php echo $chart1['total_crt']; ?></a></td>
                        </tr>
                        <?php $sr = $sr + 1; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if($tab == "E-learning")
    <div class="col-sm-12 col-lg-12 ">
        <div class="card chart1_table_crt d-none">
            <div class="card-body">
                <div class="card-tittle" id="chart-title-1"></div>
                <table id="chart1TableCrt" class="table table-bordered table-striped  dt-select ">
                    <thead>
                        <tr>
                            <th>@lang('labels.general.sr_no')</th>
                            <th>Title</th>
                        </tr>
                    </thead>
                    <tbody>                
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-sm-12 col-lg-12 ">
        <div class="card chart1_table_crt d-none">
            <div class="card-body">
                <div class="card-tittle" id="chart-title-1"></div>
                <table id="chart1TableCrt" class="table table-bordered table-striped  dt-select ">
                    <thead>
                        <tr>
                            <th>@lang('labels.general.sr_no')</th>
                            <th>Title</th>
                            <th>Duration</th>
                            <th>Venue</th>  
                        </tr>
                    </thead>
                    <tbody>                
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

<!--Chart 2-->
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="card chart2_table">
            <div class="card-body">
                <table id="chart2Table" class="table table-bordered table-striped  dt-select ">
                    <thead>
                        <tr>
                            <th>@lang('labels.general.sr_no')</th>
                            <th>Name</th>
                            @foreach($categories as $cat)
                                <th><?php echo $cat; ?></th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>                
                        <?php $sr = 1; ?>
                        @foreach($chart2Arr AS $chart2)
                            <tr>
                                <td><?php echo $sr; ?></td>
                            <?php $i = 1; ?>
                            @foreach($chart2 AS $k => $val)
                                @if($k != "id" && $k != "emp_code" && $k != "department" && $k != "designation")
                                    @if($i > 5)
                                        <?php
                                            $cat = str_replace("_", "", $k);
                                        ?>
                                        <td><a href="javascript:void(0);" onclick=userCrt2(<?php echo $chart2['id']; ?>,<?php echo $cat; ?>,<?php echo "'".$tab."'"; ?>);><?php echo $val; ?></a></td>
                                    @else
                                        <td><?php echo $val; ?></td>
                                    @endif
                                @endif
                                <?php $i = $i + 1; ?>
                            @endforeach
                            </tr>
                        <?php $sr = $sr + 1; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if($tab == "E-learning")
    <div class="col-sm-12 col-lg-12">
        <div class="card chart2_table_crt d-none">
            <div class="card-tittle" id="chart-title-2"></div>
            <div class="card-body">
                <table id="chart2TableCrt" class="table table-bordered table-striped  dt-select ">
                    <thead>
                        <tr>
                            <th>@lang('labels.general.sr_no')</th>
                            <th>Title</th>
                        </tr>
                    </thead>
                    <tbody>                
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-sm-12 col-lg-12">
        <div class="card chart2_table_crt d-none">
            <div class="card-tittle" id="chart-title-2"></div>
            <div class="card-body">
                <table id="chart2TableCrt" class="table table-bordered table-striped  dt-select ">
                    <thead>
                        <tr>
                            <th>@lang('labels.general.sr_no')</th>
                            <th>Title</th>
                            <th>Duration</th>
                            <th>Venue</th>  
                        </tr>
                    </thead>
                    <tbody>                
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

    <!-- Modal -->
    <div class="modal fade" id="opportunitiesChartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">List Of Trainings Completed</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <th>Title</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                        <tr>
                            <td>Software Development</td>
                            <td>12-02-2020</td>
                            <td>20-02-2020</td>
                        </tr>
                        <tr>
                            <td>Internet & N/W</td>
                            <td>12-02-2020</td>
                            <td>20-02-2020</td>
                        </tr>
                        <tr>
                            <td>Sys Adm.</td>
                            <td>12-02-2020</td>
                            <td>20-02-2020</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg chart_1_detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Training View</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body chart1-training-modal">
                    
                </div>
            </div>
        </div>
    </div>
    @endsection

