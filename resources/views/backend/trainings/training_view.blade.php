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
            <h3 class="page-title d-inline">@lang('labels.backend.trainingviews.title')</h3>
        </div>
        <div class="card-body">
			<div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>@lang('labels.backend.trainingviews.fields.title')</th>
			 <th>@lang('labels.backend.trainingviews.fields.deptname')</th>
			 <th>@lang('labels.backend.trainingviews.fields.trackname')</th>
			<th>@lang('labels.backend.trainingviews.fields.category')</th>
			<th>@lang('labels.backend.trainingviews.fields.year')</th>
			<th>@lang('labels.backend.trainingviews.fields.state')</th>
			<th>@lang('labels.backend.trainingviews.fields.city')</th>
			<th>@lang('labels.backend.trainingviews.fields.venue')</th>
			<th>@lang('labels.backend.trainingviews.fields.designation')</th>
			<th>@lang('labels.backend.trainingviews.fields.start')</th>
			<th>@lang('labels.backend.trainingviews.fields.end')</th>
			<th>@lang('labels.backend.trainingviews.fields.nomination')</th>
			<th>@lang('labels.backend.trainingviews.fields.description')</th>
			<th>@lang('labels.backend.trainingviews.fields.time')</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{$crttrainings->title}}</td>
			 <td>{{$crttrainings->department_name}}</td>
			 <td>{{$crttrainings->trackname}}</td>
			 <td>{{$crttrainings->categoryname}}</td>
			<td>{{$crttrainings->yearname}}</td>
			<td>{{$crttrainings->statename}}</td>
			<td>{{$crttrainings->cityname}}</td>
			<td>{{$crttrainings->venu}}</td>
			<td>{{$crttrainings->designationname}}</td>
			<td>{{$crttrainings->startdate}}</td>
			<td>{{$crttrainings->enddate}}</td>
			<td>{{$crttrainings->nominationdate}}</td>
			<td>{{$crttrainings->description}}</td>
			<td>{{$crttrainings->timing}}</td>
        </tr>
      </tbody>
    </table>
  </div>
		
        </div>


@endsection

@push('after-scripts')
    <script src="{{asset('plugins/amigo-sorter/js/amigo-sorter.min.js')}}"></script>

    <script>


        $(document).ready(function () {

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

