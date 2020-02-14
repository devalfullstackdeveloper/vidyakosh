@extends('backend.layouts.app')
@section('title', __('labels.backend.approvals.title').' | '.app_name())
@section('content')

    <div class="card">
        <div class="card-header">
                <h3 class="page-title d-inline">@lang('labels.backend.approvals.title')</h3>
            @can('course_create')
                <div class="float-right">
                   
                </div>
            @endcan
        </div>
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
                                <th>@lang('labels.backend.approvals.fields.title')</th>
                                <th>Venue</th>
                                <th>To be Organised by</th>
                                <th>@lang('labels.backend.approvals.fields.nomination_date')</th>
                                <th>@lang('labels.backend.approvals.fields.name')</th>
                                <th>Nomination From</th>
                                <th>@lang('strings.backend.general.actions')</th>
                                
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
    <script>
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
            
            var route = '{{route('admin.trainings.getApproved')}}';

            @if(request('show_deleted') == 1)
                route = '{{route('admin.trainings.getApproved',['show_deleted' => 1])}}';
            @endif

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5 ]

                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5 ]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                    {data: "DT_RowIndex", name: 'DT_RowIndex'},
                    {data: "title", name: 'title'},
                    {data: "address", name: 'address'},
                    {data: "parent_office_id", name: 'parent_office_id'},
                    {data: "statusdate", name: 'statusdate'},  
                    {data: "name", name: 'name'}, 
                    {data: "training_for", name: 'training_for'}, 
                    {data: "actions", name: 'actions'}
                ],
                @if(request('show_deleted') != 1)
                columnDefs: [
                    {"width": "5%", "targets": 0},
                    {"className": "text-center", "targets": [0]}
                ],
                @endif

                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-entry-id', data.id);
                },
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