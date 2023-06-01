@extends('layouts.default')
@section('content')
<script src="https://www.google.com/recaptcha/api.js"></script>
<!-- Thank you start -->
<section class="contact-form  bg-light-white pt-100 pb-100" style="background-image: url('assets/img/bg/bg-abt.jpg');" data-overlay="7">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="fancy-head text-center relative z-5 mb-40">
                    <h5 class="line-head mb-15 "><span class="line before "></span>Register<span class="line after"></span></h5>
                    <h1 class="mb-5">Create Your Account Here</h1>
                    <p class="small-p">Quisque enim ipsum, commodo et venenatis rutrum, luctus in enim venenatis.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <form action="sign-up" class="relative z-5  wow fadeInUp needs-validation" method="post" novalidate>@csrf
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                        <input type="text" class="form-control input-white shadow-2" name="first_name" id="first_name" placeholder="First Name *" required>
                                        <div class="invalid-feedback">
                                            Please Enter First Name.
                                        </div>
                                        <div class="valid-feedback">Valid.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                        <input type="text" class="form-control input-white shadow-2" name="last_name" id="last_name" placeholder=" Last Name *" required>
                                        <div class="invalid-feedback">
                                            Please Enter Last Name.
                                        </div>
                                        <div class="valid-feedback">Valid.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                        <input type="email" class="form-control input-white shadow-2" name="email" id="email" placeholder="Email *" required>
                                        <div class="invalid-feedback">
                                            Please Enter Email Address.
                                        </div>
                                        <div class="valid-feedback">Valid.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                        <input type="text" class="form-control input-white shadow-2" name="suffix" id="suffix" placeholder="Suffix">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                        <input type="text" class="form-control input-white shadow-2" name="title" id="title" placeholder="Title">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                        <input type="text" class="form-control input-white shadow-2" name="company" id="company" placeholder="Company Name *" required>
                                        <div class="invalid-feedback">
                                            Please Enter Company Name.
                                        </div>
                                        <div class="valid-feedback">Valid.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                        <input type="text" class="form-control input-white shadow-2" name="country" id="country" placeholder="Country Name *" required>
                                        <div class="invalid-feedback">
                                            Please Enter Country Name.
                                        </div>
                                        <div class="valid-feedback">Valid.</div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                        <input type="text" class="form-control input-white shadow-2" name="address1" id="address1" placeholder="Street Address *" required>
                                        <div class="invalid-feedback">
                                            Please Enter Street Address.
                                        </div>
                                        <div class="valid-feedback">Valid.</div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                        <input type="text" class="form-control input-white shadow-2" name="address2" id="address2" placeholder="Street Address Line 2">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                        <input type="text" class="form-control input-white shadow-2" name="city" id="city" placeholder="City *" required>
                                        <div class="invalid-feedback">
                                            Please Enter City Name.
                                        </div>
                                        <div class="valid-feedback">Valid.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                        <input type="text" class="form-control input-white shadow-2" name="postal_code" id="postal_code" placeholder="Postal Code">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                        <input type="text" class="form-control input-white shadow-2" name="phone_number" id="phone_number" placeholder="Telephone Number *" pattern="[1-9]{1}[0-9]{9}" required>
                                        <div class="invalid-feedback">
                                            Please Enter Telephone Number.
                                        </div>
                                        <div class="valid-feedback">Valid.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                        <input type="password" class="form-control input-white shadow-2" name="password" id="password" placeholder="Password *" required>
                                        <div class="invalid-feedback">
                                            Please Enter Password.
                                        </div>
                                        <div class="valid-feedback">Valid.</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check pl-0">
                                        <div class="d-flex justify-content-between">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1" required>
                                                <label class="custom-control-label fs-13 black" for="customCheck1"><span class="label-check">I have read and agree to the Terms and Conditions.</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group relative mb-30 mb-sm-20">
                                        <textarea class="form-control input-white shadow-5" name="comment" id="comment" cols="30" rows="4" placeholder="Your Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group relative mb-30 mb-sm-20">
                                        <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_SITE_KEY') }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <button class="btn btn-blue btn-block request-btn uppercase shadow-2">submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
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