<footer class="footer-modern">

    <div class="footer-main">
        <div class="container">
            <div class="row g-4">

                <!-- Quick Links -->
                <div class="col-sm-6 col-lg-3">
                    <h5 class="footer-title">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Terms Of Use</a></li>
                    </ul>
                </div>

                <!-- Jobs By Functional Area -->
                <div class="col-sm-6 col-lg-3">
                    <h5 class="footer-title">Jobs By Functional Area</h5>
                    <ul class="footer-links">
                        <li><a href="#">Marketing</a></li>
                        <li><a href="#">Graphic Design</a></li>
                        <li><a href="#">Business Management</a></li>
                        <li><a href="#">Software & Web Development</a></li>
                        <li><a href="#">Admin</a></li>
                        <li><a href="#">Database Administration</a></li>
                        <li><a href="#">Advertising</a></li>
                        <li><a href="#">Web Developer</a></li>
                    </ul>
                </div>

                <!-- Jobs By Industry -->
                <div class="col-sm-6 col-lg-3">
                    <h5 class="footer-title">Jobs By Industry</h5>
                    <ul class="footer-links">
                        <li><a href="#">Courier/Logistics</a></li>
                        <li><a href="#">Travel/Tourism/Transportation</a></li>
                        <li><a href="#">Fashion</a></li>
                        <li><a href="#">Electronics</a></li>
                        <li><a href="#">Automobile</a></li>
                        <li><a href="#">Advertising/PR</a></li>
                        <li><a href="#">Health & Fitness</a></li>
                        <li><a href="#">Information Technology</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-sm-6 col-lg-3">
                    <h5 class="footer-title">Contact Us</h5>
                    <ul class="footer-contact">
                        <li>
                            <i class="fa fa-map-marker"></i>
                            651 N Broad St, Suite 201, Middletown, Delaware, USA
                        </li>
                        <li>
                            <i class="fa fa-envelope"></i>
                            <a href="mailto:info@jobsportal.com">
                                info@jobsportal.com
                            </a>
                        </li>
                        <li>
                            <i class="fa fa-phone"></i>
                            <a href="tel:+13025550123">
                                +1 (302) 555-0123
                            </a>
                        </li>
                    </ul>

                    <!-- Social -->
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-x-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content d-flex justify-content-between align-items-center flex-wrap">

                <div class="footer-copy">
                    Copyright &copy; {{ date('Y') }} Job Portal.
                    All rights reserved.
                </div>

                <div class="footer-payments">
                    <img src="{{ asset('images/payment-icons.png') }}" alt="Payment methods">
                </div>

            </div>
        </div>
    </div>

</footer>
