<footer class="footer-area">
    <div class="container">
        <div class="row mb-sm-50 mb-xs-00">
            <div class="col-lg-4 z-5">
                <div class="contact-area relative h-100 mr-lg-20 mr-md-00">
                    <div class="footer-logo mb-35">
                        <img src="{{ asset('assets/img/logo/logo_footer.png') }}" alt="">
                    </div>
                    <div class="contact-options mb-35">
                        <ul>
                            <li>
                                <i class="fas fa-map-marker-alt green"></i>4221 Melrose Street,Yakima, Washington
                            </li>
                            <li>
                                <i class="fas fa-phone green"></i>(1) 234 456 89
                            </li>
                            <li>
                                <i class="fas fa-envelope green"></i>info@example.com
                            </li>
                        </ul>
                    </div>
                    <div class="social-links">
                        <ul class="social-icons">
                            <li>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-google-plus-g"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4">
                <div class="footer-links pt-85 pt-md-50 mb-sm-70">
                    <h5 class="green f-700 mb-35">Industries we serve</h5>
                    <ul class="links-list">
                        <li><a href="/hotels">Hotels</a></li>
                        <li><a href="/tourism">Tourism</a></li>
                        
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4">
                <div class="footer-links pt-85 pt-md-50 mb-sm-70">
                    <h5 class="green f-700 mb-35">Data Insights</h5>
                    <ul class="links-list">
                        <li><a href="/data-inshights-blog">Data Insights Blog</a></li>
                        <li><a href="/whitepapers">Whitepapers</a></li>
                        <li><a href="/glossary">Glossary</a></li>
                        <li><a href="/faq">FAQ</a></li>
                        <li><a href="/documents">Documents</a></li>
                        <li><a href="/case-studies">Case Studies</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-sm-4">
                <div class="footer-links pt-85 pt-md-50 mb-50" >
                    <h5 class="green f-700 mb-35">quick Links</h5>
                    <ul class="links-list">
                        <li><a href="/data-solutions">Data Solutions</a></li>
                        <li><a href="/data-inshights">Data Insights</a></li>
                        <li><a href="/about-us">About us</a></li>
                        <li><a href="/contact">Contact</a></li>
                        <li><a href="/events">Events</a></li>
                        <li><a href="/media">Media</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section class="copyright pt-25 pb-25">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-8">
                    <p class="mb-0 white">© Copyrights 2022 Fule Trend All rights reserved</p>
                </div>
                <div class="col-xl-4 text-right">
                    <a href="#" class="btn scroll-btn f-right flex-center z-25 opacity-0">
                        <i class="fas fa-arrow-up"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</footer>
<!-- JS Files -->
<script src="{{ asset('assets/js/modernizr-3.5.0.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('assets/js/lightslider.min.js') }}"></script>
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.meanmenu.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<!-- JS Files end -->
@yield('footerScript')