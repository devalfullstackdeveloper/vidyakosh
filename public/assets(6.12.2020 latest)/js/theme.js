

//slider js
$(document).ready(function() {
$('.bxslider').bxSlider({
auto: true,
autoControls: true
});
});

//carousel slider js
$(document).ready(function() {
	$("#slider-1").owlCarousel({
	  items : 6,
	   itemsDesktopSmall : [1400, 5],
        itemsTablet : [1100, 4],
        itemsTabletSmall : [640, 2],
        itemsMobile : [480, 1],
        	  navigation : true,
        	  pagination : false,
        	  autoPlay : false,
            loop:true,
            rewind: false                   
      });
  function callBack(){
          if($('#slider-1 .owl-item').last().hasClass('active')){
                $('.owl-next').hide();
                $('.owl-prev').show();
                console.log('true');
             }else if($('#slider-1 .owl-item').first().hasClass('active')){
                $('.owl-prev').hide();
                $('.owl-next').show();
                console.log('false');
             }
        }

      $("#slider-new").owlCarousel({
        items : 5,
         itemsDesktopSmall : [1024, 2],
          itemsTablet : [768, 2],
          itemsTabletSmall : [640, 2],
          itemsMobile : [480, 1],
        lazyLoad : true,
        navigation : false,
        pagination : true,
        autoPlay : true
        });
	  
	  $("#slider-2,#slider-3,#slider-4,#slider-5,slider-6").owlCarousel({
	  items :5,
	   itemsDesktopSmall : [1024, 3],
        itemsTablet : [768, 2],
        itemsTabletSmall : false,
        itemsMobile : [480, 1],
	  lazyLoad : true,
	  navigation : true,
	  pagination : false,
	  autoPlay : true
	  });
	  
	  $("#bottomIconSlider").owlCarousel({
	  items :4,
	   itemsDesktopSmall : [1024, 5],
        itemsTablet : [768, 4],
        itemsTabletSmall : false,
        itemsMobile : [480, 2],
	  lazyLoad : true,
	  navigation : false,
	  pagination : false,
	  autoPlay : true
	  });


    $("#headerTextSlider").owlCarousel({
    items :1,
    lazyLoad : true,
    navigation : false,
    pagination : false,
    autoPlay : true
      });
	  
});


$("#ListSliderCourse").owlCarousel({
    items :9,
    lazyLoad : true,
    navigation : true,
    pagination : false,
    autoPlay : true
    });


 $("#bannerTextSlider").owlCarousel({
    items :7,
     itemsDesktopSmall : [1024, 9],
        itemsTablet : [768, 4],
        itemsTabletSmall : false,
        itemsMobile : [480, 2],
    lazyLoad : true,
    navigation : false,
    pagination : false,
    autoPlay : true
    });
	
	 $(document).ready(function() {

$(".hoUp").click(function(){
  $("#" + $(this).attr('data-element')).addClass("hoUphover");
  //$(".pull-up").addClass("active");
});

$(".new_hover").mouseleave(function(){
  $(".new_hover").removeClass("hoUphover");
  //$(".pull-up").addClass("active");
});

})	

//$(".box_grid").on("mouseenter", function() {
//      $(".hover_effect").show();
//}).on("mouseleave", function() {
//      $(".hover_effect").hide();
//});


	

