<?php
session_start();
?>
<style>
    .modal-dialog {
        margin: 1.75em auto;
        min-height: calc(100vh - 60px);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    #myModal .close {
        position: absolute;
        right: 0.3rem;
    }

    .g-recaptcha div {
        margin: auto;
    }

    .modal-body .contact_form input[type='radio'] {
        width: auto;
        height: auto;
    }
    .modal-body .contact_form textarea{
        background-color: #eeeeee;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 10px;
        width: 100%;
        border: none
    }

    @media (max-width: 768px) {
        .modal-dialog {
            min-height: calc(100vh - 20px);
        }

        #myModal .modal-body {
            padding: 15px;
        }
    }

</style>
@if(!auth()->check())
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top:2px!important;">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                 <div class="modal-header backgroud-style">

                    <div class="gradient-bg"></div>
                    <div class="popup-logo">
                        <img src="{{asset('assets/images/nic1.png')}}" alt="">
                    </div>
                    <div class="popup-text text-center">
                        @if(isset($logo))
                        <p><img src="{{asset('assets/images/'.$logo)}}"></p>
                        @else
                        <p><img src="{{asset('assets/images/nic.png')}}"></p>
                        @endif
                    </div>
                   

                </div>

                <!-- Modal body --> 
                <div class="modal-body">
                    <div class="tab-content">
                        <div class="tab-pane container active" id="login">

                            <span class="error-response text-danger"></span>
                            <span class="success-response text-success"></span>
                            <form class="contact_form" id="loginForm" action="{{route('frontend.auth.login.post')}}"
                                  method="POST" enctype="multipart/form-data">
                                
                                <div class="contact-info mb-2">
                                    {{ html()->email('email')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.email'))
                                        ->attribute('maxlength', 191)
									    ->id('currentemail')
                                        }}
                                    <span id="login-email-error" class="text-danger"></span>

                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->password('password')
                                                     ->class('form-control mb-0')
                                                     ->placeholder(__('validation.attributes.frontend.password'))
									               
                                                    }}
                                    <span id="login-password-error" class="text-danger"></span>

                                    <!--<a class="text-info p-0 d-block text-right my-2"
                                       href="{{ route('frontend.auth.password.reset') }}">@lang('labels.frontend.passwords.forgot_password')</a>-->
									<a id="thispwd" class="text-info p-0 d-block text-right my-2"
                                       href="javascript:void(0);">@lang('labels.frontend.passwords.forgot_password')</a>

                                </div>
                                @if(config('access.captcha.registration')) 
                                    <div class="contact-info mb-2 text-center">
                                        {!! Captcha::display() !!}
                                        {{ html()->hidden('captcha_status', 'true') }}
                                        <span id="login-captcha-error" class="text-danger"></span>

                                    </div>
                                @endif
                                <!--  <div class="g-recaptcha" data-sitekey={{env('CAPTCHA_KEY')}}>
                                    @if($errors->has('g-recaptcha-response'))
                                    <span class="invalid-feedback" style="display:block;">
                                    <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                                    </span>>
                                    @endif

                                </div> --> 
                               <!--  <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="g-recaptcha" name="recaptcha" data-sitekey="6LclNRYUAAAAAI8HLafTTURqM4-kW01Swrdcp45c"></div>
                                        @if($errors->has('g-captcha-response'))
                                            <span class="invalid-feedback" style="display: block;">
                                                <strong>{{$errors->first('g-captcha-response')}}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div> -->

                                <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" type="submit" id="btnSubmit" value="Submit">
                                Login
                            </button>
                        </div>
                    </div>
                            </form>

							<!----------------------forgotpassword start------------------------------------>
							
                            <div id="forgotpwd" class="text-center" style="display:none;">
								<form class="contact_form" id="" action="{{route('frontend.auth.password.email.post')}}"
                                  method="POST" enctype="multipart/form-data">
									   {{ csrf_field() }} 
								
								<div class="contact-info mb-2">
                                    {{ html()->email('email')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.email'))
                                        ->attribute('maxlength', 191)
									    ->id('forgotpwdemail')
                                        }}

                                </div>
								
								<div class="container-login100-form-btn">
								<div class="wrap-login100-form-btn">
									<div class="login100-form-bgbtn"></div>
									<button class="login100-form-btn" type="submit" id="btnSubmit" value="Submit">
										{{__('labels.frontend.passwords.send_password_reset_link_button')}}
									</button>
								</div>
							</div>
							 </form>
                            </div>

							<!----------------------forgotpassword end------------------------------------>
                        </div>
                        <div class="tab-pane container fade" id="register">

                            <form id="registerForm" class="contact_form"
                                  action="#"
                                  method="post">
                                {!! csrf_field() !!}
                                <a href="#"
                                   class="go-login float-right text-info pr-0">@lang('labels.frontend.modal.already_user_note')</a>
                                <div class="contact-info mb-2">


                                    {{ html()->text('first_name')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.first_name'))
                                        ->attribute('maxlength', 191) }}
                                    <span id="first-name-error" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->text('last_name')
                                      ->class('form-control mb-0')
                                      ->placeholder(__('validation.attributes.frontend.last_name'))
                                      ->attribute('maxlength', 191) }}
                                    <span id="last-name-error" class="text-danger"></span>

                                </div>

                                <div class="contact-info mb-2">
                                    {{ html()->email('email')
                                       ->class('form-control mb-0')
                                       ->placeholder(__('validation.attributes.frontend.email'))
                                       ->attribute('maxlength', 191)
                                       }}
                                    <span id="email-error" class="text-danger"></span>

                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->password('password')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.password'))
                                         }}
                                    <span id="password-error" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->password('password_confirmation')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                         }}
                                </div>
                                @if(config('registration_fields') != NULL)
                                    @php
                                        $fields = json_decode(config('registration_fields'));
                                        $inputs = ['text','number','date'];
                                    @endphp
                                    @foreach($fields as $item)
                                        @if(in_array($item->type,$inputs))
                                            <div class="contact-info mb-2">
                                                <input type="{{$item->type}}" class="form-control mb-0" value="{{old($item->name)}}" name="{{$item->name}}"
                                                       placeholder="{{__('labels.backend.general_settings.user_registration_settings.fields.'.$item->name)}}">
                                            </div>
                                        @elseif($item->type == 'gender')
                                            <div class="contact-info mb-2">
                                                <label class="radio-inline mr-3 mb-0">
                                                    <input type="radio" name="{{$item->name}}" value="male"> {{__('validation.attributes.frontend.male')}}
                                                </label>
                                                <label class="radio-inline mr-3 mb-0">
                                                    <input type="radio" name="{{$item->name}}" value="female"> {{__('validation.attributes.frontend.female')}}
                                                </label>
                                                <label class="radio-inline mr-3 mb-0">
                                                    <input type="radio" name="{{$item->name}}" value="other"> {{__('validation.attributes.frontend.other')}}
                                                </label>
                                            </div>
                                        @elseif($item->type == 'textarea')
                                            <div class="contact-info mb-2">

                                            <textarea name="{{$item->name}}" placeholder="{{__('labels.backend.general_settings.user_registration_settings.fields.'.$item->name)}}" class="form-control mb-0">{{old($item->name)}}</textarea>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif

                                @if(config('access.captcha.registration'))
                                    <div class="contact-info mt-3 text-center">
                                        {!! Captcha::display() !!}
                                        {{ html()->hidden('captcha_status', 'true')->id('captcha_status') }}
                                        <span id="captcha-error" class="text-danger"></span>

                                    </div><!--col-->
                                @endif


                                <div class="contact-info mb-2 mx-auto w-50 py-4">
                                    <div class="nws-button text-center white text-capitalize">
                                        <button id="registerButton" type="submit"
                                                value="Submit">@lang('labels.frontend.modal.register_now')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
