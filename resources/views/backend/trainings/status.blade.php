@extends('backend.layouts.app')
@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/amigo-sorter/css/theme-default.css')}}">
    <style>
        ul.sorter > span {
            display: inline-block;
            width: 100%;
            height: 100%;
            background: #f5f5f5;
            color: #333333;
            border: 1px solid #cccccc;
            border-radius: 6px;
            padding: 0px;
        }

        ul.sorter li > span .title {
            padding-left: 15px;
        }

        ul.sorter li > span .btn {
            width: 20%;
        }


    </style>
@endpush

@section('content') 
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.status.title')</h3>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="myTable"
                               class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th>@lang('labels.general.sr_no')</th>
                                <th>@lang('labels.backend.status.fields.title')</th>
                                <th>@lang('labels.backend.status.fields.venue')</th>
                                <th>@lang('labels.backend.status.fields.organized_by')</th>
                                <th>@lang('labels.backend.status.fields.status')</th>
                                <th>@lang('labels.backend.status.fields.nomination_date')</th>
                                <th>@lang('labels.backend.status.fields.name')</th>
                                <th>Nomination From</th>
                                <th>Action</th>
                       
                             
                            </tr>
                            </thead>
                            <tbody> 
                            @foreach($status as $key=>$item)
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
                                       @if($item->status==1)
                                       <p>Approved</p>
                                       @elseif($item->status==2)
                                       <p>Reject</p>
                                       @else
                                       <p>Pending</p>
                                       @endif
                                    </td>
                                    <td>
                                        {{$item->statusdate}}
                                    </td>
                                    <td>
                                        @if($item->status==3)
                                        -----
                                        @else
                                        {{$item->name}}
                                        @endif
                                    </td>
                                    <td>
                                        {{$item->training_for}}
                                    </td>
                                    <td>
<!--                                        <a href="{{url('user/view')}}?trainings={{$item->crtId}}" class="btn btn-xs btn-warning mb-1">View Detail</a>-->
                                    <a href="javascript:void(0);" class="btn btn-xs btn-warning mb-1 viewDetails" data-id="{{$item->crtId}}">View Detail</a>
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

@endsection

@push('after-scripts')
    <script src="{{asset('plugins/amigo-sorter/js/amigo-sorter.min.js')}}"></script>

    <script>


        $(document).ready(function () {

            $(".viewDetails").click(function(){
            var id = $(this).attr('data-id');
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
        });

        $('ul.sorter').amigoSorter({
            li_helper: "li_helper",
            li_empty: "empty",
        });
    </script>
@endpush

