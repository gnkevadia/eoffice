@extends('layouts.default')
@section('content')
<!-- Thank you start -->
<style>
    .profile-img .file {
        position: relative;
        overflow: hidden;
        margin-top: -10%;
        width: 26%;
        border: none;
        border-radius: 0;
        font-size: 15px;
        background: #212529b8;
    }

    .profile-img .file input {
        position: absolute;
        opacity: 0;
        right: 0;
        top: 0;
    }
</style>
<section class="pb-4 " data-overlay="7">
    <div class="bg-white rounded-5">
        <section class="p-4">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-lg-8 col-md-12 text-center text-lg-left">
                        <div class="fancy-head left-al">
                            <h2>Profile Settings</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5 profile-img">
                            @if(!empty($UserObj->profile_photo))
                            <img class="rounded-circle mt-5" width="150px" src="/images/profile_image/{{ $UserObj->profile_photo }}">
                            @else
                            <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                            @endif
                            <div class="file btn btn-lg btn-primary">
                                Change Photo
                                <input type="file" class="custom-file-input" id="profile_photo" name="profile_photo1" accept="image/*" />
                            </div><br>
                            <span class="font-weight-bold">{{ $UserObj->first_name.' '.$UserObj->last_name }}</span><span class="text-black-50">{{ $UserObj->email }}</span><span> </span>
                        </div>
                        <form action="/user-edit" class="relative z-5  wow fadeInUp needs-validation" method="post" novalidate enctype="multipart/form-data">@csrf
                            <div class="card">
                                <div class="card-body">
                                    @if(Session::has('message'))
                                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                                    @endif
                                    <label for="basic-url"><strong>Change Password </strong>change or reset your account password</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="password" class="form-control input-white shadow-2" id="cPassword" name="cPassword" placeholder="Current Password *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Current Password.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="password" class="form-control input-white shadow-2" name="password" id="password" placeholder="New Password *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter New Password.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="password" class="form-control input-white shadow-2" id="confirmNewPassword" placeholder="Confirm New Password *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Confirm New Password.
                                                </div>
                                            </div>
                                            <div style="margin-bottom: 11px;margin-top: -19px;" id="CheckPasswordMatch"></div>
                                        </div>
                                    </div>
                                    <button class="relative btn btn-square-green uppercase blob-small" id="updateProfile">Update Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <form action="/user-edit" class="relative z-5  wow fadeInUp needs-validation" method="post" novalidate>@csrf
                                <div class="card-body">
                                    <label for="basic-url"><strong>Profile Settings</strong></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="first_name" id="first_name" value="{{ $UserObj->first_name}}" placeholder="First Name *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter First Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="last_name" id="last_name" value="{{ $UserObj->last_name}}" placeholder=" Last Name *" required>
                                                <div class="invalid-feedback">Please Enter Last Name.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="email" class="form-control input-white shadow-2" name="email" id="email" value="{{ $UserObj->email}}" placeholder="Email *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Email Address.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="phone_number" id="phone_number" value="{{ $UserObj->phone_number}}" value="" placeholder="Telephone Number *" pattern="[1-9]{1}[0-9]{9}" required>
                                                <div class="invalid-feedback">Please Enter Telephone Number.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="company" id="company" value="{{ $UserObj->company}}" placeholder="Company Name *" required>
                                                <div class="invalid-feedback">Please Enter Company Name.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="address1" id="address1" value="{{ $UserObj->address1}}" placeholder="Street Address 1*" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Street Address.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="address2" id="address2" value="{{ $UserObj->address2}}" placeholder="Street Address Line 2">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="country" id="country" value="{{ $UserObj->country}}" placeholder="Country Name *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Country Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="city" id="city" value="{{ $UserObj->city}}" placeholder="City *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter City Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="state" id="state" value="{{ $UserObj->state}}" placeholder="State *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter State Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group relative mb-30 mb-sm-20 input-group has-validation">
                                                <input type="text" class="form-control input-white shadow-2" name="postal_code" id="postal_code" value="{{ $UserObj->postal_code}}" placeholder="Postal Code *" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Postal Code.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="relative btn btn-square-green uppercase blob-small" id="saveProfile">Save Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Thank you end -->
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $("#confirmNewPassword").on('keyup', function() {
            var password = $("#password").val();
            var confirmPassword = $("#confirmNewPassword").val();
            if (password != confirmPassword)
                $("#CheckPasswordMatch").html("Password does not match !").css("color", "red");
            else
                $("#CheckPasswordMatch").html("Password match !").css("color", "green");
        });

        $(document).on('change', '#profile_photo', function() {
            var property   =  document.getElementById("profile_photo").files[0];
            var image_name = property.name;
            var image_extension = image_name.split('.').pop().toLowerCase();
            
            var image_size = property.size;
            if (image_size > 2000000 && jQuery.inArray(image_extension, ['gif', 'png', 'jpg', 'jpeg', 'webp']) == -1) {
                alert("Invalid Image File");
            } else {
                var form_data = new FormData();
                form_data.append("profile_photo1", property);
                var url = '{{URL::to('/user-edit/')}}';$.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: url,
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#profile_photo').html("<label class= 'text-success'>Image Uploading ...</label > ");
                    },
                    success: function(data) {
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>
@endsection
@stop