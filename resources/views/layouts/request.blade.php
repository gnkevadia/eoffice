<section class="callback-area pt-95 pb-85" style="background-image: url('{{ asset('assets/img/banner/banner_1.jpg') }}');" data-overlay="9">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="fancy-head text-center relative z-5 mb-40 wow fadeInDown">
                    <h5 class="line-head mb-15 white">
              <span class="line before bg-white"></span>
                Contact Us
              <span class="line after bg-white"></span>
            </h5>
                    <h1 class="white">Request a Demo</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <form action="/request" class="relative z-5  wow fadeInUp needs-validation" method="post" novalidate>@csrf
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group relative">
                                        <input type="text" class="form-control input-white shadow-2" name="firstName" id="firstName" placeholder="First Name *" required>
                                        <i class="far fa-user transform-v-center"></i>
                                        <div class="invalid-feedback">
                                            Please Enter First Name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative">
                                        <input type="text" class="form-control input-white shadow-2" name="lastName" id="lastName" placeholder=" Last Name *" required>
                                        <i class="far fa-user transform-v-center"></i>
                                        <div class="invalid-feedback">
                                            Please Enter Last Name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative">
                                        <input type="text" class="form-control input-white shadow-2" name="job_title" id="job_title" placeholder="Job Title">
                                        <i class="far fa-user transform-v-center"></i>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group relative">
                                        <input type="email" class="form-control input-white shadow-2" name="email" id="email" placeholder="Email *" required>
                                        <i class="far fa-envelope transform-v-center"></i>
                                        <div class="invalid-feedback">
                                            Please Enter Email.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative">
                                        <input type="text" class="form-control input-white shadow-2" name="tel" id="tel" placeholder="Phone number *" required>
                                        <i class="fas fa-mobile-alt transform-v-center"></i>
                                        <div class="invalid-feedback">
                                            Please Enter Phone Number.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group relative">
                                        <input type="text" class="form-control input-white shadow-2" name="company" id="company" placeholder="Company">
                                        <i class="fas fa-mobile-alt transform-v-center"></i>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative">
                                        <input type="text" class="form-control input-white shadow-2" name="company_type" id="company_type" placeholder="Company Type">
                                        <i class="fas fa-mobile-alt transform-v-center"></i>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative">
                                        <input type="text" class="form-control input-white shadow-2" name="country" id="country" placeholder="Country">
                                        <i class="fas fa-mobile-alt transform-v-center"></i>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative">
                                        <input type="text" class="form-control input-white shadow-2" name="city" id="city" placeholder="City">
                                        <i class="fas fa-mobile-alt transform-v-center"></i>
                                    </div>
                                    
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group relative mb-30 mb-sm-20">
                                        <textarea class="form-control input-white shadow-5" name="comment" id="comment" cols="30" rows="4" placeholder="Your message"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                <div class="form-group form-check pl-0">
                                    <div class="d-flex justify-content-between">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1" required>
                                            <label class="custom-control-label fs-13 white" for="customCheck1"><span class="label-check">Yes, I would like to receive email updates about products, services, news and events from Fuel Trend and its affiliates. Your personal information will be handled in accordance with our Global Privacy Policy.</span></label>
                                        </div>
                                    </div>
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