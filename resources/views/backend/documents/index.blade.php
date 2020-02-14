@extends('backend.layouts.app')
@section('title', __('labels.backend.documents.title').' | '.app_name())


@section('content')
<?php
$date = "";
$crt = "";
if (isset($_GET['date'])) {
    $date = $_GET['date'];
}
if (isset($_GET['crt'])) {
    $crt = $_GET['crt'];
}
?>
<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline">@lang('labels.backend.documents.title')</h3>
        @if(auth()->user()->isAdmin() || (auth()->user()->is_admin == 1 && $officeLocation == 0))
        <div class="float-right">
            <a href="{{ route('admin.documents.create',['date'=>$date, 'crt'=>$crt]) }}"
               class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>

        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="row"> 
            <div class="col-12">
                <div class="table-responsive">
                    <div class="d-block">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="{{ route('admin.documents.index') }}"
                                   style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>
                            </li>
                            |
                            <li class="list-inline-item">
                                <a href="{{ route('admin.documents.index') }}?show_deleted=1"
                                   style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.general.trash')}}</a>
                            </li>
                        </ul>
                    </div>


                    <table id="myTable"
                           class="table table-bordered table-striped @if(auth()->user()->isAdmin()) @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                        <thead>
                            <tr>

                                @can('category_delete')
                                @if ( request('show_deleted') != 1 )
                                <th style="text-align:center;"><input type="checkbox" class="mass" id="select-all"/>
                                </th>@endif
                                @endcan

                                <th>@lang('labels.general.sr_no')</th>
                                <th>Agenda Date</th>
                                <th>@lang('labels.backend.documents.fields.type')</th>
                                <th>@lang('labels.backend.documents.fields.description')</th>         									
                                <th>@lang('labels.backend.documents.fields.file')</th>         									
                                @if( request('show_deleted') == 1 )
                                <th>&nbsp; @lang('strings.backend.general.actions')</th>
                                @else
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
<?php
$param = $date.",".$crt;
?>
@push('after-scripts')
<script>

    $(document).ready(function () {
        var route = '{{route('admin.documents.get_data',['param' => $param])}}';

        @if(request('show_deleted') == 1)
            route = '{{route('admin.documents.get_data',['show_deleted' => 1])}}';
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
                @can('category_delete')
                @if(request('show_deleted') != 1)
                {
                    "data": function (data) {
                        return '<input type="checkbox" class="single" name="id[]" value="' + data.id + '" />';
                    }, "orderable": false, "searchable": false, "name": "id"
                },
                @endif
                @endcan
                {data: "DT_RowIndex", name: 'DT_RowIndex'},
                {data: "agenda_date", name: 'agenda_date'}, 
                {data: "type", name: 'type'}, 
                {data: "description", name: 'description'}, 
                {data: "file", name: 'file'},     
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