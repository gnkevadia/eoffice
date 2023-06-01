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
                <div class="login-image bg-cover h-100" style="background-image: url('assets/img/bg/login.jpg');">

                </div>
            </div>
            <div class="col-xl-5 col-lg-6 ">
                <div class="form-area bg-light-white">
                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif  
                    <h2 class="f-700 mb-15">Forgot Password</h2>
                    <p>Please enter the username and email address associated with the account:</p>
                    <form action="forgot-user-password" method="post" id="frmForgot" class="needs-validation" name="frmForgot" novalidate>{{ csrf_field() }}
                        <input type="hidden" id="forgotId" name="forgotId" value="1">
                        <input type="hidden" id="forgotUserId" name="forgotUserId" value="">
                        <div class="form-group relative mb-20 mb-sm-20 password">
                            <input type="password" class="form-control input-lg input-white shadow-5" id="password" placeholder="Password" name="password">
                            <i class="fas fa-lock transform-v-center"></i>
                        </div>
                        <div class="form-group relative mb-20 mb-sm-20 confirmPassword">
                            <input type="password" class="form-control input-lg input-white shadow-5" id="confirmPassword" placeholder="Confirm Password" name="confirmPassword">
                            <i class="fas fa-lock transform-v-center"></i>
                            <div style="margin-top: 7px;" id="CheckPasswordMatch"></div>
                        </div>
                        <button class="btn btn-square-green uppercase btn-block blob-small shadow-4 mt-20 confirmPassword">Submit</button>
                    </form>
                    <div class="form-group relative mb-20 mb-sm-20 has-validation">
                        <input type="email" class="form-control input-lg input-white shadow-5" id="email" placeholder="Email" name="email" required>
                        <i class="fas fa-envelope transform-v-center"></i>
                        <div class="invalid-feedback">
                            Please Enter Email Address.
                        </div>
                    </div>
                    <button class="btn btn-square-green uppercase btn-block blob-small shadow-4 mt-20" id="forgotSubmit">Continue</button>
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
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.password').hide();
        $('.confirmPassword').hide();
        $("#forgotSubmit").click(function() {
            var email = $('#email').val();
            if (email != null) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: 'forgot',
                    data: { email: email },
                    success: function(data) {
                        var datas = data.split("/");
                        $('#forgotUserId').val(datas[1]);
                        if(datas[0] == email)
                        {
                            $('.password').show();
                            $('.confirmPassword').show();
                        }
                        else{
                            alert('OK')
                        }
                    }
                });
            }
        });
        $("#confirmPassword").on('keyup', function() {
            var password = $("#password").val();
            var confirmPassword = $("#confirmPassword").val();
            if (password != confirmPassword)
            $("#CheckPasswordMatch").html("Password does not match !").css("color", "red");
            else
            $("#CheckPasswordMatch").html("Password match !").css("color", "green");
        });
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