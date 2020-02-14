@extends('frontend.layouts.app'.config('theme_layout'))
@section('title', 'Analytics | '.app_name())
@push('after-styles')
<style>
       
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
                    <h2 class="breadcrumb__title">Analytics </h2>
				</div>
				</div>
	 </div>
       </div> 
    </section> 
    <!-- End of breadcrumb section
        ============================================= -->
<section class="slider-area zIn-9999 bgGray">
  <div class="homepage-slide1">
      <div class="w-100">
      <!--<div class="closeBox"><a href="{{url('/')}}">x</a></div>-->
        <div class="BeneficiariesBox">
      <!--<h2>Analytics</h2>-->
      
       <!--graph section-->
  <div class="container-fluid pb-5">

    <div class="row">
      <div class="col-sm-12 col-lg-6">
		    <div class="card">		
		  <span class="classroom_training_drop">
			 <select id="drop_select1" name="drop_select1" style="font-size: 14px;padding: 3px;border-radius: 4px;">
				  <option value="0">Please Select</option>
                  <option value="1">Month Wise</option>
                  <option value="2">Year Wise</option>
                  <option value="3">Designation Wise</option>
				  <option value="4">Domain Wise</option>
                </select>
			<select id="drop_select2" name="drop_select2" style="font-size: 14px;padding: 3px;border-radius: 4px;">
                  <option value="0">All</option>
                 @foreach($designations as $designationdata)
				<option value="{{$designationdata->id}}">{{$designationdata->designation}}</option>
				 @endforeach	
                </select>
		</span>
					  <div class="triangle-up3"></div>
		 	  <div class="triangle-right3"></div>
        <div id="classroom_trainings_chartanalytics"></div>
      </div>
		   </div>
      
      <!---graph 2-->
      <div class="col-sm-12 col-lg-6">
        <div class="card">
          <div class="card-tittle" id="constituencyPanel"> Top 10 E-Learning Courses<span> 
			  <!--<span class="chartIcon"><img src="{{asset('assets/images/icon/line.svg')}}" id="lineChartBtn"></span>-->
			  <span class="chartIcon"><img src="{{asset('assets/images/icon/bar-chart.svg')}}" id="barChartBtn"></span> 
			  <span class="chartIcon"><img src="{{asset('assets/images/icon/filter.svg')}}" class="filterBtn-2"> </span>
			  </span>
			</div>
          <!--filter Box-->
          <div class="filterPanel f-box-2" style="display:none;">
            <div class="row">
              <div class="col-md-4">
                <p>Name of Antibiotics </p>
                <select class="form-control">
                  <option value="#">Tetracycline</option>
                  <option value="#">Oxytetracycline</option>
                  <option value="#">Trimethoprim</option>
                  <option value="#">Oxolinic Self Assessment </option>
                </select>
              </div>
              
              <!--/01-->
              <div class="col" style="padding-top:20px;">
                <button type="submit" class="btn  btn-success">Go</button>
                <a href="#" class="btn btn-info">Reset</a> </div>
              <!--/01--> 
            </div>
          </div>
          <!--filter Box-->
          
          <div class="card-body">			  
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class=""></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
              </div>
            </div>
			   <div class="triangle-up4"></div>
			  <div class="triangle-right4"></div>
            <canvas id="constituencyDetailsChart" class="chartjs-render-monitor" width="479" height="255" style="display: block; width: 479px; height: 255px;"></canvas>
          </div>
        </div>
      </div>
    </div>
    
    
    <div class="row mt-4">		
		 <div class="col-sm-12 col-lg-6">
			   <div class="card">
			   <div class="triangle-up6"></div>
		  <div class="triangle-right6"></div>
			<span class="classroom_training_drop">
				 <select id="exec_drop_select1" name="exec_drop_select1" style="font-size: 14px;padding: 3px;border-radius: 4px;">
					  <option value="0">Please Select</option>
					  <option value="1">Month Wise</option>
					  <option value="2">Year Wise</option>
					  <option value="3">Designation Wise</option>
					  <option value="4">Domain Wise</option>
					</select>
				<select id="exec_drop_select2" name="exec_drop_select2" style="font-size: 14px;padding: 3px;border-radius: 4px;">
					  <option value="0">All</option>
					 @foreach($designations as $designationdata)
					<option value="{{$designationdata->id}}">{{$designationdata->designation}}</option>
					 @endforeach	
					</select>
			</span>
			<div id="exec_chartanalytics"></div>
        </div>
			    </div>
		
		
   
      
      <!---graph 2-->
      <div class="col-sm-12 col-lg-6">
			 <div class="card">
			   <div class="triangle-up7"></div>
		  <div class="triangle-right7"></div>
			<span class="classroom_training_drop">
				 <select id="seminar_drop_select1" name="seminar_drop_select1" style="font-size: 14px;padding: 3px;border-radius: 4px;">
					  <option value="0">Please Select</option>
					  <option value="1">Month Wise</option>
					  <option value="2">Year Wise</option>
					  <option value="3">Designation Wise</option>
					  <option value="4">Domain Wise</option>
					</select>
				<select id="seminar_drop_select2" name="seminar_drop_select2" style="font-size: 14px;padding: 3px;border-radius: 4px;">
					  <option value="0">All</option>
					 @foreach($designations as $designationdata)
					<option value="{{$designationdata->id}}">{{$designationdata->designation}}</option>
					 @endforeach	
					</select>
			</span>
			<div id="seminar_chartanalytics"></div>
        </div>
		  </div>
		
		
      </div>
	  
	  
	   <div class="row mt-4">	
	  <!---graph 2-->
        <div class="col-sm-12 col-lg-6">
        <div class="card">
          <div class="card-tittle" id="schoolCollagePanel"> Webinar 
        <span>
          <span class="chartIcon"><img src="{{asset('assets/images/icon/line.svg')}}" id="lineChartBtn"></span> 
          <span class="chartIcon"><img src="{{asset('assets/images/icon/bar-chart.svg')}}" id="barChartBtn"></span> 
          <span class="chartIcon"><img src="{{asset('assets/images/icon/filter.svg')}}" class="filterBtn-1"></span>
        </span>
          </div>
          <!--filter Box-->
          <div class="filterPanel f-box-1" style="display:none;">
            <div class="row">
              <div class="col-md-4">
                <p>Name of insecticide</p>
                <select class="form-control">
                  <option value="#">2,4-Dichlorophenoxy Acetic Acid</option>
                  <option value="#">Alachlor</option>
                  <option value="#">Alpha cypermethrin</option>
                  <option value="#">Benfuracarb</option>
                  <option value="#">Beta Cyfluthrin</option>
                </select>
              </div>
              
              <!--/01-->
              <div class="col" style="padding-top:20px;">
                <button type="submit" class="btn  btn-success">Go</button>
                <a href="#" class="btn btn-info">Reset</a> </div>
              <!--/01--> 
            </div>
          </div>
          <!--filter Box-->
          
          <div class="card-body">			  
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class=""></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
              </div>
            </div>
			   <div class="triangle-up5"></div>
			  <div class="triangle-right5"></div>
            <canvas id="WebinarChartStBox" class="chartjs-render-monitor" width="479" height="255" style="display: block; width: 479px; height: 255px;"></canvas>
          </div>
        </div>
      </div>
	    </div>
	  
	  
	  
	  
    </div>
  </div>
  <!--graph section emds--> 
       </div>
      </div>
 