//tab js

  $(document).ready(function() {
	
	  $('#sectionTab-01').easyResponsiveTabs({
		  type: 'default',
		  width: 'auto',
		  fit: true,
		  tabidentify: 'hor_1',
		  activate: function(event) {
			  var $tab = $(this);
			  var $info = $('#nested-tabInfo');
			  var $name = $('span', $info);
			  $name.text($tab.text());
			  $info.show();
		  }
	  });

	
	  $('#sectionTab-02').easyResponsiveTabs({
		  type: 'vertical',
		  width: 'auto',
		  fit: true,
		  tabidentify: 'ver_1',
		  activetab_bg: '#fff',
		  inactive_bg: '#F5F5F5',
		  active_border_color: '#c1c1c1',
		  active_content_border_color: '#5AB1D0'
	  });
	  
	  
	  
	  
	  $("#exclusiveFeatures").owlCarousel({
	  items : 3,
	   itemsDesktopSmall : [1024, 2],
        itemsTablet : [768, 2],
        itemsTabletSmall : [640, 2],
        itemsMobile : [480, 1],
	  lazyLoad : true,
	  navigation : true,
	  pagination : false,
	  autoPlay : true
      });
	  
	    $("#relatedCoursesSd").owlCarousel({
	  items : 2,
	   itemsDesktopSmall : [1024, 2],
        itemsTablet : [768, 2],
        itemsTabletSmall : [640, 2],
        itemsMobile : [480, 1],
	  lazyLoad : true,
	  navigation : true,
	  pagination : false,
	  autoPlay : true
      });
	  
	   $("#footerSlider").owlCarousel({
	  items : 6,
	   itemsDesktopSmall : [1024, 2],
        itemsTablet : [768, 2],
        itemsTabletSmall : [640, 2],
        itemsMobile : [480, 1],
	  lazyLoad : true,
	  navigation : true,
	  pagination : false,
	  autoPlay : true
      });
	  
	    $("#course-area2").owlCarousel({
	  items : 1,
	   itemsDesktopSmall : [1024, 1],
        itemsTablet : [768, 1],
        itemsTabletSmall : [640, 1],
        itemsMobile : [480, 1],
	  lazyLoad : true,
	  navigation : true,
	  pagination : false,
	  autoPlay : true
      });


      $("#trendingCoursesSlider").owlCarousel({
    items : 3,
     itemsDesktopSmall : [1024, 2],
        itemsTablet : [768, 1],
        itemsTabletSmall : [640, 1],
        itemsMobile : [480, 1],
    lazyLoad : true,
    navigation : true,
    pagination : false,
    autoPlay : true
      });


	 
  });
  



//sub menu js
$(document).ready(function(){
$('[data-submenu]').submenupicker();
 });

//css change js
$(document).ready(function(){

var gCookie=readCookie('blackcss');
if(gCookie == "blackcss"){
   $('link[href="dist/css/white-bg.css"]').attr('href','dist/css/black-bg.css');
}
  
$('#blackBtn').click(function (){
  
 $('link[href="dist/css/white-bg.css"]').attr('href','dist/css/black-bg.css');
 createCookie('blackcss','blackcss',1);
});
$('#whiteBtn').click(function (){
 $('link[href="dist/css/black-bg.css"]').attr('href','dist/css/white-bg.css');
 createCookie('blackcss','blackcss',-1);
});

//color change js
function createCookie(name,value,days) {
  if (days) {
	  var date = new Date();
	  date.setTime(date.getTime()+(days*1*30*60*1000));
	  var expires = "; expires="+date.toGMTString();
  }
  else var expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
	  var c = ca[i];
	  while (c.charAt(0)==' ') c = c.substring(1,c.length);
	  if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}
});

// Reset Font Size
$(document).ready(function(){

var originalFontSize = $('.resentFontPanel').css('font-size');
$(".resetFont").click(function(){
$('.resentFontPanel').css('font-size', originalFontSize);
});
// Increase Font Size
$(".increaseFont").click(function(){
  var currentFontSize = $('.resentFontPanel').css('font-size');
  
  var currentFontSizeNum = parseFloat(currentFontSize, 2);
  
  var newFontSize = currentFontSizeNum*1.2;
  if(newFontSize <=24){
  $('.resentFontPanel').css('font-size', newFontSize);
  return false;
  
  }

});
// Decrease Font Size
$(".decreaseFont").click(function(){
  var currentFontSize = $('.resentFontPanel').css('font-size');
  var currentFontSizeNum = parseFloat(currentFontSize, 2);
  var newFontSize = currentFontSizeNum*0.8;
  if(newFontSize >=10){
  $('.resentFontPanel').css('font-size', newFontSize);
  return false;
  }
});
});



//header fixed

$(window).scroll(function() {
if ($('.menuSection').length) {
    var sticky = $('.menuSection'),
        scroll = $(window).scrollTop();

    if (scroll >= 180) sticky.addClass('fixedBox');
    else sticky.removeClass('fixedBox');
    
  };
});

jQuery(document).ready(function($){
/*
    ==============================================================
       PrettyPhoto Script Start
    ============================================================== */
	if($("area[data-rel^='prettyPhoto']").length){
		$("area[data-rel^='prettyPhoto']").prettyPhoto();
	}
	
	
	
	/*
    ==============================================================
       PrettyPhoto Script Start
    ============================================================== */
	if($(".edu_masonery_thumb a[data-rel^='prettyPhoto']").length){
		$(".edu_masonery_thumb:first a[data-rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: true});
		$(".edu_masonery_thumb:gt(0) a[data-rel^='prettyPhoto']").prettyPhoto({});
	}
	
	/*
    ==============================================================
       PrettyPhoto Script Start
    ============================================================== */
	if($(".gallery a[rel^='prettyPhoto']").length){
		$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: true});
		$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({});
	}
	
});

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

