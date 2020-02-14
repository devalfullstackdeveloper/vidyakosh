<!DOCTYPE html>
@if(config('app.display_type') == 'rtl' || (session()->has('display_type') && session('display_type') == 'rtl'))
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

    @else
        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

        @endif
        {{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">--}}
        {{--@else--}}
        {{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
        {{--@endlangrtl--}}
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <title>@yield('title', app_name())</title>
            <meta name="description" content="@yield('meta_description', 'Laravel 5 Boilerplate')">
            <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
            @if(config('favicon_image') != "")
                <link rel="shortcut icon" type="image/x-icon"
                      href="{{asset('storage/logos/'.config('favicon_image'))}}"/>
            @endif
            @yield('meta')
            <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
			<link rel="stylesheet" href="{{asset('assets/css/fontawesome-all.css')}}">
            <link rel="stylesheet" href="{{asset('assets/dashboard/css/style.css')}}">
		   <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker.css')}}">
			<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
			<link rel="stylesheet" href="{{asset('assets/js/carousel/owl.carousel.css')}}">
			<link rel="stylesheet" href="{{asset('assets/js/carousel/owl.theme.css')}}">
     <link rel="stylesheet" href="{{asset('css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/tooltipster.bundle.min.css')}}">
			
			<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
			<script src="{{asset('assets/js/plugin.js')}}"></script>
			<!--script src="{{asset('assets/js/bootstrap-datepicker.js')}}"></script-->
      <script src="{{asset('assets/js/Chart.min.js')}}"></script>
      <script src="{{asset('assets/js/chart.js')}}"></script>
			 <script type="text/javascript" src="{{asset('assets/dashboard/js/jqueryvalidator.js')}}"></script>


      <!-- <script >
        //scroll bar script
$(document).ready(function(){
  $('.slimscrollPanel').slimScroll({
    height: '195px'
});
$('.slimscrollPanel-0').slimScroll({
    height: '210px'
});

$('.slimscrollPanel-1').slimScroll({
    height: '235px'
});

$('.slimscrollPanel-2').slimScroll({
    height: '245px'
});

$('.slimscrollPanel-4').slimScroll({
    height: '320px'
});


});

      </script> 
 -->
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

            <link rel="stylesheet"
                  href="//cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>
            <link rel="stylesheet"
                  href="https://cdn.datatables.net/select/1.2.0/css/select.dataTables.min.css"/>
            <link rel="stylesheet"
                  href="//cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css"/>
            {{--<link rel="stylesheet"--}}
            {{--href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css"/>--}}
            {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
            <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
            <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
			<script src="{{asset('assets/dashboard/js/validatemin.js')}}"></script>
			<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->

            @stack('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
            <!-- Otherwise apply the normal LTR layouts -->
            {{ style(mix('css/backend.css')) }}

            
            @stack('after-styles')

            @if((config('app.display_type') == 'rtl') || (session('display_type') == 'rtl'))
                <style>
                    .float-left {
                        float: right !important;
                    }

                    .float-right {
                        float: left !important;
                    }
                </style>
            @endif

        </head>

        <body class="{{ config('backend.body_classes') }}">
        @include('backend.includes.header')

        <div class="app-body">
            @include('backend.includes.sidebar')

            <main class="main">
                @include('includes.partials.logged-in-as')
                {{--{!! Breadcrumbs::render() !!}--}}

                <div class="container-fluid" style="padding-top: 30px">
                    <div class="animated fadeIn">
                        <div class="content-header">
                            @yield('page-header')
                        </div><!--content-header-->

                        @include('includes.partials.messages')
                        @yield('content')
                    </div><!--animated-->
                </div><!--container-fluid-->
            </main><!--main-->

            @include('backend.includes.aside')
        </div><!--app-body-->

        @include('backend.includes.footer')

        <!-- Scripts -->
        @stack('before-scripts')
        {!! script(mix('js/manifest.js')) !!}
        {!! script(mix('js/vendor.js')) !!}
        {!! script(mix('js/backend.js')) !!}
        <script>
            //Route for message notification
            var messageNotificationRoute = '{{route('admin.messages.unread')}}'
        </script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
        <script src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="{{asset('js/pdfmake.min.js')}}"></script>
        <script src="{{asset('js/vfs_fonts.js')}}"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	    	<script type="text/javascript" src="{{asset('assets/dashboard/js/chart.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/dashboard/js/script.js')}}"></script>
        <!--script type="text/javascript" src="{{asset('assets/dashboard/js/bootstrap-datepicker.js')}}"></script-->
        <script type="text/javascript" src="{{asset('assets/dashboard/js/chart.js')}}"></script>
					
         <script type="text/javascript" src="{{asset('assets/js/carousel/owl.carousel.js')}}"></script>
			 
        <script src="{{asset('js/select2.full.min.js')}}" type="text/javascript"></script>

        <script src="https://unpkg.com/vue/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue-apexcharts"></script>
       
        <script src="{{asset('js/main.js')}}" type="text/javascript"></script>

<script src="https://unpkg.com/feather-icons"></script>
 <script src="{{asset('assets/js/tooltipster.bundle.min.js')}}"></script> 			
				<script>
        $(document).ready(function() {
            $('.customtooltip').tooltipster();
        });
    </script>
  <script>
    feather.replace()
  </script>

<script>
//carousel slider js
$(document).ready(function() {
	$(".sliderBoxItems").owlCarousel({
	  items :4,
	   itemsDesktopSmall : [1024, 2],
        itemsTablet : [768, 2],
        itemsTabletSmall : [640, 2],
        itemsMobile : [480, 1],
	  lazyLoad : true,
	  navigation : true,
	  pagination : false,
	  autoPlay : true
	  });
});
			</script>	

<script>
    new Vue({
      el: '#chart1',
      components: {
        apexchart: VueApexCharts,
      },
      data: {
        series: [
          {
            name: "High - 2013",
            data: [28, 29, 33, 36, 32, 32, 33]
          },
          {
            name: "Low - 2013",
            data: [12, 11, 14, 18, 17, 13, 13]
          }
        ],
        chartOptions: {
          chart: {
           shadow: {
                enabled: true,
                color: "#000",
                top: 18,
                left: 7,
                blur: 10,
                opacity: 1
            },
            toolbar: {
              show: false
            }
          },
          colors: ["#786BED", "#999b9c"],
          dataLabels: {
            enabled: true,
          },
          stroke: {
            curve: 'smooth'
          },
          title: {
            text: '',
            align: 'left'
          },
          grid: {
            borderColor: '#e7e7e7',
            row: {
              colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
              opacity: 0.5
            },
          },
          markers: {
            
            size: 6
          },
          xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
              labels: {
                style: {
                    colors: "#9aa0ac"
                }
            },
            title: {
              text: 'Month'
            }
          },
          yaxis: {
            title: {
              text: 'Temperature'
            },
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            },
            min: 5,
            max: 40
          },
          legend: {
            position: 'top',
            horizontalAlign: 'right',
            floating: true,
            offsetY: -25,
            offsetX: -5
          }
        }
      },

    })
  </script>
     
        <script>
            window._token = '{{ csrf_token() }}';
        </script>

        @stack('after-scripts')

        </body>
		<?php
		if(!empty($courses_list)){?>
		<script type="text/javascript">
            $(document).ready(function(){
  var config = {
    type: 'bar',
    data: {
      labels: @json($courses_list ),
     // labels: ["AI/ML", "Python", "Data Analytics", "DB Systems", "Cyber/App Security", "Sys Adm", "Int & N/W Tech", "Soft Dev"],
      datasets: [{
        label: "Population", 
         data: @json($course_student_count ),
       
        fill: true,
        borderColor: "rgba(49,172,170,0.9)",
        backgroundColor:[ "#36a2eb","#ff6384","#ff9f40","#ffcd56","#4bc0c0","#aedb7c","#9666ba","#fd9677","#aedb7c","#9666ba","#fd9677","#aedb7c","#9666ba","#fd9677","#aedb7c","#9666ba","#fd9677","#ff6384"],
       
   fill: false,
      pointRadius: 4,
     pointHitRadius: 10,
    
      },
    {
          type: 'line', 
          label: 'B',
          // the 1st and last value are placeholders and never get displayed on the chart
          // to get a straight line, the 1st and last values must match the same value as
          // the next/prev respectively
          data: @json($course_student_count ),
          fill: false,
          borderWidth: 3,
          borderColor: "rgba(49,172,170,0.9)",
         backgroundColor:[ "#36a2eb","#ff6384","#ff9f40","#ffcd56","#4bc0c0","#aedb7c","#9666ba","#fd9677","#aedb7c","#9666ba","#fd9677","#aedb7c","#9666ba","#fd9677","#aedb7c","#9666ba","#fd9677","#ff6384"],
          borderDash: [5,4],
          lineTension: 0,
          //steppedLine: true
        }
    
    ]
    },
    
    options: {
      responsive: true,
    legend: {
         display: false,
              position: 'bottom',
          },
        
      scales: {
      yAxes: [{
      ticks: {
         beginAtZero: false
        },
        scaleLabel: {
            labelString: 'No of Trainees',
            display: true,
          },
      }]
    },
    
    title: {
      fontSize: 12,
      display: true,
      text: 'Course',
      position: 'bottom'
    }
    },
    
  };
  var myChart;
   change('bar');
  $("#populationPanel #barChartBtn").click(function() {
    change('bar');
  });
  $("#populationPanel #pieChartBtn").click(function() {
    change('scatter');
    
    //backgroundColor:[ "#ff4243","#ffd13e","#45c27e","#42c4f5","#ff4342","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
    
  });
  $("#populationPanel #lineChartBtn").click(function() {
    change('line');
  });
  function change(newType) {
    var ctx = document.getElementById("trainingChart").getContext("2d");
    // Remove the old chart and all its event handles
    if (myChart) {
      myChart.destroy();
    }
    // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
    var temp = jQuery.extend(true, {}, config);
    temp.type = newType;
     //temp.type = newType;
    myChart = new Chart(ctx, temp);
  };
});
        $(document).ready(function(){
            var config = {
              type: 'line',
              data: {
                 labels: ["Kotputli", "Viratnagar", "Shahpura ", "Phulera", "Jhotwara", "Amer", "Ramgarh", "Bansur", "Baran", "Barmer", "Bikaner", "Churu"],
                datasets: [{
                  label: "Population",
                   data: [10, 13, 17, 12, 30, 47, 60, 120, 230, 300, 310, 400],
                 
                  fill: true,
                  borderColor: "rgba(49,172,170,0.9)",
                   backgroundColor:[ "#36a2eb","#ff6384","#ff9f40","#ffcd56","#4bc0c0","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
             fill: false,
                pointRadius: 4,
               pointHitRadius: 10,
                },]
              },
              
              options: {
                responsive: true,
              legend: {
                 display: false,
                       // position: 'bottom',
                    },
                
                scales: {
               yAxes: [{
                 ticks: {
                  beginAtZero: false
                 },
                scaleLabel: {
                      labelString: 'Attendees',
                      display: true,
                    },
                }]
              },
              title: {
                fontSize: 12,
                display: true,
                text: 'Webinars Categories',
                position: 'bottom'
              }
              },
              
            };
      var myChart;
      change('line');
      $("#schoolCollagePanel #barChartBtn").click(function() {
        change('bar');
      });
      $("#schoolCollagePanel #pieChartBtn").click(function() {
        change('polarArea');
        //backgroundColor:[ "#ff4243","#ffd13e","#45c27e","#42c4f5","#ff4342","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
        
      });
      $("#schoolCollagePanel #lineChartBtn").click(function() {
        change('line');
      });
      function change(newType) {
        var ctx = document.getElementById("webinarsChart").getContext("2d");
        // Remove the old chart and all its event handles
        if (myChart) {
          myChart.destroy();
        }
        // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
        var temp = jQuery.extend(true, {}, config);
        temp.type = newType;
         //temp.type = newType;
        myChart = new Chart(ctx, temp);
      };
    });
      //Constituency Details
      $(document).ready(function(){
        var config = {
          type: 'bar',
          data: {
            labels: @json($years ),
            datasets: [{
              label: "Population",
               data: @json($earning ),
             
              fill: true,
              borderColor: "rgba(49,172,170,0.9)",
               backgroundColor:[ "#36a2eb","#ff6384","#ff9f40","#ffcd56","#4bc0c0","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
         fill: false,
            pointRadius: 4,
           pointHitRadius: 10,
            },]
          },
          
          options: {
            responsive: true,
          legend: {
             display: false,
                   // position: 'bottom',
                },
            
              scales: {
            yAxes: [{
              ticks: {
               beginAtZero: false
              },
             scaleLabel: {
                  labelString: 'INR',
                  display: true,
                },
            }]
          },
          title: {
            fontSize: 12,
            display: true,
            text: 'Month',
            position: 'bottom'
          }
          },
          
        };
        var myChart;
        change('bar');
        $("#constituencyPanel #barChartBtn").click(function() {
          change('bar');
        });
        $("#constituencyPanel #pieChartBtn").click(function() {
          change('polarArea');
          //backgroundColor:[ "#ff4243","#ffd13e","#45c27e","#42c4f5","#ff4342","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
          
        });
        $("#constituencyPanel #lineChartBtn").click(function() {
          change('line');
        });
        function change(newType) {
          var ctx = document.getElementById("constituencyDetailsChart").getContext("2d");
          // Remove the old chart and all its event handles
          if (myChart) {
            myChart.destroy();
          }
          // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
          var temp = jQuery.extend(true, {}, config);
          temp.type = newType;
           //temp.type = newType;
          myChart = new Chart(ctx, temp);
        };
      });
        </script>
		<?php 
		}?>
			
		<script>
//School Collage
$(document).ready(function(){
var config = {
  type: 'line',
  data: {
     labels: ["Kotputli", "Viratnagar", "Shahpura ", "Phulera", "Jhotwara", "Amer", "Ramgarh", "Bansur", "Baran", "Barmer", "Bikaner", "Churu"],
    datasets: [{
      label: "Population",
       data: [10, 13, 17, 12, 30, 47, 60, 120, 230, 300, 310, 400],
	   
      fill: true,
      borderColor: "rgba(49,172,170,0.9)",
       backgroundColor:[ "#36a2eb","#ff6384","#ff9f40","#ffcd56","#4bc0c0","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
//	   borderCapStyle: 'square',
//    pointBorderColor: "white",
//    pointBackgroundColor: "green",
//    pointBorderWidth: 1,
//    pointHoverRadius: 8,
//    pointHoverBackgroundColor: "yellow",
//    pointHoverBorderColor: "green",
//    pointHoverBorderWidth: 2,
 fill: false,
    pointRadius: 4,
   pointHitRadius: 10,
    },]
  },
  
  options: {
    responsive: true,
	legend: {
		 display: false,
           // position: 'bottom',
        },
		
	  scales: {
   yAxes: [{
     ticks: {
      beginAtZero: false
     },
	  scaleLabel: {
          labelString: 'Attendees',
          display: true,
        },
    }]
  },
  title: {
    fontSize: 12,
    display: true,
    text: 'Webinars Categories',
    position: 'bottom'
  }
  },
  
};

var myChart;
 change('bar');
$("#schoolCollagePanel #barChartBtn").click(function() {
  change('bar');
});

$("#schoolCollagePanel #pieChartBtn").click(function() {
  change('polarArea');
  //backgroundColor:[ "#ff4243","#ffd13e","#45c27e","#42c4f5","#ff4342","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
  
});

$("#schoolCollagePanel #lineChartBtn").click(function() {
  /**change('line');**/
	  change('bar');
});

function change(newType) {
  var ctx = document.getElementById("WebinarChartStBox").getContext("2d");

  // Remove the old chart and all its event handles
  if (myChart) {
    myChart.destroy();
  }

  // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
  var temp = jQuery.extend(true, {}, config);
  temp.type = newType;
   //temp.type = newType;
  myChart = new Chart(ctx, temp);
};

});

</script>

@if(isset($_GET['id']))
<?php
$param = explode(",", $_GET['id']);
$id = $param[0];
$level = $param[1];
$tab = $param[2];

$label = '["'.implode('","', $labelArr).'"]';
$data = '["'.implode('","', $dataArr).'"]';
$category = '["'.implode('","', $categories).'"]';
?>
<script>
    //School Collage
    $(document).ready(function(){
        
        $('#chart1Table').DataTable({
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
        
        $('#chart2Table').DataTable({
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
        
        var config = {
            type: 'line',
            data: {
                labels: <?php echo $label; ?>,
                datasets: [{
                        label: "CRT",
                        data: <?php echo $data; ?>,
                        
                        fill: true,
                        borderColor: "rgba(49,172,170,0.9)",
                        backgroundColor:[ "#36a2eb","#ff6384","#ff9f40","#ffcd56","#4bc0c0","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
                        //	   borderCapStyle: 'square',
                        //    pointBorderColor: "white",
                        //    pointBackgroundColor: "green",
                        //    pointBorderWidth: 1,
                        //    pointHoverRadius: 8,
                        //    pointHoverBackgroundColor: "yellow",
                        //    pointHoverBorderColor: "green",
                        //    pointHoverBorderWidth: 2,
                        fill: false,
                        pointRadius: 4,
                        pointHitRadius: 10,
                    },]
            },
            
            options: {
                responsive: true,
                legend: {
                    display: false,
                    // position: 'bottom',
                },
		
                scales: {
                    yAxes: [{
                            ticks: {
                                stepSize: 1,
                                beginAtZero: true
                            },
                            scaleLabel: {
                                labelString: 'Total <?php echo $tab; ?>',
                                display: true,
                            },
                        }]
                },
                title: {
                    fontSize: 12,
                    display: true,
                    text: '<?php echo $tab; ?>',
                    position: 'bottom'
                }
            },
            
        };
        
        var myChart;
        change('bar');
        $("#schoolCollagePanel #barChartBtn").click(function() {
            change('bar');
        });
        
        $("#schoolCollagePanel #pieChartBtn").click(function() {
            change('polarArea');
            //backgroundColor:[ "#ff4243","#ffd13e","#45c27e","#42c4f5","#ff4342","#aedb7c","#9666ba","#fd9677","#0ec599","#10adf4","#faae1c","#0ec599"],
            
        });
        
        $("#schoolCollagePanel #lineChartBtn").click(function() {
            /**change('line');**/
            change('bar');
        });
        
        function change(newType) {
            var ctx = document.getElementById("WebinarChartSt-5").getContext("2d");
            
            // Remove the old chart and all its event handles
            if (myChart) {
                myChart.destroy();
            }
            
            // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
            var temp = jQuery.extend(true, {}, config);
            temp.type = newType;
            //temp.type = newType;
            myChart = new Chart(ctx, temp);
        };
        
    });
    
</script>	
	<?php
        $param = explode(",", $_GET['id']);
        $data = json_encode($param, TRUE);
        ?>
			
<script>
    
    var APP_URL = {!! json_encode(url('/')) !!};
    $( document ).ready(function() {
        
                        });
                        
    function userCrt(id,tab){
        $.ajax({
            url: APP_URL+'/user/elitedashboard_chart/chart1user-ajax/'+id+','+tab,
            type: "GET",
            dataType: "json",
            success:function(data) {
                var html = "";
                $("#chart-title-1").html(data.name);
                var myTable = $('#chart1TableCrt').DataTable();
                myTable.clear();
                if(tab == "E-learning"){
                    html +='<table id="chart1TableCrt" class="table table-bordered table-striped  dt-select ">';
                        html +='<thead>';
                            html +='<tr>';
                                html +='<th>Sr No.</th>';
                                html +='<th>Title</th>';
                            html +='</tr>';
                        html +='</thead>';
                        html +='<tbody> ';
                $.each(data.crt_data, function(key, val) {
//                                        myTable.row.add( [(key + 1), val.title] );
                            html +='<tr>';
                                html +='<td>'+(key + 1)+'</td>';
                                html +='<td>'+val.title+'</td>';
                            html +='</tr>';
                    });
                        html +='</tbody>';
                    html +='</table>';
                            
//                    $.each(data.crt_data, function(key, val) {
//                        myTable.row.add( [(key + 1), val.title] );
//                    });
                }else{
                    html +='<table id="chart1TableCrt" class="table table-bordered table-striped  dt-select ">';
                        html +='<thead>';
                            html +='<tr>';
                                html +='<th>Sr No.</th>';
                                html +='<th>Title</th>';
                                html +='<th>Duration</th>';
                                html +='<th>Venue</th>  ';
                            html +='</tr>';
                        html +='</thead>';
                        html +='<tbody>   '; 
                    $.each(data.crt_data, function(key, val) {
//                                        myTable.row.add( [(key + 1), val.title, val.duration, val.venue] );
                            html +='<tr>';
                                html +='<td>'+(key + 1)+'</td>';
                                html +='<td>'+val.title+'</td>';
                                html +='<td>'+val.duration+'</td>';
                                html +='<td>'+val.venue+'</td>  ';
                            html +='</tr>';
                });
                        html +='</tbody>';
                    html +='</table>';
//                    $.each(data.crt_data, function(key, val) {
//                        myTable.row.add( [(key + 1), val.title, val.duration, val.venue] );
//                    });
                }
                $(".chart1-training-modal").html(html);
                $("#exampleModalLongTitle").html(data.name);
//                $('#chart1TableCrt tbody').html('');
//                myTable.draw();
                $(".chart_1_detail").modal('show');
//                $(".chart1_table_crt").removeClass("d-none");
            }
        });
    }
    function userCrt2(id,cat,tab){
        $.ajax({
            url: APP_URL+'/user/elitedashboard_chart/chart2user-ajax/'+id+","+cat+','+tab,
            type: "GET",
            dataType: "json",
            success:function(data) {
                $("#chart-title-2").html(data.name);
                var myTable = $('#chart2TableCrt').DataTable();
                myTable.clear();
                html = '';
                if(tab == "E-learning"){
                    html +='<table id="chart1TableCrt" class="table table-bordered table-striped  dt-select ">';
                        html +='<thead>';
                            html +='<tr>';
                                html +='<th>Sr No.</th>';
                                html +='<th>Title</th>';
                            html +='</tr>';
                        html +='</thead>';
                        html +='<tbody> ';
                $.each(data.crt_data, function(key, val) {
//                                        myTable.row.add( [(key + 1), val.title] );
                            html +='<tr>';
                                html +='<td>'+(key + 1)+'</td>';
                                html +='<td>'+val.title+'</td>';
                            html +='</tr>';
                    });
                        html +='</tbody>';
                    html +='</table>';
//                    $.each(data.crt_data, function(key, val) {
//                        myTable.row.add( [(key + 1), val.title] );
//                    });
                }else{
                    html +='<table id="chart1TableCrt" class="table table-bordered table-striped  dt-select ">';
                        html +='<thead>';
                            html +='<tr>';
                                html +='<th>Sr No.</th>';
                                html +='<th>Title</th>';
                                html +='<th>Duration</th>';
                                html +='<th>Venue</th>  ';
                            html +='</tr>';
                        html +='</thead>';
                        html +='<tbody>   '; 
                    $.each(data.crt_data, function(key, val) {
//                                        myTable.row.add( [(key + 1), val.title, val.duration, val.venue] );
                            html +='<tr>';
                                html +='<td>'+(key + 1)+'</td>';
                                html +='<td>'+val.title+'</td>';
                                html +='<td>'+val.duration+'</td>';
                                html +='<td>'+val.venue+'</td>  ';
                            html +='</tr>';
                });
                        html +='</tbody>';
                    html +='</table>';
//                    $.each(data.crt_data, function(key, val) {
//                        myTable.row.add( [(key + 1), val.title, val.duration, val.venue] );
//                    });
                }
                $(".chart1-training-modal").html(html);
                $("#exampleModalLongTitle").html(data.name);
                $(".chart_1_detail").modal('show');
//                $('#chart2TableCrt tbody').html('');
//                myTable.draw();
//                $(".chart2_table_crt").removeClass("d-none");
            }
        });
    }
    
    $.ajax({
        url: APP_URL+'/user/elitedashboard_chart/chart-ajax/'+<?php echo $data; ?>,
        type: "GET",
        dataType: "json",
        success:function(data1) {
            var data3a = {
                labels: data1.category,
                datasets: data1.dataset
            };
            
            var option3a = {
                legend: {
                    display: false
                },
                
                scales: {
                    xAxes: [{
                            stacked: true,
                            gridLines: {
                                display: false
                            }
                        }],
                    yAxes: [{
                            stacked: true,
                            ticks: {
                                stepSize: 1,
                                beginAtZero: true
                            },
                            type: 'linear'
                        }]
                }};
            
            
            $(document).ready(
            function() {
                var canvas = document.getElementById("opportunitiesChart-A");
                var ctx = canvas.getContext("2d");
                var myNewChart = new Chart(ctx, {
                    type: 'bar',
                    options:option3a,
                    data: data3a
                });
                            }
        );
            
        }
    });
    
    $(document).ready(
    function() {
        var canvas = document.getElementById("opportunitiesChart-A");
        var ctx = canvas.getContext("2d");
        var myNewChart = new Chart(ctx, {
            type: 'bar',
            options:option3a,
            data: data3a
        });
        
        canvas.onclick = function(evt) {
            
            var activePoints = myNewChart.getElementsAtEvent(evt);
            if (activePoints[0]) {
                var chartData = activePoints[0]['_chart'].config.data;
                var idx = activePoints[0]['_index'];
                var label = chartData.labels[idx];
                var value = chartData.datasets[0].data[idx];
                // var id = "45";
                // var url = "#kamal" + label + "&value=" + value;
                $('#opportunitiesChartModal').modal('show');
                
                // console.log(url);
                // alert(url);
            }
        };
        
    }
);
    
</script>
			<script>
	$(function() {//<-- wrapped here
  $('.restrict').on('input', function() {
    this.value = this.value.replace(/[^a-zA-Z@\s]/g, ''); //<-- replace all other than given set of values
  });
});
	</script>
@endif
		
        </html>
