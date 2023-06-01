@extends('layouts.default')
@section('content')
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================= -->
<!-- nav Tabs -->
@if(!empty(Session::get('email')))
<div class="bg-white rounded-5">
        <section class="p-4">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-lg-8 col-md-12 text-center text-lg-left">
                        <div class="fancy-head left-al">
                            <h2>Review & Pay</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<section class="bg-white pb-100" data-overlay="7">
    <div class="container">
        <form action="review-and-pay" id="payment-form" class="relative z-5  wow fadeInUp needs-validation" method="post" data-secret="{{ $intent->client_secret }}">{{csrf_field()}}
            <div class="row">
                <div class="card col-xl-6">
                    <div class="row card-body">
                        <blockquote class="blockquote">
                            <label for="basic-url"><strong>Contact Details.</strong></label>
                            <div class="col-xl-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <address>
                                            <strong>{{ $UserObj['company'] }}</strong><br>
                                            <h5>{{ $UserObj['address1'] }}</h5>
                                            @if(!empty($UserObj['state']))
                                            <h5>{{ $UserObj['city'].', '. $UserObj['state'].', '. $UserObj['postal_code'] }}<br></h5>
                                            @else
                                            <h5>{{ $UserObj['city'].', '. $UserObj['postal_code'] }}<br></h5>
                                            @endif
                                            <h5><abbr>No:</abbr> {{ $UserObj['phone_number'] }}</h5>
                                        </address>
                                        <address>
                                            <h5><strong>{{ $UserObj['first_name'].' '. $UserObj['last_name']}}</strong></h5>
                                            <h6>Email:<a href="mailto:#">{{ $UserObj['email'] }}</a></h6>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </blockquote>
                        <blockquote class="blockquote">
                            <label for="basic-url"><strong>Billing Details.</strong></label>
                            <div class="col-xl-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <address>
                                            <strong>{{ $billingdata['company'] }}</strong><br>
                                            <h5>{{ $billingdata['address1'] }}</h5>
                                            @if(!empty($billingdata['state']))
                                            <h5>{{ $billingdata['city'].', '. $billingdata['state'].', '. $billingdata['postal_code'] }}<br></h5>
                                            @else
                                            <h5>{{ $billingdata['city'].', '. $billingdata['postal_code'] }}<br></h5>
                                            @endif
                                            <h5><abbr>No:</abbr> {{ $billingdata['phone_number'] }}</h5>
                                        </address>
                                        <address>
                                            <h5><strong>{{ $billingdata['first_name'].' '. $billingdata['last_name']}}</strong></h5>
                                            <h6>Email:<a href="mailto:#">{{ $billingdata['email'] }}</a></h6>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </blockquote>
                    </div>
                </div>
                <div class="card col-xl-6">
                    <div class="row card-body">
                        <blockquote class="blockquote">
                            <label for="basic-url"><strong>Your total Amount: <?php echo Session::get('totalPrice') ?></strong></label>
                            <div class="col-xl-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="card-element">
                                            Credit card information <i class="fas fa-lock"></i> Secured by Stripe<br />
                                        </label>
                                        <!-- <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                            <input type="text" class="form-control input-white shadow-2" name="card-holder-name" id="card-holder-name" placeholder="Card Holder Name *" required>
                                            <div class="invalid-feedback">
                                                Please Enter Card Holder Name.
                                            </div>
                                        </div> -->
                                    </div>
                                    <div id="payment-element" class="col-md-12">
                                        <!-- Elements will create form elements here -->
                                    </div>
                                    <div id="error-message">
                                        <!-- Display error message to your customers here -->
                                    </div>
                                </div>
                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>
                        </blockquote>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <?php $cartId = Session::get('cart_id'); ?>
                        <button id="submit" class="btn btn-blue btn-block request-btn uppercase shadow-2">Pay</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@else
<section class="about-us pt-10 pb-70">
    <div class="container">
        @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <div class="col-xl-8 col-lg-7 text-center text-lg-right z-5">
            <h6>Please login & Register to purchase the product.</h6><br>
            <a href="/log-in" class="btn btn-square-green d-block d-sm-inline-block blob-small wow fadeInUp">@csrf
                <i class="fas fa-sign-in-alt mr-15"></i>LOGIN
            </a>
            <a href="sign-up" class="btn btn-square-green d-block d-sm-inline-block blob-small wow fadeInUp">@csrf
                <i class="fas fa-registered mr-15"></i>REGISTER
            </a>
        </div>
    </div>
</section>
@endif

<!-- nav Tabs -->
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script type="text/javascript" src="{{ url('assets/js/creditCardValidator.js') }}"></script>
@section('footerScript')
@parent
<script>
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const options = {
        clientSecret: '{{ $intent->client_secret }}',
        // Fully customizable with appearance API.
        appearance: {
            /*...*/
        },
    };

    const elements = stripe.elements(options);
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    const form = document.getElementById('payment-form');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const { error } = await stripe.confirmPayment({
            //`Elements` instance that was used to create the Payment Element
            elements,
            confirmParams: {
                return_url: '{{URL::to('/thank-you/')}}',
            },
        });
        if (error) {
            const messageContainer = document.querySelector('#error-message');
            messageContainer.textContent = error.message;
        }
    });
</script>
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