//pdf new window script

function openChild(file,windowmn,val)
{
 	if(parseInt(val)==1)
	{
		if(!confirm('This link shall take you to a page/website outside this website.For any query regarding the contents of the linked page/website, please contact the webmaster of the concerned website.'))
			return false;
	}
	else if(val==5)
	{
		  childWindow=window.open(file,windowmn,'width=600,height=500,screenX=100,screenY=0,scrollbars=yes,menubar=no,location=no,toolbar=no,resizable=yes');
		childWindow.focus();
		return false;
	}
	else if(parseInt(val)!=0)
	{ 
		var arr=file.split(".");
		var ext=arr[arr.length-1].toLowerCase();
		if(ext=="pdf" || ext=="doc" || ext=="xls" || ext=="ppt" || ext=="docx" || ext=="jpg"  || ext=="jpeg" || ext=="gif"  || ext=="png" || ext=="txt") {
		
		}
		else
		{
			if(!confirm('This link shall take you to a page/website outside this website.'))
				return false;
		}
	}
  
    childWindow=window.open(file,windowmn,'width=800,height=500,screenX=100,screenY=0,scrollbars=yes,menubar=yes,location=yes,toolbar=yes,resizable=yes,addressbar=yes,top=100');
	childWindow.focus();
	return false;
}




//left menu slider

$(document).ready(function(){
function _init() {
    "use strict";
    $.AdminLTE.layout = {
        activate: function() {
            var a = this;
            a.fix(), a.fixSidebar(), $(window, ".wrapper").resize(function() {
                a.fix(), a.fixSidebar()
            })
        },
        fix: function() {
            var a = $(".main-header").outerHeight() + $(".main-footer").outerHeight(),
                b = $(window).height(),
                c = $(".sidebar").height();
            if ($("body").hasClass("fixed")) $(".content-wrapper, .right-side").css("min-height", b - $(".main-footer").outerHeight());
            else {
                var d;
                b >= c ? ($(".content-wrapper, .right-side").css("min-height", b - a), d = b - a) : ($(".content-wrapper, .right-side").css("min-height", c), d = c);
                var e = $($.AdminLTE.options.controlSidebarOptions.selector);
                "undefined" != typeof e && e.height() > d && $(".content-wrapper, .right-side").css("min-height", e.height())
            }
        },
        fixSidebar: function() {
            return $("body").hasClass("fixed") ? ("undefined" == typeof $.fn.slimScroll && window.console && window.console.error("Error: the fixed layout requires the slimscroll plugin!"), void($.AdminLTE.options.sidebarSlimScroll && "undefined" != typeof $.fn.slimScroll && ($(".sidebar").slimScroll({
                destroy: !0
            }).height("auto"), $(".sidebar").slimscroll({
                height: $(window).height() - $(".main-header").height() + "px",
                color: "rgba(0,0,0,0.2)",
                size: "3px"
            })))) : void("undefined" != typeof $.fn.slimScroll && $(".sidebar").slimScroll({
                destroy: !0
            }).height("auto"))
        }
    }, $.AdminLTE.tree = function(a) {
        var b = this,
            c = $.AdminLTE.options.animationSpeed;
        $(a).on("click", "li a", function(a) {
            var d = $(this),
                e = d.next();
            if (e.is(".treeview-menu") && e.is(":visible") && !$("body").hasClass("sidebar-collapse")) e.slideUp(c, function() {
                e.removeClass("menu-open")
            }), e.parent("li").removeClass("active");
            else if (e.is(".treeview-menu") && !e.is(":visible")) {
                var f = d.parents("ul").first(),
                    g = f.find("ul:visible").slideUp(c);
                g.removeClass("menu-open");
                var h = d.parent("li");
                e.slideDown(c, function() {
                    e.addClass("menu-open"), f.find("li.active").removeClass("active"), h.addClass("active"), b.layout.fix()
                })
            }
            e.is(".treeview-menu") && a.preventDefault()
        })
    }
}
if ("undefined" == typeof jQuery) throw new Error("AdminLTE requires jQuery");
$.AdminLTE = {}, $.AdminLTE.options = {
        navbarMenuSlimscroll: !0,
        navbarMenuSlimscrollWidth: "3px",
        navbarMenuHeight: "200px",
        animationSpeed: 500,
        sidebarToggleSelector: "[data-toggle='offcanvas']",
        sidebarPushMenu: !0,
        sidebarSlimScroll: !0,
        sidebarExpandOnHover: !1,
        enableBoxRefresh: !0,
        enableBSToppltip: !0,
        BSTooltipSelector: "[data-toggle='tooltip']",
        enableFastclick: !0,
        enableControlSidebar: !0,
        controlSidebarOptions: {
            toggleBtnSelector: "[data-toggle='control-sidebar']",
            selector: ".control-sidebar",
            slide: !0
        },
        enableBoxWidget: !0,
        boxWidgetOptions: {
            boxWidgetIcons: {
                collapse: "fa-minus",
                open: "fa-plus",
                remove: "fa-times"
            },
          
        },
        
       
    }, $(function() {
        "use strict";
        $("body").removeClass("hold-transition"), "undefined" != typeof AdminLTEOptions && $.extend(!0, $.AdminLTE.options, AdminLTEOptions);
        var a = $.AdminLTE.options;
        _init(), $.AdminLTE.layout.activate(), $.AdminLTE.tree(".sidebar"), a.enableControlSidebar && $.AdminLTE.controlSidebar.activate(), a.navbarMenuSlimscroll && "undefined" != typeof $.fn.slimscroll && $(".navbar .menu").slimscroll({
            height: a.navbarMenuHeight,
            alwaysVisible: !1,
            size: a.navbarMenuSlimscrollWidth
        }).css("width", "100%"), a.sidebarPushMenu && $.AdminLTE.pushMenu.activate(a.sidebarToggleSelector), a.enableBSToppltip && $("body").tooltip({
            selector: a.BSTooltipSelector
        }), a.enableBoxWidget && $.AdminLTE.boxWidget.activate(), a.enableFastclick && "undefined" != typeof FastClick && FastClick.attach(document.body), a.directChat.enable && $(document).on("click", a.directChat.contactToggleSelector, function() {
            var a = $(this).parents(".direct-chat").first();
            a.toggleClass("direct-chat-contacts-open")
        }), $('.btn-group[data-toggle="btn-toggle"]').each(function() {
            var a = $(this);
            $(this).find(".btn").on("click", function(b) {
                a.find(".btn.active").removeClass("active"), $(this).addClass("active"), b.preventDefault()
            })
        })
    }),
   
    
(jQuery);
});


