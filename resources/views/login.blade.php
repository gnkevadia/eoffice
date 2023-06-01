@extends('layouts.default')
@section('content')
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<!-- Login area start -->
<section class="login pt-100 pb-100">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-xl-7 col-lg-6 d-none d-lg-block">
                <div class="login-image bg-cover h-100" style="background-image: url('img/bg/login.jpg');">

                </div>
            </div>
            <div class="col-xl-5 col-lg-6 ">
                <div class="form-area bg-light-white">
                    <h2 class="f-700 mb-15">Have an Account?</h2>
                    <p>Quisque enim ipsum, commodo et venenatis rutrum, luctus in enim venenatis.</p>
                    <form action="log-in" class="relative z-5" method="post">@csrf
                        <div class="form-group relative mb-25 mb-sm-20">
                            <input type="text" class="form-control input-lg input-white shadow-5" id="name"
                                placeholder="Username">
                            <i class="far fa-user transform-v-center"></i>
                        </div>
                        <div class="form-group relative mb-20 mb-sm-20">
                            <input type="password" class="form-control input-lg input-white shadow-5" id="pwd"
                                placeholder="Password">
                            <i class="fas fa-lock transform-v-center"></i>
                        </div>
                        <div class="form-group form-check pl-0">
                            <div class="d-flex justify-content-between">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1"
                                        checked="">
                                    <label class="custom-control-label fs-13" for="customCheck1"><span
                                            class="label-check">Remember me</span></label>
                                </div>
                                <a href="#" class="fs-12 black">Forgot Password?</a>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-square btn-block shadow-4 mt-20">LOGIN</button>
                        <div class="signup-login text-center">
                            <p class="mt-15 fs-13">
                                New here?<a href="#" class="ml-5 mb-0 d-inline-block f-500">Sign up</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Login area end -->
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
@endsection