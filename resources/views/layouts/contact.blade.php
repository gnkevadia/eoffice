<script src="https://www.google.com/recaptcha/api.js"></script>

<section class="contact-form  bg-light-white pt-100 pb-100" style="background-image: url('assets/img/bg/bg-abt.jpg');" data-overlay="7">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="fancy-head text-center relative z-5 mb-40">
                    <h5 class="line-head mb-15 ">
                        <span class="line before "></span>
                        Send us a message
                        <span class="line after"></span>
                    </h5>
                    <h1 class="mb-5">Get in Touch with Us</h1>
                    <p class="small-p">Pellentesque tempor ornare mal esuada. Mauris vel metus vel urna interdum</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <form action="contact-us" id="contactForm" name="contactForm" method="POST" class="relative z-5 mt-10 kt-form needs-validation" novalidate>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                <input type="text" class="form-control input-lg input-white shadow-5" name="name" id="name" placeholder="Name" required>
                                <div class="invalid-feedback">
                                    Please Enter Username.
                                </div>
                                <div class="valid-feedback">Valid.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                <input type="email" class="form-control input-lg input-white shadow-5" name="email" id="email" placeholder="Email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" required>
                                <div class="invalid-feedback">
                                    Please Enter Email.
                                </div>
                                <div class="valid-feedback">Valid.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                <input type="text" class="form-control input-lg input-white shadow-5" name="tel" id="tel" placeholder="Phone number" pattern="[1-9]{1}[0-9]{9}" required>
                                <div class="invalid-feedback">
                                    Please Enter Phone Number.
                                </div>
                                <div class="valid-feedback">Valid.</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group relative mb-30 mb-sm-20">
                                <textarea class="form-control input-white shadow-5" name="message" id="message" cols="30" rows="7" placeholder="Your message"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group relative mb-30 mb-sm-20">
                                <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_SITE_KEY') }}"></div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center mt-30">
                            <button class="btn btn-square  blob-small" type="submit">SUBMIT<i class="fas fa-long-arrow-alt-right ml-20"></i></button>
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

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
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