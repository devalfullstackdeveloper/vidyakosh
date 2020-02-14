@extends('backend.layouts.app')
@section('title', __('labels.backend.general_settings.contact.title').' | '.app_name())

@section('content')
   
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h3 class="page-title d-inline">@lang('menus.backend.sidebar.settings.contact')</h3>
                </div>
            </div>
        </div>

        <div class="card-body" id="contact">
NIC e-Learning Services<br/>
Technical Development Programme<br/>
Training Division<br/>
National Informatics Centre<br/>
A-Block, C.G.O Complex<br/>
Lodhi Road<br/>
New Delhi - 110003<br/>
<br/>
Tel: 011-2430-5247/5256<br/>

Email: vidya.kosh@nic.in
        </div>
    </div>

@endsection
