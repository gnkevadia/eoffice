<script type="text/javascript" src="{{ asset('assets/js/modernizr-3.5.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-1.12.4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/lightslider.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/wow.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.meanmenu.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js"></script> 

<!-- <script type="text/javascript"> 
	$(document).ready(function (event) {
			$('.number').keypress(function (event) {
				var keycode = event.which;
				if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
					event.preventDefault();
				}
			});
			$('.avoidspace').keypress(function (event) {
				var k = event ? event.which : window.event.keyCode;
				if (k == 32) return false;
			});
			function isEmail(email) {
				var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				return regex.test(email);
			}
			$("#element").introLoader({
				animation: {
					name: 'gifLoader',
					options: {
						ease: "easeInOutCirc",
						style: 'light',
						delayBefore: 1000,
						exitTime: 3000
					}
				}
			});

			/******************** menu *****************************/
			$('.menu-icon').click(function () {
				$(this).toggleClass("menu-active");
				$('.menu').slideToggle('slow');
			});
			$('.menu ul li:has(ul)').prepend('<span class="arrow"></span>');
			$('.arrow').click(function () {
				$(this).siblings('ul.sub_menu').slideToggle('slow');
				$(this).toggleClass('minus');
			});
			if ($(window).width() < 1199) {
				$('.menu ul li:has(ul)').addClass('has-sub');
				$(".has-sub a").click(function () {
					$(this).toggleClass("");
					$(this).siblings("ul.sub_menu").slideToggle('slow');
				});
			}
			
			if('{{Session::get("city_name")}}' != ''){
				$('#citymodal').modal('hide');
				$(".city_dropdown a").text('{{Session::get("city_name")}}');
			}else{
				$('#citymodal').modal({
					backdrop: 'static',
					keyboard: false
				});
				$(".city_dropdown a").text('Select City');	
			}
			$('.city_dropdown').click(function(){
				$('#citymodal').modal({
					backdrop: 'static',
					keyboard: false
				});
			});
			$('.city_dropdown_menu').click(function(){
				$('#citymodal').modal({
					backdrop: 'static',
					keyboard: false
				});
			});
			$('.pickcity').click(function(){
				window.location.href = "{{ url('/') }}?city_id="+$(this).attr('data-id')+"&city_name="+$(this).attr('data-name');
			});
			$(".regular").slick({
					dots: true,
					infinite: true,
					slidesToShow: 1,
					slidesToScroll: 1,
					autoplay: true,
					autoplaySpeed:1000
				});
				
					$(".regular01").slick({
					dots: true,
					infinite: true,
					slidesToShow: 1,
					slidesToScroll: 1,
					autoplay: true,
					autoplaySpeed:1000
				});
					
					$(".ourpackage").slick({
					dots: true,
					infinite: true,
					slidesToShow: 1,
					slidesToScroll: 1,
					autoplay: true,
					autoplaySpeed:1500
				});
				
					
				$(".regular02").slick({
					dots: true,
					infinite: true,
					slidesToShow: 3,
					autoplay: false,
					slidesToScroll: 1,
					centerMode: true,
			centerPadding: '100px',
					autoplaySpeed:1000,
							responsive: [
					{
					breakpoint: 850,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1
					}
					},
					
					{
					breakpoint: 600,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
					},
								{
					breakpoint: 500,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
						centerMode: false,
			centerPadding: '100px'
					}
					},
					
								
								
				]
					
			});
					
					$(".ourpackagehome").slick({
					dots: true,
					infinite: true,
					slidesToShow: 2,
					autoplay: false,
					slidesToScroll: 1,
					autoplaySpeed:1000,
						
						responsive: [
					{
					breakpoint: 810,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
					},
								
				]
						
						
			});
					$(".regular03").slick({
					dots: true,
					infinite: true,
					slidesToShow: 4,
					autoplay: true,
					slidesToScroll: 1,
						autoplaySpeed:100,
					responsive: [
					{
					breakpoint: 1025,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 1,
						infinite: true,
						dots: false
					}
					},
					{
					breakpoint: 769,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1
					}
					},
					{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
					}
				]
			});
			//default options
			snowFall.snow(document.body, {image : "{{ asset('assets/images/flake.png') }}", minSize: 4, maxSize:20});

			$(window).scroll(function(){
				//Getting the scroll percentage
				var windowHeight = $(window).height();
				var scrollHeight = $(window).scrollTop();
				var scrollPercentage =  (scrollHeight / windowHeight);
				//console.log(scrollPercentage);
				
				// if we have scrolled past 200, add the alternate class to nav bar
				if(scrollPercentage > 0) {
					$('.top_wrapper').addClass('scrolling');
				} else {
					$('.top_wrapper').removeClass('scrolling');
				}
			});
		});
</script> 
<script src="{{ asset('assets/js/jquery.pageScroll.js') }}"></script>
<script>
		$('#main').pageScroll();
</script> -->
<!--animation js start--> 

<!-- <script>

(function($) {
  $.fn.visible = function(partial) {
    
      var $t            = $(this),
          $w            = $(window),
          viewTop       = $w.scrollTop(),
          viewBottom    = viewTop + $w.height(),
          _top          = $t.offset().top,
          _bottom       = _top + $t.height(),
          compareTop    = partial === true ? _bottom : _top,
          compareBottom = partial === true ? _top : _bottom;
    
    return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

  };
    
})(jQuery);

var win = $(window);

var allMods = $(".module");

allMods.each(function(i, el) {
  var el = $(el);
  if (el.visible(true)) {
    el.addClass("already-visible"); 
  } 
});

win.scroll(function(event) {
  
  allMods.each(function(i, el) {
    var el = $(el);
    if (el.visible(true)) {
      el.addClass("come-in"); 
    } 
  });
  
});	
</script>  -->
<!--animation js start--> 

<!--begin::Page Scripts(used by this page) -->
<!-- @yield('FuelTrend_js') -->
<!--end::Page Scripts -->