</section>
@endsection

@push('after-scripts')
<script type="text/javascript">
$(document).ready(function(){

  var dd = $('.ticker01').easyTicker({
    direction: 'up',
    easing: 'easeInOutBack',
    speed: 'slow',
    interval: 2000,
    height: 'auto',
    visible: 10,
    mousePause: 0,
    controls: {
      up: '.up',
      down: '.down',
      toggle: '.toggle',
      stopText: 'Stop !!!'
    }
  }).data('easyTicker');
  
  cc = 1;
  $('.aa').click(function(){
    $('.ticker01 ul').append('<li>' + cc + ' Triangles can be made easily using CSS also without any images. This trick requires only div tags and some</li>');
    cc++;
  });
  
  $('.vis').click(function(){
    dd.options['ticker01'] = 3;
    
  });
  
  $('.ticker01').click(function(){
    dd.stop();
    dd.options['ticker01'] = 0 ;
    dd.start();
  });
  
});
</script>

<script>
$(function() {
  $('[data-toggle="popover"]').each(function(i, obj) {
    var popover_target = $(this).data('popover-target');
  
    $(this).popover({
        html: true,
        trigger: 'manual',
    delay: { 
             show:0, 
             hide: 0
    },
        placement: 'right',
        content: function(obj) {
            return $('#trendingCoursesHoverArea').html();
        }
    }).on("mouseenter", function () {
        var _this = this;
        var dynamic_elementid = $(this).attr('data-element');
        var allelements = $("#"+dynamic_elementid).html();
        var name = allelements.split('##**##')[0];
        var title = allelements.split('##**##')[1];
        var description = allelements.split('##**##')[2];
        var route = allelements.split('##**##')[3];
        $("#popover_name").html(name);
        $("#popover_title").html(title);
        $("#popover_description").html(description);
        $("#popover_redirection").attr('href',route);
        $(this).popover("show");
        $(".popover").on("mouseleave", function () {
            $("#popover_name").html();
            $("#popover_title").html();
            $("#popover_description").html();
            $("#popover_route").html();
            $(_this).popover('hide');
        });
    }).on("mouseleave", function () {
        var _this = this;
        setTimeout(function () {
            if (!$(".popover:hover").length) {
                $(_this).popover("hide");
            }
        }, 300);
});
  });
});
</script>
<script>
var trending_headings = <?php echo $trending_courses ?>;
var trending_chartdata = <?php echo $trending_courses_data ?>;
var classroom_trainings_chart_data = <?php echo json_encode($classroom_trainings_chart_data);?>;
var exec_trainings_chart_data = <?php echo json_encode($exec_trainings_chart_data);?>;
var seminar_trainings_chart_data = <?php echo json_encode($seminar_trainings_chart_data);?>;

