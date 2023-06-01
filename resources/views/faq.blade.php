@extends('layouts.default')
@section('content')
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================= -->
<!-- nav Tabs -->
<section>
    <div class="bg-light-white border rounded-5">
      <section class="p-4">
        <div class="tab-content" id="ex1-content">
          <div class="container">
            <div class="row align-items-end  mb-45">
              <div class="col-lg-7 col-md-12 text-center text-lg-left">
                <h2>Frequently Asked Questions</h2>
              </div>
            </div>
            <div class="row">
              @if(isset($faq) && !empty($faq))
                @foreach($faq as $key=>$val)
                  <div class="col-lg-4 col-md-6">
                    <div class="service-box type-2 transition-4 text-left relative img-lined mb-30">
                      <div class="service-text">
                        <h4 class="f-700 mt-20 mb-10">
                          {{$val->question}}
                        </h4>
                      </div>
                      <h6 class="f-700 mt-20 mb-10">
                        <?php $timestamp = strtotime($val->created_at);
                        $newDate = date('d-F-Y', $timestamp);
                        echo '<i class="fas fa-clock" style="padding-right: 5px;"></i>';
                        echo $newDate; //outputs 02-March-2011 
                        ?>
                    </h6>
                      <div class="service-text">
                        <p>
                            {{$val->answer}}
                        </p>
                      </div>
                    </div>
                  </div>
                @endforeach
              @else
                <div class="col-12">
                  No data found.
                </div>
              @endif
            </div>
          </div>
          <div class="container d-flex justify-content-center">
            {!! $faq->withQueryString()->links('pagination::bootstrap-5') !!}
          </div>
        </div>
      </section>
    </div>
  </section>

{{-- <section class="about-us pt-10 pb-70">
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
</section> --}}

<!-- nav Tabs -->
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
{{-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> --}}
{{-- <script>
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
</script> --}}
@endsection