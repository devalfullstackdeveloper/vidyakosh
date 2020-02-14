  
  
  
<!-- ================================
         END FOOTER AREA
================================= -->
<section class="footer-area">
    <div class="ocean">
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="footer-widget">
                    <a  href="{{url('/')}}">
                        <img src="{{asset('assets/images/logo2.png')}}" alt="footer logo" class="footer__logo">
                    </a>
                    <ul class="footer-address">
                        <li><a href="tel:01124305930">011-24305930</a></li>
                        <li><a href="mailto:vidya.kosh@nic.in" class="mail" style="text-transform: unset;">vidya.kosh@nic.in</a></li>
                        <li>A-Block, CGO Complex, Lodhi Road, New Delhi - 110 003,<br>India</li>
                    </ul>
                    <ul class="footerSocial">
                        <li>
                            <a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-google-plus"></i></a>
                        </li>
                    </ul>
                </div><!-- end footer-widget -->
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 col-sm-6">
                <div class="footer-widget">
                    <h3 class="footer-title">Quick Links</h3>
                    <span class="section__divider"></span>
                    <ul class="footer-link">
                     <li><a href="{{url('/')}}">Home</a></li>
                        <li><a href="{{url('aboutus')}}">About us</a></li>
                        <li><a href="{{url('courses')}}">Courses</a></li>
                        <li><a href="{{url('contactus')}}">Contact Us</a></li>                        
                        <!--<li><a href="{{url('support')}}">Support</a></li>-->
                    </ul>
                </div><!-- end footer-widget -->
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 col-sm-6">
                <div class="footer-widget">
                    <h3 class="footer-title">Important Links</h3>
                    <span class="section__divider"></span>
                    <ul class="footer-link">
                        <li><a href="{{url('privacy')}}">Website Policy  </a></li>
                        <li><a href="{{url('terms')}}">Terms of Use</a></li>
                        <li><a href="{{url('feedback')}}">Feedback</a></li>
                        <li><a href="{{url('sitemap')}}">Site Map</a></li>
                        <!--<li><a href="{{url('disclaimer')}}">Disclaimer</a></li>-->
                      
                    </ul>
                </div><!-- end footer-widget -->
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 col-sm-6">
                <div class="footer-widget">
                   <!--  <h3 class="footer-title">mobile</h3> 
                    <span class="section__divider"></span> -->
                    <ul class="footer-link social-link">
						@if(isset($lastupdateddate))
                        <li><a><i class="la la-calendar"></i> Last Updated on <span style="font-size:16px; margin-top:7px;">{{date('d-m-Y', strtotime($lastupdateddate->created_at))}}</span></a></li>
						@endif
						@if(isset($visitor))
                        <li><a><i class="la la-eye"></i> Visitor Count <br><span style="font-size:16px; margin-top:7px;">{{$visitor}}</span></a></li>
						@endif
                    </ul>
                </div><!-- end footer-widget -->
            </div><!-- end col-lg-3 -->
        </div><!-- end row -->
        <div class="row copyright-content align-items-center">
            <div class="col-lg-10">
                <p class="copy__desc">&copy; <?php echo date("Y"); ?> Vidyakosh. All Rights Reserved. National Informatics Centre, Ministry of Electronics & IT (MeitY).</p>
            </div><!-- end col-lg-9 -->
            <div class="col-lg-2">
                <div class="language-select">
                    <select class="target-lang">
                        <option value="1">English</option>
                      
                     
                        <option value="4">Français</option>
                      
                        <option value="17">Hindi</option>
                    </select>
                </div>
            </div>
        </div><!-- end copyright-content -->
		
    </div><!-- end container -->
</section><!-- end footer-area -->
<!-- ================================
          END FOOTER AREA
================================= -->