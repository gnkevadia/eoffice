@extends('layouts.default')
@section('content')
<!-- Slider start -->
    @include('layouts.homebanner')
    <!-- Slider end -->

    <!-- About us start -->
    @if(isset($arrHomePageAboutBlock) && !empty($arrHomePageAboutBlock))
        @foreach($arrHomePageAboutBlock as $keypages=>$valHomePageAboutBlock)
            {!! $valHomePageAboutBlock->content !!}
        @endforeach
    @endif
    <!-- About us end -->

    <!-- Service start -->
    @include('layouts.news')
    <!-- Service end -->

    <!-- Testimonial area start -->
    @if(isset($arrHomePageSolutionBlock) && !empty($arrHomePageSolutionBlock))
        @foreach($arrHomePageSolutionBlock as $keypages=>$valHomePageSolutionBlock)
            {!! $valHomePageSolutionBlock->content !!}
        @endforeach
    @endif
    <!-- Testimonial area end -->

    <!-- Testimonial area start -->
    @include('layouts/feedback')
    <!-- Testimonial area end -->

    <!-- Experience Cta start -->
    @if(isset($arrHomePageResourcesBlock) && !empty($arrHomePageResourcesBlock))
        @foreach($arrHomePageResourcesBlock as $keypages=>$valHomePageResourcesBlock)
            {!! $valHomePageResourcesBlock->content !!}
        @endforeach
    @endif
    <!-- Experience Cta end -->

    <!-- Blog area start -->
    @include('layouts/industries')
    <!-- End blog area start -->

    <!-- Client logos area start -->
    @if(isset($arrHomePageGetStartedBlock) && !empty($arrHomePageGetStartedBlock))
        @foreach($arrHomePageGetStartedBlock as $keypages=>$valHomePageGetStartedBlock)
            {!! $valHomePageGetStartedBlock->content !!}
        @endforeach
    @endif
    <!-- Client logos area end -->
    @stop