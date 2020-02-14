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

@stop



