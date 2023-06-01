@extends('layouts.default')
@section('content')
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================= -->
<!-- nav Tabs -->
<section>
    <form class="needs-validation" action="/custom-trends" method="POST" id="customTrendfrm" name="customTrendfrm" novalidate>{{ csrf_field() }}
        <input type="hidden" name="user_id" id="user_id" value="<?php echo Session::get('id'); ?>">
        <input type="hidden" name="cart_id" id="cart_id" value="<?php echo rand(); ?>">
        <div class="bg-white border rounded-5">
            <section class="p-4">
                <div class="tab-content" id="ex1-content">
                    <div class="container">
                        <div class="row align-items-end  mb-45">
                            <div class="col-lg-7 col-md-12 text-center text-lg-left">
                                <div class="fancy-head left-al">
                                    <h2>Review & Name Your Trend Report.</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="basic-url"><b>Enter a title for your report</b> (Name of the report will appear on invoice.)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="report_title" id="report_title" placeholder="Enter a title for Your Report" required />
                                    <div class="invalid-feedback">
                                        <b>Please Enter a title for Your Report.</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-30"></div>
                        <label for="basic-url"><b>Review to select set.</b></label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tableData" name="tableData">
                                <thead>
                                    <tr>
                                        <th scope="col" rowspan="2">Gas Brand</th>
                                        <th scope="col" rowspan="2">Zip Code</th>
                                        <th scope="col" rowspan="2">No Of Pump</th>
                                        <th scope="col" rowspan="2">Unleaded</th>
                                        <th scope="col" colspan="3" class="text-center">Types</th>
                                    </tr>
                                    <tr>
                                        <td scope="col"><strong>Midgrede</strong></td>
                                        <td scope="col"><strong>Premium</strong></td>
                                        <td scope="col"><strong>Diesel</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@isset($terminal_data) && !empty($terminal_data))
                                    @foreach($terminal_data as $key=> $value)
                                    @foreach($value as $key=> $val)
                                    <tr>
                                        <td>{{$val['gas_brand']}}</td>
                                        <td>{{$val['zip_code']}}</td>
                                        <td>{{$val['nos_of_pump']}}</td>
                                        <td>{{$val['unleaded']}}</td>
                                        <td>{{$val['midgrede']}}</td>
                                        <td>{{$val['premium']}}</td>
                                        <td>{{$val['diesel']}}</td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12 pb-10">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="selectReview" name="" required>
                                    <label class="custom-control-label fs-13" for="selectReview"><span class="label-check"><b>I have reviewed the select set.</b></span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="radioDiv">
                            <div class="col-lg-12 ">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="basic-url"><b>Select time frame for report.</b></label>
                                                <div class="row align-items-end  mb-45">
                                                    @if(!empty($reportTitle) && !empty($reportPrice))
                                                        @foreach($reportTitle as $key => $reportTitlevalues)
                                                            @if(array_key_exists($key,$reportPrice))
                                                            <div class="col-lg-7 col-md-12 text-center text-lg-left">
                                                                <label><input type="radio" name="price_id" id="price_id" value="{{$reportPrice[$key]}}"> {{ $reportTitlevalues }} - $ {{ $reportPrice[$key] }} Per Report</label>
                                                            </div> 
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="basic-url"><b>Rush Report</b></label>
                                                <div class="row align-items-end  mb-45">
                                                    <div class="col-md-12 text-center text-lg-left">
                                                        <label><input type="radio" name="price_id" id="price_id" value="950"> Please RUSH my report (24-hour
                                                            turn-around time, Monday through Friday)</label>
                                                        <p class="color-red"><b>Note: Price of Trend wil be doubled if this option is selected.</b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-9">
                                <label><b>Total Report Price:</label></b>
                                <h3 id="updatePrice"></h3>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-square-green uppercase blob-small" id="addToCart"><i class="fas fa-shopping-cart"></i> Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </form>
</section>

<!-- nav Tabs -->
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
@parent
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
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
<script type="text/javascript">
    $('#radioDiv').on('click', function() {
        output = $('input[name=price_id]:checked', '#customTrendfrm').val();
        document.querySelector('#updatePrice').textContent = '$' + output + '.00';
    });
</script>
@endsection