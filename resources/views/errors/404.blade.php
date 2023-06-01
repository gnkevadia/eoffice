@extends('layouts.default')
@section('content')
<!-- 404 area start -->
<section class="not-found pt-100 pb-100" style="background-image: url('{{ asset('assets/img/bg/bg-abt.jpg') }}');" data-overlay="9">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="area-not-found z-5">
                    <h1 class="head-404 mb-35 mt-40">
        4<span class="green">0</span>4
        </h1>
                    <h5 class="fs-19 mb-25">We are sorry, But the page you requested was not found</h5>
                    <!--<form action="#" class="search-not-found">
                        <div class="form-group relative mb-25 ">
                            <input type="text" class="form-control input-lg input-white shadow-5" id="phone" placeholder="Search here...">
                            <i class="fas fa-search transform-v-center"></i>
                        </div>
                    </form>-->
                    <p class="mb-35">Or go back to <a href="{{ url('/') }}" class="underline">homepage</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- 404 area end -->
@stop