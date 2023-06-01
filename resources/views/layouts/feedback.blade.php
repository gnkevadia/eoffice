<section class="testimonials-2 pt-95 pb-95">
    <div class="container">
        <div class="row align-items-end mb-45">
            <div class="col-lg-7 col-md-12 text-center text-lg-left">
                <div class="fancy-head left-al  wow fadeInLeft">
                    <h5 class="line-head mb-15">
                        <span class="line before d-lg-none"></span>
                        Testimonials
                        <span class="line after"></span>
                    </h5>
                    <h1>We Love Our Clients</h1>
                </div>
            </div>
            <div class="col-lg-5 text-center text-lg-right">
                <div class="arrow-navigation mb-15 mt-md-20 wow fadeInRight">
                    <a href="#" class="nav-slide slide-left testi-2">
                        <img src="{{ asset('assets/img/icons/ar_lt.png') }}" alt="">
                    </a>
                    <a href="#" class="nav-slide slide-right testi-2">
                        <img src="{{ asset('assets/img/icons/ar_rt.png') }}" alt="">
                    </a>
                </div>
            </div>
            <div class="col-12">
                <div class="hr-2 bg-blue opacity-1 mt-45"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="owl-carousel owl-theme testimonial-2-slide  wow fadeIn">
                    @if(isset($arrFeedBack) && !empty($arrFeedBack))
                    @foreach($arrFeedBack as $keyFeedBack=>$arrFeedBack)
                    <div class="item">
                        <div class="each-quote-2 pr-40 pr-sm-00">
                            <ul class="stars-rate mb-5" data-starsactive="5">
                                <li class="text-md-left text-center">
                                    <?php $value = $arrFeedBack->star;
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($value >= $i) {
                                            echo '<i class="fas fa-star"></i>';
                                        } else {
                                            echo '<i class="far fa-star"></i>';
                                        }
                                    }
                                    ?>
                                </li>
                            </ul>
                            <h4 class="italic f-700 mb-20">{{ $arrFeedBack->title }}</h4>
                            <p class="mb-35">{{ $arrFeedBack->description }}</p>
                            <div class="client-2-img d-flex align-items-center justify-content-md-start justify-content-center">
                                <div class="img-div mr-30 pb-10">
                                    <div class="client-image">
                                        <img src="{{ asset('images/feedback/'.$arrFeedBack->media_file) }}" class=" rounded-circle" alt="">
                                    </div>
                                </div>
                                <div class="client-text-2 mb-10">
                                    <h6 class="client-name green fs-17 f-700">{{ $arrFeedBack->name }}</h6>
                                    <p class="mb-0 fs-13 f-500">{{ $arrFeedBack->company }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>