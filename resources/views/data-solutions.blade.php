@extends('layouts.default')
@section('content')
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================= -->
<section>
  <div class="bg-light-white border rounded-5">
    <section class="p-4">
      <div class="tab-content" id="ex1-content">
        <div class="container">
          <div class="row align-items-end  mb-45">
            <div class="col-lg-7 col-md-12 text-center text-lg-left">
              <div class="fancy-head left-al">
                <h2>Data Solutions</h2>
              </div>
            </div>
          </div>
          <div class="row">
            @if(isset($pages) && !empty($pages))
              @foreach($pages as $key=>$val)
                <div class="col-lg-4 col-md-6">
                  <div class="service-box type-2 transition-4 text-left relative img-lined mb-30">
                    <div class="service-icon-2 z-5">
                      <img src="{{ asset('images/package/'.$val->media_file) }}" class="transform-center" alt="">
                    </div>
                    <div class="service-text">
                      <h6 class="f-700 mt-20 mb-10" style="color: #e33689;">
                        {{$val->heading}}
                      </h6>
                    </div>
                    <div class="service-text">
                      <h4 class="f-700 mt-20 mb-10">
                        <?php Session::put('package_id', $val->id); ?>
                        <a href="{{$val->alias}}">{{$val->name}}</a>
                      </h4>
                      <p>{!!\App\Library\Common::limitString($val->description, 200)!!}</p>
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
      </div>
    </section>
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