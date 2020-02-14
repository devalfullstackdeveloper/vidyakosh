@extends('frontend.layouts.app'.config('theme_layout'))
@section('title', 'Beneficiaries | '.app_name())
@section('meta_description', '')
@section('meta_keywords','')


@push('after-styles')
    <style>
        /*.address-details.ul-li-block{*/
        /*line-height: 60px;*/
        /*}*/
        .teacher-img-content .teacher-social-name{
            max-width: 67px;
        }
        .my-alert{
            position: absolute;
            z-index: 10;
            left: 0;
            right: 0;
            top: 25%;
            width: 50%;
            margin: auto;
            display: inline-block; 
        } 
    #ticker01{
      overflow: hidden;
    }
    </style>
@endpush

@section('content')

    <!-- Start of breadcrumb section
        ============================================= -->
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
                    <h2 class="breadcrumb__title">Beneficiaries </h2>
				</div>
				</div>
	 </div>
       </div> 
    </section> 
    <!-- End of breadcrumb section
        ============================================= -->



<section class="slider-area zIn-9999 bgGray">
  <div class="homepage-slide1"> 
      <div class="container">
      <!--<div class="closeBox"><a href="{{url('/')}}">x</a></div>-->
        <div class="BeneficiariesBox">
    <!--  <h2>Beneficiaries</h2> -->     
      
      <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-tittle" id="schoolCollagePanel"> Growth Path 
       <!-- <span>
          <span class="chartIcon"><img src="{{asset('assets/images/icon/line.svg')}}" id="lineChartBtn"></span> 
          <span class="chartIcon"><img src="{{asset('assets/images/icon/bar-chart.svg')}}" id="barChartBtn"></span> 
          <span class="chartIcon"><img src="{{asset('assets/images/icon/filter.svg')}}" class="filterBtn-1"></span>
        </span>-->
			  <span>				
			  <select class="form-control" name="training_filter">
                            <option value="1">HOG</option>
                            <option value="2">HOD</option>
                            <option value="3">Employee</option>
                        </select>
				       </span>
          </div>
         
          <div class="card-body">
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class=""></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
              </div>
            </div>
          
            <canvas id="beneficiariesChart" class="chartjs-render-monitor" width="479" height="455" style="display: block; width: 479px; height: 455px;"></canvas>
            
            
            
          </div>
          
          <div class="text-center mb-4">Beneficiaries / Type of Training</div>
        </div>
      </div>
      
      
    </div>
      
      
      
      
      
      
      
      
      
       
       </div>
     
     
     
     
     
     
      </div>
 
  </div>
</section>

@endsection

