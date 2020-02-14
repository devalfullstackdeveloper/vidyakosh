@extends('backend.layouts.app')

@section('title', __('labels.backend.peercompstatus.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title ">@lang('labels.backend.peercompstatus.title')</h3>
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
                                <th>@lang('labels.backend.peercompstatus.fields.officer_name')</th>
                                <th>@lang('labels.backend.peercompstatus.fields.place_postong')</th>
                                <th>@lang('labels.backend.peercompstatus.fields.email')</th>
                                <th>@lang('labels.backend.peercompstatus.fields.no_course')</th>
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
	
	
<!-- The Modal -->
<div class="modal" id="myModal">
	<div class="modal-dialog">
	  <div class="modal-content">
	  
		<!-- Modal Header -->
		<div class="modal-header">
		  <h4 class="modal-title">COURSE COMPLETED</h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		
		<!-- Modal body -->
		<div class="modal-body">
		  
		</div>
		
		<!-- Modal footer -->
		<div class="modal-footer">
		  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		</div>
		
	  </div>
	</div>
</div>

@endsection




@push('after-scripts')
<script>

    $(document).ready(function () {
        var route = '{{route('admin.peercompstatus.get_data')}}';

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
                {data: "first_name", name: 'first_name'}, 
                {data: "office_name", name: 'office_name'}, 
				{data: "email", name: 'email'}, 
                {data: "no_course", name: 'no_course'}
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
		
		
		
        oncourse_count_click = function(element) {
			var element_content = $(element).attr('data-element');
			$.ajax({
				url: 'peercompstatus/course-ajax/'+element_content,
				type: "GET",
				dataType: "json",
				before_send: function (){
					$('.modal-body').html('Please wait...');
				},
				success:function(data) {
					var table = $('<table class="table table-bordered table-striped " />');
					table.append( '<tr><th>S.No</th><th>Course Name</th></tr>' );
					var i = 1;
					$.each( data, function( key, value ) {
						table.append( '<tr><td>' + i + '</td><td>' + value['title'] + '</td></tr>' );
						i++;
					});
					$('.modal-body').html(table);
				}
			});
        }
        
    });

</script>

@endpush