$(document).ready(function() {
	$(".headerTextSlider").click(function () {
		$(".headerTextSlider").removeClass("active");
		// $(".tab").addClass("active"); // instead of this do the below 
		$(this).addClass("active");   
	});
	$(".findbox").click(function () {
		$(".findbox").removeClass("active");
		// $(".tab").addClass("active"); // instead of this do the below 
		$(this).addClass("active");   
	});
	

});
	
	load_charts('classroom_trainings_chartanalytics' , classroom_trainings_chart_data, 'Domains', 'Number of Trainings', 'Classroom Trainings', 'Numbers');  
	load_charts('seminar_chartanalytics' , seminar_trainings_chart_data, 'Domains', 'Number of Trainings', 'Seminar', 'Numbers');  
	load_charts('exec_chartanalytics' , exec_trainings_chart_data, 'Domains', 'Number of Trainings', 'Executive Briefing', 'Numbers');  
	//-------------------------------yearwise filter------------------------------//
	$('select[name="drop_select1"]').on('change', function() {
            var drop_select1 = $(this).val();
            if(drop_select1) {
                $.ajax({
                    url: 'training_charts/classroom/'+drop_select1+'/0',
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
						load_charts('classroom_trainings_chartanalytics' , data, 'Domains', 'Number of Trainings', 'Classroom Trainings', 'Numbers');
                    }
                });
            }else{
             //   $('#crt_designation_id').empty();
            }
        });	
	
	$('select[name="drop_select2"]').on('change', function() {
            var drop_select2 = $(this).val();
            if(drop_select2) {
                $.ajax({
                    url: 'training_charts/classroom/3/'+drop_select2, 
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
						load_charts('classroom_trainings_chartanalytics' , data, 'Domains', 'Number of Trainings', 'Classroom Trainings', 'Numbers');
                    }
                });
            }else{
             //   $('#crt_designation_id').empty();
            }
	});	
	
	
	
	//---------------------executing briefing---------------------------------//

	$('select[name="exec_drop_select1"]').on('change', function() {
            var drop_select1 = $(this).val();
            if(drop_select1) {
                $.ajax({
                    url: 'training_charts/execbrf/'+drop_select1+'/0',
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
						load_charts('exec_chartanalytics' , data, 'Domains', 'Number of Trainings', 'Executing Briefing', 'Numbers');
                    }
                });
            }else{
             //   $('#crt_designation_id').empty();
            }
        });	
	
	$('select[name="exec_drop_select2"]').on('change', function() {
            var drop_select2 = $(this).val();
            if(drop_select2) {
                $.ajax({
                    url: 'training_charts/execbrf/3/'+drop_select2, 
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
						load_charts('exec_chartanalytics' , data, 'Domains', 'Number of Trainings', 'Executing Briefing', 'Numbers');
                    }
                });
            }else{
             //   $('#crt_designation_id').empty();
            }
	});	
	

	//-------------------------------yearwise filter------------------------------//
	$('select[name="seminar_drop_select1"]').on('change', function() {
            var drop_select1 = $(this).val();
            if(drop_select1) {
                $.ajax({
                    url: 'training_charts/seminar/'+drop_select1+'/0',
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
						load_charts('seminar_chartanalytics' , data, 'Domains', 'Number of Trainings', 'Seminar', 'Numbers');
                    }
                });
            }else{
             //   $('#crt_designation_id').empty();
            }
        });	
	
	$('select[name="seminar_drop_select2"]').on('change', function() {
            var drop_select2 = $(this).val();
            if(drop_select2) {
                $.ajax({
                    url: 'training_charts/seminar/3/'+drop_select2, 
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
						load_charts('seminar_chartanalytics' , data, 'Domains', 'Number of Trainings', 'Seminar', 'Numbers');
                    }
                });
            }else{
             //   $('#crt_designation_id').empty();
            }
	});	
</script>
    
@endpush