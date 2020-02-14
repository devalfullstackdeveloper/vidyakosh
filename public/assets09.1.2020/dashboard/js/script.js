$(document).ready(function(){
$(".btn-close").click(function(){
$(this).parents(".card").css("display","none")
});	
});
	
	
// Fullscreen
$(document).on('click', '.btn-fullscreen', function(){
$(this).parents('.card').toggleClass('box-fullscreen');
window.dispatchEvent(new Event('resize'));
});

// Fullscreen
$(document).ready(function(){
$('.filterBtn').click(function(){
	$('.card .f-box').toggle('show');
	});	
	
	
$('.filterBtn-1').click(function(){
	$('.card .f-box-1').toggle('show');
	});	
	
	$('.filterBtn-2').click(function(){
	$('.card .f-box-2').toggle('show');
	});	
	
	
	});

// Slide up/down
$(document).on('click', '.btn-slide', function(){
$(this).toggleClass('rotate-180').parents('.card').find('.card-body').slideToggle();
});


$(document).ready(function(){
  var sidebar = $('.sidebar');
  function addActiveClass(element) {
      if (current === "") {
        //for root url
        if (element.attr('href').indexOf("index.html") !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
        }
      } else {
        //for other url
        if (element.attr('href').indexOf(current) !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
          if (element.parents('.submenu-item').length) {
            element.addClass('active');
          }
        }
      }
    }

    var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
    $('.nav li a', sidebar).each(function() {
      var $this = $(this);
      addActiveClass($this);
    })

    $('.horizontal-menu .nav li a').each(function() {
      var $this = $(this);
      addActiveClass($this);
    })

    //Close other submenu in sidebar on opening any

    sidebar.on('show.bs.collapse', '.collapse', function() {
      sidebar.find('.collapse.show').collapse('hide');
    });
});

//slimscroll

$(document).ready(function(){
$('#sidebar').slimscroll({
  height: '100%',
  size: '5px'
});
});	

$(document).ready(function(){
$('.button-menu-mobile').click(function(){
$('body').toggleClass('enlarged');
});
});

$(function () {
  $(".datepicker").datepicker({ 
        autoclose: true, 
        todayHighlight: true
  }).datepicker('update', new Date());
});