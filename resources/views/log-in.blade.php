@extends('layouts.default')
@section('content')
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<!-- Login area start -->
<script src="https://www.google.com/recaptcha/api.js"></script>
<section class="login pt-100 pb-100">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-xl-7 col-lg-6 d-none d-lg-block">
                <div class="login-image bg-cover h-100" style="background-image: url('assets/img/bg/login.jpg');">
                </div>
            </div>
            <div class="col-xl-5 col-lg-6 ">
                <div class="form-area bg-light-white">
                    <div class="row no-gutters">
                        @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                        @endif
                    </div>
                    <h2 class="f-700 mb-15">Have an Account?</h2>
                    <p>Quisque enim ipsum, commodo et venenatis rutrum, luctus in enim venenatis.</p>
                    <form action="log-backend" method="post" class="needs-validation" novalidate>{{ csrf_field() }}
                        <input type="hidden" class="form-control input-lg input-white shadow-5" id="backUrl" name="backUrl" value="<?php echo Session::put('backUrl', url()->previous()); ?>">
                        <div class="form-group relative mb-25 mb-sm-20 has-validation">
                            <input type="email" class="form-control input-lg input-white shadow-5" id="email" name="email" placeholder="Email" required>
                            <i class="far fa-user transform-v-center"></i>
                            <div class="invalid-feedback">
                                Please Enter Email Address.
                            </div>
                        </div>
                        <div class="form-group relative mb-20 mb-sm-20 has-validation">
                            <input type="password" class="form-control input-lg input-white shadow-5" id="password" name="password" placeholder="Password" required>
                            <i class="fas fa-lock transform-v-center"></i>
                            <div class="invalid-feedback">
                                Please Enter Password.
                            </div>
                        </div>
                        <div class="form-group form-check pl-0">
                            <div class="d-flex justify-content-between">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" checked="">
                                    <label class="custom-control-label fs-13" for="customCheck1"><span class="label-check">Remember me</span></label>
                                </div>
                                <a href="/forgot" class="fs-12 black">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group relative mb-30 mb-sm-20">
                                <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_SITE_KEY') }}" required></div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-square btn-block shadow-4 mt-20 request-btn">LOGIN</button>
                        <div class="signup-login text-center">
                            <p class="mt-15 fs-13">
                                New here?<a href="/sign-up" class="ml-5 mb-0 d-inline-block f-500">Sign up</a>
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
@section('footerScript')
@parent
<script type="text/javascript">
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>

@endsection
@stop
