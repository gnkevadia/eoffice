@extends('admin.layouts.default')

@section('title', 'EDIT '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">Orders Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/booking') }}" class="kt-subheader__breadcrumbs-link">Orders</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="#" class="kt-subheader__breadcrumbs-link">View Orders Details</a>
    <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
</div>
@stop

@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="accordion" id="accordionExample1">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <div class="card-title" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                                    Order Details
                                </div>
                            </div>
                            <div id="collapseOne1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Booking Number</label>
                                                <input type="text" name="order_number" id="order_number" class="form-control" value="{{ $data->id }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Invoice Id</label>
                                                <input type="text" name="bookingid" id="" class="form-control" value="{{ $data->cart_id }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea type="text" name="guardian_address" id="" class="form-control">{!! $UserObj->address1 !!}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" name="guardian_email" id="" class="form-control" value="{{ $UserObj->email }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Booking Date</label>
                                                <input type="text" name="booking_date" id="" class="form-control" value="{{ $data->booking_date }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="guardian_name" id="" class="form-control" value="{{ $UserObj->name }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Mobile</label>
                                                <input type="text" name="guardian_mobile" id="" class="form-control" value="{{ $UserObj->phone_number }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Report Name</label>
                                                <input type="text" name="report_title" id="" class="form-control" value="{{ $data->report_title }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <div class="card-title" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                                    Requested Order Details
                                </div>
                            </div>
                            <div id="collapseOne1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample1">
                                <div class="row">
                                    @if(!empty($terminalData) && isset($terminalData))
                                        <?php $i = 0; ?>
                                        @foreach($terminalData as $key=>$terminalValue)
                                            @foreach($terminalValue as $keys=>$value)
                                            <div class="col-md-6">
                                                <div class="card-body">
                                                <h5>Requested Report Details <?php echo $i; ?></h5>
                                                    <div class="form-group">
                                                        <label>Code</label>
                                                        <input type="text" name="code" id="code" class="form-control" value="{{ $value->code }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Terminal</label>
                                                        <input type="text" name="terminal" id="terminal" class="form-control" value="{{ $value->terminal }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Store Address</label>
                                                        <input type="text" name="store_address" id="store_address" class="form-control" value="{{ $value->store_address }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Unleaded</label>
                                                        <input type="text" name="unleaded" id="unleaded" class="form-control" value="{{ $value->unleaded }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Premium</label>
                                                        <input type="text" name="premium" id="premium" class="form-control" value="{{ $value->premium }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card-body">
                                                    <div class="form-group pt-admin-4">
                                                        <label>Zip Code</label>
                                                        <input type="text" name="zip_code" id="zip_code" class="form-control" value="{{ $value->zip_code }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Gas Brand</label>
                                                        <input type="text" name="gas_brand" id="gas_brand" class="form-control" value="{{ $value->gas_brand }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nos of Pump</label>
                                                        <input type="text" name="nos_of_pump" id="nos_of_pump" class="form-control" value="{{ $value->nos_of_pump }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Midgrede</label>
                                                        <input type="text" name="midgrede" id="midgrede" class="form-control" value="{{ $value->midgrede }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Diesel</label>
                                                        <input type="text" name="diesel" id="diesel" class="form-control" value="{{ $value->diesel }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <?php $i++; ?>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Portlet-->
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                <button type="button" class="btn btn-primary dataSelect" id="accepted" name="accepted" value="1">Accepted</button>
                <button type="button" class="btn btn-danger dataSelect" id="rejected" name="rejected" value="2" >Rejected</button>
                    <a href="{{ url(VIEW_INFO['url']) }}"><button type="button" class="btn btn-warning" id="back">Back</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main content -->

@stop

@section('metronic_js')
<script src="{{ asset('admin/assets/js/pages/custom/booking.js') }}"></script>
<script>
    $(document).ready(function(){
        $(document).on('click', '.dataSelect', function () {
            var optionId 	= $(this).val();
            var cartId 		= <?php echo $data->cart_id; ?>;
            var userId 		= <?php echo $data->user_id; ?>;
            var optionval 	= $(this).text();
            if (optionId) {
                $.confirm({
                    title: 'Are You Sure!',
                    content: 'Are You Sure you want to ' + optionval.substr(0, 6) + ' this order.',
                    type: 'dark',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'OK',
                            action: function () {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    type: 'POST',
                                    url: '/admin/booking/toggle',
                                    data: { optionId: optionId, cartId: cartId, userId: userId },
                                    success: function (data) {
                                        //window.location.reload();
                                        console.log('OK');
                                    }
                                });
                            }
                        },
                        close: function () {
                        }
                    }
                });
            }
        });
    });
</script>
@stop