//datepicker
 $('.datepicker').datepicker()
    .on(picker_event, function(e) {
        // `e` here contains the extra attributes
    }); 
	
	
	
	// Reset Font Size
$(document).ready(function(){

var originalFontSize = $('.RightSection').css('font-size');
$(".resetFont").click(function(){
$('.RightSection').css('font-size', originalFontSize);
});
// Increase Font Size
$(".increaseFont").click(function(){
  var currentFontSize = $('.RightSection').css('font-size');
  
  var currentFontSizeNum = parseFloat(currentFontSize, 2);
  
  var newFontSize = currentFontSizeNum*1.2;
  if(newFontSize <=24){
  $('.RightSection').css('font-size', newFontSize);
  return false;
  
  }

});
// Decrease Font Size
$(".decreaseFont").click(function(){
  var currentFontSize = $('.RightSection').css('font-size');
  var currentFontSizeNum = parseFloat(currentFontSize, 2);
  var newFontSize = currentFontSizeNum*0.8;
  if(newFontSize >=10){
  $('.RightSection').css('font-size', newFontSize);
  return false;
  }
});
});



//css change js
$(document).ready(function(){

var gCookie=readCookie('blackcss');
if(gCookie == "blackcss"){
   $('link[href="css/white-bg.css"]').attr('href','css/black-bg.css');
    
}
  
$('#blackBtn').click(function (){
  
 $('link[href="css/white-bg.css"]').attr('href','css/black-bg.css');
 
 createCookie('blackcss','blackcss',1);
});
$('#whiteBtn').click(function (){
 $('link[href="css/black-bg.css"]').attr('href','css/white-bg.css');
 createCookie('blackcss','blackcss',-1);
});

//color change js
function createCookie(name,value,days) {
  if (days) {
	  var date = new Date();
	  date.setTime(date.getTime()+(days*1*30*60*1000));
	  var expires = "; expires="+date.toGMTString();
  }
  else var expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
	  var c = ca[i];
	  while (c.charAt(0)==' ') c = c.substring(1,c.length);
	  if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}


});











	 