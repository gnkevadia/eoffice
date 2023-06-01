@extends('layouts.default')
@section('content')
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
@if(!in_array(Request::path(),array('santa-claus','goodies','elf')))
  @if($pages->page_id != 44)
    <div class="inner_banner_wrapper"> <img src="{{$featureImage}}" class="inner_banner_desktop" alt="">
      @if(isset($m_media_file) && !empty($m_media_file))
        <img src="{{$featureImageMobile}}" class="inner_banner_mobile" alt="">
      @else
        <img src="{{$featureImageMobile}}" class="inner_banner_mobile" alt="">
      @endif
      <div class="container">
        <div class="innner_banner_main">
          @if(!empty($pages->page_name))
          <div class="row align-items-end  mb-45">
            <div class="col-lg-8 col-md-12 text-center text-lg-left">
                <div class="fancy-head left-al">
                  <h2>{!! $pages->page_name !!}</h2>
                </div>
            </div>
          </div>
          @else
          <div class="row align-items-end  mb-45">
            <div class="col-lg-8 col-md-12 text-center text-lg-left">
                <div class="fancy-head left-al">
                  <h2>{!! $pages->title !!}</h2>
                </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  @endif
@endif

@if($pages->parent_id == 2)
  {!! $pages->content !!}
  @include('layouts.request')
@elseif($pages->category == 3)
  <section class="about-us pb-100">
    <div class="container">
      <div class="row align-items-end  mb-45">
          <div class="col-lg-7 col-md-12 text-center text-lg-left">
            <div class="fancy-head left-al">
              <h2>{{$pageName}}</h2>
            </div>
          </div>
       </div>
      <div class="row align-items-xl-center">
        <div class="col-lg-6">
          <div class="relative bg-blue mx-auto shadow-1" style="height: 100px; width: 400px;">
            <img src="{{ asset('images/package/'.$pages->media_file) }}" class="transform-center" alt="">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="about-text mt-md-60 text-center text-lg-left wow fadeInRight">
            {!! $pages->detail_description !!}<br>
            @if($pages->inquire == 0)
            <h6>Please log in to purchase this product.</h6><br>
            @if(!empty(Session::get('email')))
              <a href="/custom-reports" class="btn btn-square-green d-block d-sm-inline-block blob-small wow fadeInUp">Buy Custom Trend</a>
              <a href="#" class="btn btn-square-green d-block d-sm-inline-block blob-small wow fadeInUp">@csrf
                Buy Industry Trend
              </a>
            @else
              <a href="/log-in" class="btn btn-square-green d-block d-sm-inline-block blob-small wow fadeInUp">@csrf
                <i class="fas fa-sign-in-alt mr-15"></i>LOGIN
              </a>
              <a href="sign-up" class="btn btn-square-green d-block d-sm-inline-block blob-small wow fadeInUp">@csrf
                  <i class="fas fa-registered mr-15"></i>REGISTER
              </a>
            @endif
            @endif
          </div>
        </div>
      <div>
    </div>
  </section>
  @if($pages->inquire != 0)
    @include('layouts.request')
  @endif
@else
  @if($pages->page_id != 44)
    <div class="container">
        {!! $pages->content !!}
    </div>
  @else
    {!! $pages->content !!}
    @include('layouts.contact');
  @endif
@endif
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
@endsection
@section('FuelTrend_js')
<script type="text/javascript">
    $( document ).ready(function() {
      if ( $('.product__slider-main').length ) {
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

      $('nav a').on('click', function(event){
        event.preventDefault();
        // current class
        $('nav li.current').removeClass('current');
        $(this).parent().addClass('current');

        // filter link text
        var category = $(this).text().toLowerCase().replace(' ', '-');
        
        // remove hidden class if "all" is selected
        if(category == 'all-images'){
            $('ul#gallery li:hidden').fadeIn('slow').removeClass('hidden');
        } else {
            $('ul#gallery li').each(function(){
               if(!$(this).hasClass(category)){
                   $(this).hide().addClass('hidden');
               } else {
                   $(this).fadeIn('slow').removeClass('hidden');
               }
            });
        }
        return false;        
    });

      var $gallery = $('.gallery a').simpleLightbox();

		$gallery.on('show.simplelightbox', function(){
			console.log('Requested for showing');
		})
		.on('shown.simplelightbox', function(){
			console.log('Shown');
		})
		.on('close.simplelightbox', function(){
			console.log('Requested for closing');
		})
		.on('closed.simplelightbox', function(){
			console.log('Closed');
		})
		.on('change.simplelightbox', function(){
			console.log('Requested for change');
		})
		.on('next.simplelightbox', function(){
			console.log('Requested for next');
		})
		.on('prev.simplelightbox', function(){
			console.log('Requested for prev');
		})
		.on('nextImageLoaded.simplelightbox', function(){
			console.log('Next image loaded');
		})
		.on('prevImageLoaded.simplelightbox', function(){
			console.log('Prev image loaded');
		})
		.on('changed.simplelightbox', function(){
			console.log('Image changed');
		})
		.on('nextDone.simplelightbox', function(){
			console.log('Image changed to next');
		})
		.on('prevDone.simplelightbox', function(){
			console.log('Image changed to prev');
		})
		.on('error.simplelightbox', function(e){
			console.log('No image found, go to the next/prev');
			console.log(e);
		});
    });
    
		jQuery(document).ready(function($){
			$(".demo-accordion").accordionjs();
		});
	
</script> 
@endsection