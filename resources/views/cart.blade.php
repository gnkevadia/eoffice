@extends('layouts.default')
@section('content')
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================= -->
<!-- nav Tabs -->
@if(!empty(Session::get('email')))
<section class="pb-4">
    <div class="bg-white rounded-5">
        <section class="p-4">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-lg-8 col-md-12 text-center text-lg-left">
                        <div class="fancy-head left-al">
                            <h2>Cart</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <form class="needs-validation" action="/checkout" method="POST" id="customTrendfrm" name="customTrendfrm" novalidate>{{ csrf_field() }}
        <div class="pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mt-20 bg-white rounded shadow-sm mb-5">
                        <div class="table-responsive border">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2">Item</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2">Qty</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2">Price</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2">Remove</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($cartData) && !empty($cartData))
                                    @foreach($cartData as $key=> $value)
                                    <tr id="{{ $value->id }}">
                                        <td class="border-0 align-middle" name="title" id="title" value="{{$value->report_title}}">{{$value->report_title}}</td>
                                        <td class="border-0 align-middle" name="qty" id="qty">1</td>
                                        <td class="border-0 align-middle" id="price_id" name="price_id" value="{{$value->price_id}}">$ {{$value->price_id}}</td>
                                        <td class="border-0 align-middle"><a href="#" value="{{$value->id}}" id="removeItem" name="removeItem"><i class="fa fa-trash"></i></a></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td scope="col" class="border-0 bg-light" colspan="2">
                                            <strong>Total</strong>
                                        </td>
                                        <td scope="col" class="border-0 bg-light">
                                            <input type="hidden" name="totalPrice" id="totalPrice" value=""><strong id="displayPrice"></strong>
                                        </td>
                                        <td scope="col" class="border-0 bg-light" colspan=2>

                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12 col-xl-12 text-right">
                                <button type="button" id="btnCancel" class="btn btn-square-green uppercase blob-small">
                                    <div class="d-flex justify-content-between">
                                        <span>Cancel</span>
                                    </div>
                                </button>
                                <button type="button" id="clear-cart" class="btn btn-square-green uppercase blob-small">
                                    <div class="d-flex justify-content-between">
                                        <span>Clear Cart</span>
                                    </div>
                                </button>
                                <button type="submit" class="btn btn-square-green uppercase blob-small">
                                    <div class="d-flex justify-content-between">
                                        <span>Checkout</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
<script>
    $(document).ready(function() {
        var url = '{{URL::to('/cart/')}}';
        var sum = 0;
        $('.table tr').each(function() {
            var customerId = $(this).find("#price_id").text().replace('$', '');
            if (customerId.length) {
                sum = parseInt(sum) + parseInt(customerId);
            }
        });

        var totalPrice = document.querySelector('#displayPrice').textContent = '$' + sum + '.00';
        $("#totalPrice").val(totalPrice);

        $("#clear-cart").on('click', function() {
            $(".table").find('tbody').detach();
            var getTrIds = 1;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: url,
                data: {
                    getTrId: getTrIds
                },
                success: function(data) {
                    console.log("OK");
                }
            });
            if ($('.table tr').length == 2) {
                var row = '<tr><td colspan="4">No records found.</td></tr>';
                $(".table tr:first").after(row);
                var totalPrice = document.querySelector('#displayPrice').textContent = '$0.00';
                $("#totalPrice").val(totalPrice);
            }
        });

        $(".table").on('click', '#removeItem', function() {
            var getTrId = $(this).closest('tr').attr('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: url,
                data: {
                    getTrId: getTrId
                },
                success: function(data) {
                    console.log(data.length);
                }
            });

            $(this).closest('tr').remove();
            var sum = 0;
            if ($('.table tr').length == 2) {
                var row = '<tr><td colspan="4">No records found.</td></tr>';
                $(".table tr:first").after(row);
            }

            $('.table tr').each(function() {
                var customerId = $(this).find("#price_id").text().replace('$', '');
                if (customerId.length) {
                    sum = parseInt(sum) + parseInt(customerId);
                }
            });

            var totalPrice = document.querySelector('#displayPrice').textContent = '$' + sum + '.00';
            $("#totalPrice").val(totalPrice);
        });

        if ($('.table tr').length == 2) {
            var row = '<tr><td colspan="4">No records found.</td></tr>';
            $(".table tr:first").after(row);
            var totalPrice = document.querySelector('#displayPrice').textContent = '$0.00';
            $("#totalPrice").val(totalPrice);
        }

        $("#btnCancel").on('click', function() {
            window.location.href='/';
        });
    });
</script>
@endsection