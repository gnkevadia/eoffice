@extends('layouts.default')
@section('content')
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================= -->
<!-- nav Tabs -->
@if(!empty(Session::get('email')))
<section class="pb-4 " data-overlay="7">
    <div class="bg-white rounded-5">
        <section class="p-4">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-lg-8 col-md-12 text-center text-lg-left">
                        <div class="fancy-head left-al">
                            <h2>Checkout</h2>
                        </div>  
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="container">
        <form action="review-and-pay" class="relative z-5  wow fadeInUp needs-validation" method="post" novalidate>@csrf
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <label for="basic-url"><strong>Contact Details.</strong></label>
                                    <p>Please fill out the fields below</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="country" id="country" value="{{ $usersData->country }}" placeholder="Country Name *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Country Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="first_name" id="first_name" value="{{ $usersData->first_name }}" placeholder="First Name *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter First Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="last_name" id="last_name" value="{{ $usersData->last_name }}" placeholder=" Last Name *" required>
                                                <div class="invalid-feedback">Please Enter Last Name.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="company" id="company" value="{{ $usersData->company }}" placeholder="Company Name *" required>
                                                <div class="invalid-feedback">Please Enter Company Name.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="address1" id="address1" value="{{ $usersData->address1 }}" placeholder="Street Address *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Street Address.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="address2" id="address2" value="{{ $usersData->address2 }}" placeholder="Street Address Line 2">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="city" id="city" value="{{ $usersData->city }}" placeholder="City *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter City Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="state" id="state" value="" placeholder="State *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter State Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="postal_code" id="postal_code" value="{{ $usersData->postal_code }}" placeholder="Postal Code *">
                                                <div class="invalid-feedback">
                                                    Please Enter Postal Code.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="email" class="form-control input-white shadow-2" name="email" id="email" value="{{ $usersData->email }}" placeholder="Email *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Email Address.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="phone_number" id="phone_number" value="{{ $usersData->phone_number }}" placeholder="Telephone Number *" pattern="[1-9]{1}[0-9]{9}" required>
                                                <div class="invalid-feedback">Please Enter Telephone Number.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group">
                                                <input type="text" class="form-control input-white shadow-2" name="tex_id" id="tex_id" value="{{ $usersData->tex_id }}" placeholder="Tax ID. Nr. / VAT Nr.">
                                                <!-- <div class="invalid-feedback">
                                                Please Enter Tax ID. Nr. / VAT Nr.
                                            </div> -->
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-12">
                                        <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                            <select name="" class="col-md-12">
                                                <option value="other" selected>Other</option>
                                                <option value="other">Other</option>
                                                <option value="other">Other</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div> -->
                                        <div class="col-md-12">
                                            <div class="form-group form-check pl-0">
                                                <div class="d-flex justify-content-between">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck" required>
                                                        <label class="custom-control-label fs-13 black" for="customCheck"><span class="label-check">I'd like to receive marketing communications.</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <label for="basic-url"><strong>Billing Details.</strong></label>
                                    <p>Please fill out the fields below</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="billing_country" id="billing_country" value="" placeholder="Country Name *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Country Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="billing_first_name" id="billing_first_name" placeholder="First Name *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter First Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="billing_last_name" id="billing_last_name" placeholder=" Last Name *" required>
                                                <div class="invalid-feedback">Please Enter Last Name.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="billing_company" id="billing_company" placeholder="Company Name *" required>
                                                <div class="invalid-feedback">Please Enter Company Name.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="billing_address1" id="billing_address1" placeholder="Street Address *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Street Address.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="billing_address2" id="billing_address2" placeholder="Street Address Line 2">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="billing_city" id="billing_city" placeholder="City *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter City Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="billing_state" id="billing_state" placeholder="State *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter State Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="billing_postal_code" id="billing_postal_code" placeholder="Postal Code *">
                                                <div class="invalid-feedback">
                                                    Please Enter Postal Code.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group form-check pl-0">
                                                <div class="d-flex justify-content-between">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck1" required>
                                                        <label class="custom-control-label fs-13 black" for="customCheck1"><span class="label-check">Same as a contact information.</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="email" class="form-control input-white shadow-2" name="billing_email" id="billing_email" placeholder="Email *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Email Address.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row nav clearfix relative">
                <div class="col-md-10">
                    <!-- <button class="relative btn btn-square-green uppercase blob-small" id="previous"> Previous</button> -->
                </div>
                <div class="col-md-2">
                    <button class="relative btn btn-square-green uppercase blob-small" id="checkout">Checkout</button>
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
@section('footerScript')
@parent
<script type="text/javascript">
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')

        $('#customCheck1').click(function() {

            if ($("#customCheck1").prop('checked') == true) {
                $("#billing_country").val($("#country").val());
                $("#billing_first_name").val($("#first_name").val());
                $("#billing_last_name").val($("#last_name").val());
                $("#billing_company").val($("#company").val());
                $("#billing_address1").val($("#address1").val());
                $("#billing_address2").val($("#address2").val());
                $("#billing_city").val($("#city").val());
                $("#billing_state").val($("#state").val());
                $("#billing_postal_code").val($("#postal_code").val());
            } else {
                $("#billing_country").val('');
                $("#billing_first_name").val('');
                $("#billing_last_name").val('');
                $("#billing_company").val('');
                $("#billing_address1").val('');
                $("#billing_address2").val('');
                $("#billing_city").val('');
                $("#billing_state").val('');
                $("#billing_postal_code").val('');
            }
        });
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