@extends('layouts.default')
@section('content')
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================= -->
<!-- ============================================================= -->
<section class="about-us pt-5 pb-5">
    <div class="container">
        @if(isset($newsAndUpadte) && !empty($newsAndUpadte))
        <form action="/news-and-update" method="get">@csrf
        @else
        <form action="/data-inshights" method="get">@csrf
        @endif
            <div class="row pb-5">
                <div class="col-sm-4 text-center">
                    <div class="icon-box d-flex flex-column flex-lg-row align-items-center">
                        <div class="form-group">
                            <h5 class="f-700 mt-20 mb-5">Year</h5>
                            <select onchange="this.form.submit();" name="year" id="year" class="form-select">
                                <option value="0">Any</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 text-center">
                    <div class="icon-box d-flex flex-column flex-lg-row align-items-center">
                        <div class="form-group">
                            <h5 class="f-700 mt-20 mb-5">Month</h5>
                            <select onchange="this.form.submit();" name="month" id="month" class="form-select">
                                <option value="0">Any</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 text-center">
                    <div class="icon-box d-flex flex-column flex-lg-row align-items-center">
                        <div class="form-group">
                            <h5 class="f-700 mt-20 mb-5">Blog region</h5>
                            <select onchange="this.form.submit();" name="region" id="region" class="form-select">
                                <option value="0">All Regions</option>
                                @if(isset($arrRegions) && !empty($arrRegions))
                                @foreach($arrRegions as $key=>$val)
                                <option value="{{ $val['id'] }}" {{ old('parent_id') == $val['id'] ? 'selected' : '' }}>{{ $val['name'] }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<section class="services bg-light-white pt-30 pb-70 bg">
    <div class="container">
        <div class="row align-items-end  mb-45">
            <div class="col-lg-8 col-md-12 text-center text-lg-left">
                @if(isset($newsAndUpadte) && !empty($newsAndUpadte))
                <div class="fancy-head left-al">
                    <h2>News And Update</h2>
                </div>
                @else
                <div class="fancy-head left-al">
                    <h2>Data Inshights</h2>
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            @if(isset($pages) && !empty($pages))
            @foreach($pages as $key=>$val)
            <div class="col-lg-4 col-md-6">
                <div class="service-box type-2 transition-4 text-left relative img-lined mb-30">
                    @if(isset($newsAndUpadte) && !empty($newsAndUpadte))
                    <div class="service-icon-2 z-5">
                        <img src="{{ asset('images/news/'.$val->media_file) }}" class="transform-center" alt="">
                    </div>
                    @elseif(isset($industries) && !empty($industries))
                    <div class="service-icon-2 z-5">
                        <img src="{{ asset('images/news/'.$val->media_file) }}" class="transform-center" alt="">
                    </div>
                    @endif
                    <div class="service-text">
                        <h4 class="f-700 mt-20 mb-10">
                            @if(isset($newsAndUpadte) && !empty($newsAndUpadte))
                            <a href="{{$val->alias}}">{{$val->title}}</a>
                            @elseif(isset($industries) && !empty($industries))
                            <a href="{{$val->alias}}">{{$val->title}}</a>
                            @else
                            <a href="{{$val->alias}}">{{$val->page_name}}</a>
                            @endif
                        </h4>
                        <h6 class="f-700 mt-20 mb-10">
                            <?php $timestamp = strtotime($val->created_at);
                            $newDate = date('d-F-Y', $timestamp);
                            echo '<i class="fas fa-clock" style="padding-right: 5px;"></i>';
                            echo $newDate; //outputs 02-March-2011 
                            ?>
                        </h6>
                        <p>{!!\App\Library\Common::limitString($val->content, 200)!!}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-12">
                No data found.
            </div>
            @endif
        </div>
    </div>
    <div class="container d-flex justify-content-center">
        {!! $pages->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</section>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
@endsection
@section('FuelTrend_js')
<script type="text/javascript">
    $(document).ready(function() {
        if ($('.product__slider-main').length) {
            var $slider = $('.product__slider-main')
                .on('init', function(slick) {
                    $('.product__slider-main').fadeIn(1000);
                })
                .slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    autoplay: false,
                    lazyLoad: 'ondemand',
                    autoplaySpeed: 3000,
                    asNavFor: '.product__slider-thmb'
                });

            var $slider2 = $('.product__slider-thmb')
                .on('init', function(slick) {
                    $('.product__slider-thmb').fadeIn(1000);
                })
                .slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    lazyLoad: 'ondemand',
                    asNavFor: '.product__slider-main',
                    dots: false,
                    centerMode: false,
                    focusOnSelect: true
                });
        }

        $('nav a').on('click', function(event) {
            event.preventDefault();
            // current class
            $('nav li.current').removeClass('current');
            $(this).parent().addClass('current');

            // filter link text
            var category = $(this).text().toLowerCase().replace(' ', '-');

            // remove hidden class if "all" is selected
            if (category == 'all-images') {
                $('ul#gallery li:hidden').fadeIn('slow').removeClass('hidden');
            } else {
                $('ul#gallery li').each(function() {
                    if (!$(this).hasClass(category)) {
                        $(this).hide().addClass('hidden');
                    } else {
                        $(this).fadeIn('slow').removeClass('hidden');
                    }
                });
            }
            return false;
        });

        var $gallery = $('.gallery a').simpleLightbox();

        $gallery.on('show.simplelightbox', function() {
                console.log('Requested for showing');
            })
            .on('shown.simplelightbox', function() {
                console.log('Shown');
            })
            .on('close.simplelightbox', function() {
                console.log('Requested for closing');
            })
            .on('closed.simplelightbox', function() {
                console.log('Closed');
            })
            .on('change.simplelightbox', function() {
                console.log('Requested for change');
            })
            .on('next.simplelightbox', function() {
                console.log('Requested for next');
            })
            .on('prev.simplelightbox', function() {
                console.log('Requested for prev');
            })
            .on('nextImageLoaded.simplelightbox', function() {
                console.log('Next image loaded');
            })
            .on('prevImageLoaded.simplelightbox', function() {
                console.log('Prev image loaded');
            })
            .on('changed.simplelightbox', function() {
                console.log('Image changed');
            })
            .on('nextDone.simplelightbox', function() {
                console.log('Image changed to next');
            })
            .on('prevDone.simplelightbox', function() {
                console.log('Image changed to prev');
            })
            .on('error.simplelightbox', function(e) {
                console.log('No image found, go to the next/prev');
                console.log(e);
            });
    });

    jQuery(document).ready(function($) {
        $(".demo-accordion").accordionjs();
    });
</script>
@endsection