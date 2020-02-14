@extends('backend.layouts.app')
@section('title', __('labels.backend.course-allotment.title').' | '.app_name())

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
            width: 70%;
        }

        ul.sorter li > span .btn {
            width: 20%;
        }

        @media screen and (max-width: 768px) {

            ul.sorter li > span .btn {
                width: 30%;
            }

            ul.sorter li > span .title {
                padding-left: 15px;
                width: 70%;
                float: left;
                margin: 0 !important;
            }

        }


    </style>
@endpush

@section('content')

    <div class="card">

        <div class="card-header">
            <h3 class="page-title mb-0">@lang('labels.backend.course-allotment.title')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('labels.backend.course-allotment.fields.departmet')</th>
                            <td>
                                @foreach ($departments as $department)
                                    <span class="label label-info label-many">{{ $department }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.course-allotment.fields.track')</th>
                            <td>
                                @foreach ($tracks as $track)
                                    <span class="label label-info label-many">{{ $track }}</span>
                                @endforeach
                            </td>
                        </tr>
 						<tr>
                            <th>@lang('labels.backend.courses.fields.category')</th>
                            <td>
                                @foreach ($categories as $categorie)
                                    <span class="label label-info label-many">{{ $categorie }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.courses.fields.subcategory')</th>
                            <td>
                                @foreach ($subcategories as $subcategorie)
                                    <span class="label label-info label-many">{{ $subcategorie }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Course Level</th>
                            <td>
                                @foreach ($difficulty as $diff)
                                    <span class="label label-info label-many">{{ $diff }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Course</th>
                            <td>
                                @foreach ($courses as $course)
                                    <span class="label label-info label-many">{{ $course }}</span>
                                @endforeach
                            </td>
                        </tr>
                         <tr>
                            <th>Assign To</th>
                            <td>
                                @foreach ($assign_to as $key => $assignto)
                                   @if($course_allotment->assign_to == $key)
                                    <span class="label label-info label-many">{{ $assignto }}</span>
                                   @endif 
                                @endforeach
                            </td>
                        </tr>
                        @if($course_allotment->assign_to == 'individual')
                        <tr>
                            <th>Users</th>
                            <td>
                                @foreach ($deptusers as $key => $deptuser)
                                    <span class="label label-info label-many">{{ $deptuser }}</span>
                                @endforeach
                            </td>
                        </tr>
                        @endif 
                        @if($course_allotment->assign_to == 'group')
                        <tr>
                            <th>Designation</th>
                            <td>
                                @foreach ($designations as $key => $designation)
                                	@if($key > 0 && $key < count($designations))
                                    	,
                                    @endif
                                    <span class="label label-info label-many">{{ $designation }}</span>
                                @endforeach
                            </td>
                        </tr>
                        @endif 
                        <tr>
                            <th>Completion Date</th>
                            <td>
                               <span class="label label-info label-many">{{ $course_allotment->completion_date }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
        </div>
    </div>
@stop