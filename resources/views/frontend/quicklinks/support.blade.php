@extends('frontend.layouts.app'.config('theme_layout'))
@section('title', 'Support | '. app_name() )
@push('after-styles')
@endpush
@section('content')
<section class="breadcrumb-area">
      <div class="inner_home_icon">
                        <a href="{{url('/')}}">
                        <i class="fa fa-home"></i>
                    </a>
                    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content">
                    <h2 class="breadcrumb__title">Support</h2> 
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
