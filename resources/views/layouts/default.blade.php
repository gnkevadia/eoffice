<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		@include('layouts.head')
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body>
		<!-- Google Tag Manager (noscript) -->
		<!-- End Google Tag Manager (noscript) -->	
		<!-- Preloader start -->
		<div class="loader-page flex-center">
        	<img src="{{ asset('assets/img/loader.gif') }}" alt="">
    	</div>
    	<!-- Preloader end -->
    	<!-- Header start -->
		<header>
			@include('layouts.header')
		</header>
		@yield('content')
		<!-- Request callback end -->
		@include('layouts.cta')
    	<!-- cta area end -->
		<!-- Footer area start -->
		@include('layouts.footer')
	</body>
	<!-- end::Body -->
</html>