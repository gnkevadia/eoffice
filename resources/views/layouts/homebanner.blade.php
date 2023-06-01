
<!-- Slider start -->
<section class="slider-area-2 relative">
    <div class="owl-carousel slider-2">
    @if(isset($arrBanners) && !empty($arrBanners))
        @foreach($arrBanners as $keyBanner=>$valBanner)

        <div class="item">
            <div class="silder-img" style="background-image: url('{{ asset('images/banner/'.$valBanner->media_file) }}');" data-overlay="7">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-7 col-lg-8">
                            <div class="slider-content z-10">
                                <h5 class="line-head">
                            {{$valBanner->name}}
                        <span class="line  after"></span>
                        </h5>
                                <h1 class="banner-head-2 f-700 mt-25 mb-35 mt-xs-20 mb-xs-30">
                                {{$valBanner->sub_title}}</h1>
                                <a href="#" class="btn btn-square">{{$valBanner->button}}<i class="fas fa-long-arrow-alt-right ml-20"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    @endif
    </div>
    <div class="slide-social-outer transform-v-center z-5">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 w-100">
                    <div class="slide-social d-none d-lg-block">
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
        </div>
    </div>
    <div class="slider-control z-5">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-6">
                    <div class="dots-slider">

                    </div>
                </div>
                <div class="col-lg-6 text-right d-none d-lg-block">
                    <div class="nav-slider d-flex justify-content-end">
                        <a href="#" class="slider-btn slides-left flex-center">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <a href="#" class="slider-btn slides-right flex-center">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Slider end -->