@extends('backend.layouts.app')

@section('title', __('labels.backend.resourcelist.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title ">@lang('labels.backend.resourcelist.title')</h3>
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
                                <th>@lang('labels.backend.resourcelist.fields.resourcetrack')</th>
                                <th>@lang('labels.backend.resourcelist.fields.resourcecat')</th>
                                <th>@lang('labels.backend.resourcelist.fields.resourcetitle')</th>
                                <th>@lang('labels.backend.resourcelist.fields.suggestedby')</th>
                                <th>@lang('labels.backend.resourcelist.fields.resourcetype')</th>
								@if(auth()->user()->isAdmin() || auth()->user()->is_admin == 1)
                                <th>&nbsp; @lang('strings.backend.general.actions')</th>
								@endif
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

@endsection



@push('after-scripts')
<script>

    $(document).ready(function () {
        var route = '{{route('admin.approved.get_approved_data')}}';

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
                {data: "track", name: 'track'}, 
				{data: "category", name: 'category'},
                {data: "subcategory", name: 'subcategory'},
                {data: "courses", name: 'courses'},  
                {data: "name", name: 'name'},     
				@if(auth()->user()->isAdmin() || auth()->user()->is_admin == 1)
                {data: "actions", name: 'actions'}
				@endif
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
        @if(auth()->user()->isAdmin() || auth()->user()->is_admin == 1)
            $('.actions').html('<a href="' + '{{ route('admin.teachers.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
        @endif
    });

</script>

@endpush

