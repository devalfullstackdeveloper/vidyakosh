@extends('backend.layouts.app')
@section('title', __('labels.backend.ministry.title').' | '.app_name())

@section('content')
    <div class="card">
        <div class="card-header">
                <h3 class="page-title d-inline">Feedbacks</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <div class="d-block">
                          
                        </div>


                        <table id="myTable"
                               class="table table-bordered table-striped @if(auth()->user()->isAdmin()) @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                            <thead>
                            <tr>
                                <th>@lang('labels.general.sr_no')</th>
                                <th>Name</th> 
								<th>Email</th>
								<th>Subject</th>
								<th>Feedback</th>
								<th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
								<?php $i=1;?>
								@if(count($UserFeedbacks)>0)
								@foreach($UserFeedbacks as $UserFeedbacksdata)
								<tr>
							    <td>{{$i++}}</td>
								<td>{{$UserFeedbacksdata->name}}</td>
							    <td>{{$UserFeedbacksdata->email}}</td>
									@if($UserFeedbacksdata->subject==1)
									<td>E-Learnings</td>
									@elseif($UserFeedbacksdata->subject==2)
									<td>CRT's</td>
									@elseif($UserFeedbacksdata->subject==3)
									<td>Webinars</td>
									@elseif($UserFeedbacksdata->subject==4)
									<td>Executive Briefings</td>
									@else
									<td>Seminars</td>
									@endif
								
								<td>{{$UserFeedbacksdata->feedback}}</td>
								<td>{{date('d-M-y', strtotime($UserFeedbacksdata->created_at))}}</td>
								</tr>
								@endforeach
								@else
								 <h2 class="">No Feedback</h2>
								@endif
								
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('after-scripts')
   

@endpush