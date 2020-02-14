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



//$(document).ready(function(){
//	$('.showBox-1').hover(function(){
//		$('.showBoxPanel-1').fadeIn( 500 );
//		});
//		
//		$('.showBoxInner-1').hover(function(){
//		$('.showBoxInnerPanel-1').fadeIn( 500 );
//		});
//	
//});
	

/*effect on hover js*/



$(document).ready(function(){
//	$('.showBox-2').hover(function(){
//		$('.showBoxPanel-2').fadeIn( 500 );
//		$('.showBoxPanel-1').hide();
//		$('.showBoxInnerPanel-2').hide();
//		});
//		
//		$('.showBoxInner-2').hover(function(){
//		$('.showBoxInnerPanel-2').fadeIn( 500 );
//			$('.showBoxInnerPanel-1').hide();
//
//		});
	
	});

//$("#box2").hover(function(){
//  $("#new1, #new2 ,#new3 ,#new4 , #smallBox1 ,#smallBox2, #smallBox3, #smallBox4").hide();
//	 $("#LineOne, #LineTwo, #LineThree ,#FristSio ,#SecondSio").show();
//});
//
//$("#box1").hover(function(){
//	 $("#LineOne, #LineTwo, #LineThree ,#FristSio ,#SecondSio").hide();
//	 $("#new1, #new2 ,#new3 ,#new4 , #smallBox1 ,#smallBox2, #smallBox3, #smallBox4").show();
// 
//});

//$(".tabContainer").hover(function(){
//  $("#new1, #new2 ,#new3 ,#new4 , #smallBox1 ,#smallBox2, #smallBox3, #smallBox4 ,#LineOne, #LineTwo, #LineThree ,#FristSio ,#SecondSio").hide();
//	
//});
	

//------------------------form validator--------------------------------------------//
$(document).ready(function(){ 
jQuery(function ($) {
        $.validator.addClassRules({
            validate_min_number: {
                number: true,
                min: 1
            },
            validate_number: {
                number: true,
                minlength: 1,
                maxlength: 10
            },
            validate_digits: {
                number: true,
                minlength: 1,
                maxlength: 25
            },
            validate_cin: {
                pattern: /^\s*[a-zA-Z0-9,\s]+\s*$/,
                minlength: 21,
                maxlength: 21
            },
            validate_percentage: {
                number: true,
                range: [0, 99]
            },
            validate_pincode: {
                digits: true,
                minlength: 6,
                maxlength: 6
            },
            validate_pan: {
                minlength: 10,
                maxlength: 10
            },
            validate_ifsc: {
                minlength: 11,
                maxlength: 11
            },
            validate_aadhar: {
                digits: true,
                minlength: 12,
                maxlength: 12
            },
            validate_insurance: {
                number: true,
                maxlength: function(element){
                    
                }
            },
            validate_alphabets: {
                pattern:/^\s*[a-zA-Z,\s]+\s*$/
              //  pattern: /^[ A-Za-z0-9_@.,/#&+-]*$/
            },
            validate_text: {
                //pattern:/^\s*[a-zA-Z,\s]+\s*$/
                pattern: /^[ A-Za-z]/
            }
        });

        $('.validate_number, .validate_digits, .validate_percentage').on('focus', function(){
            if($(this).val() == '0'){
                $(this).val('');
            }
        });
        $('.validate_number, .validate_digits, .validate_percentage').on('blur', function(){
            if($(this).val() == ''){
                $(this).val('0');
            }
        });
        
        $('[data-rel=tooltip]').tooltip({container:'body'});

        $(".validate_pan").mask('aaaaa9999a');
        $(".validate_ifsc").mask('aaaa*******');
        $("#experian_model_otp_input").mask('999999');
        $(".validate_cin").mask('*********************');
        $('#dealer_current_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
        $('.date-picker-all').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
        $('.input-daterange').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
        $('.date-picker-new').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
        $('.date-picker_noday').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
        $('.date-picker-fut').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
        $('.date-picker').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
        $('#applicant_driving_license_expiry_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
        $('.dealer_incorporation_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});

        $('.ace-input-file').ace_file_input({
            no_file: 'No File ...',
            btn_choose: 'Choose',
            btn_change: 'Change',
            droppable: false,
            onchange: null,
            thumbnail: false,
            allowExt: 'gif|png|jpg|jpeg|pdf',
            allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'application/pdf'],
        });
    });
	 });
