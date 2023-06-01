@extends('layouts.default')
@section('content')
<!-- Thank you start -->
<section class="thanks pt-100 pb-100" style="background-image: url('{{ asset('assets/img/bg/bg-abt.jpg') }}');" data-overlay="9">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="thank-outer z-5">
                    <div class="thank-icon flex-center">
                        <img src="{{ asset('assets/img/career/hand.png') }}" alt="">
                    </div>
                    <?php $registerEmailId = ''; 

                    if(Session::get('registerEmailId') == 1) {
                        ?> <h3 class="f-700">Thank you! for Signing up.</h3> <?php
                    } else if(Session::get('registerEmailId') == 2){
                        ?> <h3 class="f-700">Thank you! We have recieved your Contact request.</h3> <?php
                    } else{ 
                        ?> <h3 class="f-700">Thank you! We have recieved your Order request.</h3> <?php
                    }
                    ?>
                    <p>You will receive your login credentials within 2 business days. If you have a rush order, please contact your local office. </p>
                    <a href="/" class="btn btn-round mt-10">Go Back to Home</a>
                </div>
            </div>  
        </div>
    </div>
</section>
<!-- Thank you end -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        var cartId = "{{ Session::get('cart_id') }}"
        var url = '{{URL::to('/payment/')}}';

        if(cartId != null){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url:url,
                data:{cartId:cartId},
                success:function(data){
                    console.log(data);
                }
            });
        }
    });   
</script>
@stop