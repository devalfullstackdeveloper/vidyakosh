@extends('backend.layouts.app')
@section('title', __('labels.backend.trainings.upcomming').' | '.app_name())
@section('content')

    <div class="card">
        <div class="card-header">
                <h3 class="page-title d-inline">@lang('labels.backend.trainings.title')</h3>
            @can('course_create')
                <div class="float-right">
                    

                </div>
            @endcan
        </div>
		  <!--filter Box-->
    <?php
        $param = array();
    if (isset($_GET['p']) && $_GET['p'] != "") {
            $param = explode(",", $_GET['p']);
        }
        
        $id = Auth::user()->id;
        $officeLocation = 1;
    if (isset($id)) {
        $user = DB::table('user_details')->where('user_id', $id)->select('office_id')->get();
        if (count($user) > 0) {
            $location = DB::table('locations')->where('id', $user[0]->office_id)->select('parent_office_id', 'state_id')->get();
                $officeLocation = $location[0]->parent_office_id;
                $stateId = $location[0]->state_id;
            }
        }
    ?>
            <div class="filterPanel f-box">
                <div class="row">
                    <div class="col-md-4">
                        <p>Training Filter</p>                
                        <select class="form-control"  name="training_filter">
                    <option value="1" <?php echo isset($param[0]) && $param[0] != "" && $param[0] == 1 ? 'selected' : ''; ?> >Next Week</option>
                    <option value="2" <?php echo isset($param[0]) && $param[0] != "" && $param[0] == 2 ? 'selected' : ''; ?>>Next Month</option>
                    <option value="3" <?php echo isset($param[0]) && $param[0] != "" && $param[0] == 3 ? 'selected' : ''; ?>>Next Quarter</option>
                    <option value="4" <?php echo isset($param[0]) && $param[0] != "" && $param[0] == 4 ? 'selected' : ''; ?>>Full Year</option>
                        </select>
                    </div>
					     <div class="col-md-4">
                        <p>&nbsp;</p>
                <select class="form-control" name="training_filter_2">
                    <option value="0" <?php echo isset($param[1]) && $param[1] != "" && $param[1] == 0 ? 'selected' : ''; ?>>All</option>
                    <option value="1" <?php echo isset($param[1]) && $param[1] != "" && $param[1] == 1 ? 'selected' : ''; ?>>National Training</option>
                    @if($officeLocation == 0)
                    <option value="2" <?php echo isset($param[1]) && $param[1] != "" && $param[1] == 2 ? 'selected' : ''; ?>>HQ Training</option>                           
                    @endif
                    @if($officeLocation != 0)
                    <option value="2" <?php echo isset($param[1]) && $param[1] != "" && $param[1] == 2 ? 'selected' : ''; ?>>State Training</option>    
                    @endif
                        </select>
                    </div>
					     <div class="col-md-4">
                        <p>&nbsp;</p>
                <button type="submit" class="btn btn-success training_filter_btn">Submit</button>
                    </div>
                </div>
            </div>
            <!--filter Box-->
        <div class="card-body">           
          
            <div class="row">  
                <div class="col-12"> 
                    
                    <div class="table-responsive">
                        <div class="d-block">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ route('admin.trainings.index') }}"
                                       style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>
                                </li>
                                |
                                <li class="list-inline-item">
                                    <a href="{{ route('admin.trainings.index') }}?show_deleted=1"
                                       style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.general.trash')}}</a>
                                </li>
                            </ul>
                        </div>

                        <table id="myTable"
                               class="table table-bordered table-striped  dt-select ">
                            <thead>
                            <tr>

                                @can('category_delete')
                                    @if ( request('show_deleted') != 1 )
                                        <th style="text-align:center;"><input type="checkbox" class="mass"
                                                                              id="select-all"/>
                                        </th>@endif
                                @endcan
                                <th>@lang('labels.general.sr_no')</th>
                                <th>@lang('labels.backend.trainings.fields.title')</th>
                                <th>@lang('labels.backend.trainings.fields.venue')</th>
                                <th>@lang('labels.backend.trainings.fields.organized_by')</th>  
                                <th>@lang('labels.backend.trainings.fields.start_date')</th>
                                <th>@lang('labels.backend.trainings.fields.end_date')</th>
                                <th>@lang('labels.backend.trainings.fields.last_nominee')</th>  
                                <th>@lang('labels.backend.trainings.fields.nomination_form')</th>  
                                <th>@lang('strings.backend.general.actions')</th>
                                
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($trainings as $key=>$item)
                            @php $key++ @endphp
                            <tr>
                                <td>
                                    {{ $key }}
                                </td>
                                <td>
                                    {{$item->title}}
                                </td>
                                <td>
                                    {{$item->address}}
                                </td>
                                <td>
                                    {{$item->parent_office_id}}
                                </td>
                                <td>
                                    {{$item->start_date}}
                                </td>
                                <td>
                                    {{$item->end_date}}
                                </td>
                                <td>
                                    {{$item->lastnominne}}
                                </td>
                                <td>
                                    {{$item->training_for}}
                                </td>

                                <td>
                                    <a href="javascript:void(0);" class="btn btn-xs btn-success mb-1" onclick="checkNomination({{$item->id}});">Request for Nomination</a>