@endif

@push('after-scripts')
    @if(config('access.captcha.registration'))
        {!! Captcha::script() !!}
    @endif
    <script src="http://103.101.59.95/vidyakosh/public/assets/js/jquery.base64.min.js"></script> 
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function () {
                $(document).on('click', '.go-login', function () {
                    $('#register').removeClass('active').addClass('fade')
                    $('#login').addClass('active').removeClass('fade')

                });
                $(document).on('click', '.go-register', function () {
                    $('#login').removeClass('active').addClass('fade')
                    $('#register').addClass('active').removeClass('fade')
                });

                $(document).on('click', '#openLoginModal', function (e) {
                    $.ajax({
                        type: "GET",
                        url: "{{route('frontend.auth.login')}}",
                        success: function (response) {
                            $('#socialLinks').html(response.socialLinks)
                            $('#myModal').modal('show');
                        },
                    });
                });

                $('#loginForm').on('submit', function (e) {
                    e.preventDefault();

                    var $this = $(this);
                    var dataArr = $this.serializeArray();
                     var email = dataArr[0]['value'];
                     var passwd = $.base64.encode(dataArr[1]['value']);

                    $.ajax({
                        type: $this.attr('method'),
                        url: $this.attr('action'),
//                        data: $this.serializeArray(),
                        data: {
                            email    : email,
                            password : passwd
                        },
                        dataType: $this.data('type'),
                        success: function (response) {
                            $('#login-email-error').empty();
                            $('#login-password-error').empty();
                            $('#login-captcha-error').empty();
							$('#thispwd').val('');
                            if (response.errors) {
								
                                if (response.errors.email) {
                                    $('#login-email-error').html(response.errors.email[0]);
                                }
                                if (response.errors.password) {
                                    $('#login-password-error').html(response.errors.password[0]);
								
                                }

                                var captcha = "g-recaptcha-response";
                                if (response.errors[captcha]) {
                                    $('#login-captcha-error').html(response.errors[captcha][0]);
                                }
                            }
                            if (response.success) {
                                $('#loginForm')[0].reset();
                                if (response.redirect == 'back') {
                                    location.reload();
                                } else {
                                    window.location.href = "{{route('admin.dashboard')}}"
                                }
                            }
                        },
                        error: function (jqXHR) {
								$('#thispwd').val('');
                            var response = $.parseJSON(jqXHR.responseText);
                            console.log(jqXHR)
                            if (response.message) {
                                $('#login').find('span.error-response').html(response.message)
								
                            }
                        }
                    });
                });

                $(document).on('submit','#registerForm', function (e) {
                    e.preventDefault();
                    console.log('he')
                    var $this = $(this);

                    $.ajax({
                        type: $this.attr('method'),
                        url: "{{  route('frontend.auth.register.post')}}",
                        data: $this.serializeArray(),
                        dataType: $this.data('type'),
                        success: function (data) {
                            $('#first-name-error').empty()
                            $('#last-name-error').empty()
                            $('#email-error').empty()
                            $('#password-error').empty()
                            $('#captcha-error').empty()
                            if (data.errors) {
								
                                if (data.errors.first_name) {
                                    $('#first-name-error').html(data.errors.first_name[0]);
                                }
                                if (data.errors.last_name) {
                                    $('#last-name-error').html(data.errors.last_name[0]);
                                }
                                if (data.errors.email) {
                                    $('#email-error').html(data.errors.email[0]);
                                }
                                if (data.errors.password) {
                                    $('#password-error').html(data.errors.password[0]);
                                }

                                var captcha = "g-recaptcha-response";
                                if (data.errors[captcha]) {
                                    $('#captcha-error').html(data.errors[captcha][0]);
								
                                }
                            }
                            if (data.success) {
                                $('#registerForm')[0].reset();
                                $('#register').removeClass('active').addClass('fade')
                                $('.error-response').empty();
                                $('#login').addClass('active').removeClass('fade')
                                $('.success-response').html("@lang('labels.frontend.modal.registration_message')");
                            }
                        }
                    });
                });
            });
		//----------------------------------forgot password start------------------------------//	
			$('#thispwd').click(function(){
            $("#forgotpwd").show();
		    $("#loginForm").hide();
		    var email = $("#currentemail").val();
				$("#forgotpwdemail").val(email);
   //----------------------------------forgot password end------------------------------//	
				
 });

        });
    </script>
    <script>
if(grecaptcha && grecaptcha.getResponse().length > 0)
var checkCaptch = false;
     var verifyCallback = function(response) {
        if (response == "") {
             checkCaptch = false;
         }
         else {
             checkCaptch = true;
         }
     };
     $(document).ready(function() {
         $("#btnSubmit").click(function() {
             if (checkCaptch && grecaptcha.getResponse()!="") {
                  //Write your success code here
             }
         });
     })


</script>
@endpush