<!--                                    <a href="{{url('user/view')}}?trainings={{$item->id}}" class="btn btn-xs btn-warning mb-1">View Detail</a>-->
                                    <a href="javascript:void(0);" class="btn btn-xs btn-warning mb-1 viewDetails" data-id="{{$item->id}}" onclick="viewDetails({{$item->id}});">View Details</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
            <div class="modal-body training-view-modal">

            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-sm nomination_msg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content text-center">
            <div class="modal-body">
                <div class="swal2-icon swal2-warning swal2-animate-warning-icon" style="display: flex;"><span class="swal2-icon-text">!</span></div>
                <h6>Your Nomination is Already Approved in This Date Range.</h6>
            </div>
        </div>
    </div>
</div>

@endsection
<?php
$param1 = 1;
$param2 = 0;
if (isset($_GET['p']) && $_GET['p'] != "") {
    $p = explode(",", $_GET['p']);
    $param1 = $p[0];
    $param2 = $p[1];
}
$filter = $param1 . "," . $param2;
?>
@push('after-scripts')
    <script>

    function checkNomination(id){
        var APP_URL = {!! json_encode(url('/')) !!};
        var url = APP_URL+'/user/nominate?trainings='+id;
        
        $.ajax({
                url: 'check-nomination-ajax/'+id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    if(parseInt(data) > 0){
                        $(".nomination_msg").modal('show');
                    }else{
                        window.location.href = url;
                    }
                    
                }
        });
        console.log(url);
    }
    
    function viewDetails(id){
            $.ajax({
                url: 'crt-details-ajax/'+id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    var html = "";
                    html +='<div class="container-fluid">';
                        html +='<div class="row mb-2">';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Training Title :</label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.title +'</p></div>';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Department : </label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.department_name +'</p></div>';
                        html +='</div>';
                        html +='<div class="row mb-2">';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Description :</label></b></div>';
                            html +='<div class="col-md-10 m-0 p-0"><p>'+ data.description +'</p></div>';
                        html +='</div>';
                        html +='<div class="row mb-2">';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Track :</label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.track +'</p></div>';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Category Name : </label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.category +'</p></div>';
                        html +='</div>';
                        html +='<div class="row mb-2">';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Year :</label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.year +'</p></div>';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>State : </label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.state +'</p></div>';
                        html +='</div>';
                        html +='<div class="row mb-2">';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>City :</label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.city +'</p></div>';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Venue : </label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.venue +'</p></div>';
                        html +='</div>';
                        html +='<div class="row mb-2">';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Designation :</label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.designation +'</p></div>';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Timing : </label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.timing +'</p></div>';
                        html +='</div>';
                        html +='<div class="row mb-2">';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Training For :</label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.training_for +'</p></div>';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Training Type : </label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.training_type +'</p></div>';
                        html +='</div>';
                        html +='<div class="row mb-2">';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Last Nomination :</label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.lastnominne +'</p></div>';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Start Date : </label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.start_date +'</p></div>';
                        html +='</div>';
                        html +='<div class="row mb-2">';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>End Date :</label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.end_date +'</p></div>';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Nomination From Office : </label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.nomination_office +'</p></div>';
                        html +='</div>';
                        html +='<div class="row mb-2">';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Feedback :</label></b></div>';
                            html +='<div class="col-md-4 m-0 p-0"><p>'+ data.feedback +'</p></div>';
                        html +='</div>';
                        html +='<div class="row mb-2">';
                            html +='<div class="col-md-2 m-0 p-0"><b><label>Agenda :</label></b></div>';
                    html +='</div>';
                        html +='<div class="row mb-2">';
                        html += data.agenda;
                        html +='</div>';
                        html +='<div class="row mb-2">';
                            html += '<a href="{{URL::to('/')}}/user/agendaPDF?crt='+data.id+'" class="btn btn-xs btn-success mb-1 viewDetails" data-id="">Download PDF</a>';
                        html +='</div>';
                    html +='</div>';
                    
                    $(".training-view-modal").html(html);
                    $(".crt_details").modal('show');
                }
            });
    }

    $(document).ready(function () {
        
//        $(".viewDetails").click(function(){
//            var id = $(this).attr('data-id');
//            
//
//        });
        
         $(".training_filter_btn").click(function(){
             var trainingFilter = $('select[name="training_filter"]').val();
             var training_filter_2 = $('select[name="training_filter_2"]').val();
                var APP_URL = {!! json_encode(url('/')) !!};
                $.ajax({
                url: APP_URL+'/user/get-trainings-data?filter='+trainingFilter+','+training_filter_2,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            var tableHtml = '';
                    var myTable = $('#myTable').DataTable();
                    myTable.clear();
                            $.each(data.data, function(key, val) {
                        
                        myTable.row.add( [(key + 1), val.title, val.address, val.parent_office_id, val.start_date, val.end_date, val.lastnominne, val.training_for, val.actions] );

                            });
                    $('#myTable tbody').html('');
                    myTable.draw();
                        }
                    });
            });
            
            $('#myTable').DataTable({
                processing: true,
            serverSide: false,
                iDisplayLength: 10,
                retrieve: true,

            
                columnDefs: [
                {"width": "10%", "targets": 0},
                ],
                language:{
                    url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                    buttons :{
                        colvis : '{{trans("datatable.colvis")}}',
                        pdf : '{{trans("datatable.pdf")}}',
                        csv : '{{trans("datatable.csv")}}',
                    }
                }

            });
        
            @if(auth()->user()->isAdmin())
            $('.actions').html('<a href="' + '{{ route('admin.teachers.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
            @endif
        });

    </script>

@endpush