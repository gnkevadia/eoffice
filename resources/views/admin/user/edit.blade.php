@extends('admin.layouts.default')

@section('title', 'Edit ' . VIEW_INFO['title'])

@section('content_header')
    <h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
    <span class="kt-subheader__separator kt-hidden"></span>
    <div class="kt-subheader__breadcrumbs">
        <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="{{ url('admin/user') }}" class="kt-subheader__breadcrumbs-link">{{ VIEW_INFO['title'] }}</a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="#" class="kt-subheader__breadcrumbs-link">Update {{ VIEW_INFO['title'] }} Details</a>

        <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
    </div>
@stop

@section('content')
    <!-- Main content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Edit {{ VIEW_INFO['title'] }}
                            </h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form enctype="multipart/form-data" id="frmAddEdit" name="frmAddEdit"
                        action="{{ url(VIEW_INFO['url'] . '/edit/' . $data->id) }}" class="form-horizontal" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id" value="{{ $data->id }}">
                        <div class="kt-portlet__body">
                            <div class="form-group form-group-last">
                                <div class="alert alert-secondary" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                                    <div class="alert-text">
                                        <code>*</code> indicates a required field.
                                    </div>
                                </div>
                            </div>
                            @include('admin.includes.errormessage')

                            <div class="form-group">
                                <label>Name<span class="required">*</span></label>
                                <input type="text" id="name" name="name" data-toggle="tooltip" title=" Name"
                                    class="form-control" placeholder="Enter  Name" value="{{ $data['name'] }}" />
                            </div>
                            <div class="form-group">
                                <label>Email<span class="required">*</span></label>
                                <input type="text" id="email" name="email" data-toggle="tooltip" title="Email"
                                    class="form-control" placeholder="Email" value="{{ $data['email'] }}">
                            </div>
                            <div class="form-group">
                                <label>Address1<span class="required">*</span></label>
                                <input type="text" id="address1" name="address1" data-toggle="tooltip" title="Address1"
                                    class="form-control" placeholder="Address1" value="{{ $data['address1'] }}">
                            </div>
                            <div class="form-group">
                                <label>Address2<span class="required">*</span></label>
                                <input type="text" id="address2" name="address2" data-toggle="tooltip" title="Address2"
                                    class="form-control" placeholder="Address2" value="{{ $data['address2'] }}">
                            </div>
                            <div class="form-group">
                                <label>Postal Code<span class="required">*</span></label>
                                <input type="text" id="postal_code" name="postal_code" data-toggle="tooltip"
                                    title="Postal Code" class="form-control" placeholder="Postal Code"
                                    value="{{ $data['postal_code'] }}">
                            </div>
                            {{-- <div class="form-group">
                                <label>Country<span class="required"><code>*</code></span></label>
                                <div>
                                    <select name="country_id" id="country_id" class="form-control">
                                        @if (isset($arrCountry) && !empty($arrCountry))
                                        @foreach ($arrCountry as $key => $val)
                                            <option value="{{ $val->id }}" @if (isset($data['country_id']) && $val->id == $data['country_id']) selected @endif >{{ $val->nicename }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label>State<span class="required"><code>*</code></span></label>
                                <div>
                                    <select name="state_id" id="state_id" class="form-control">
                                        @if (isset($arrState) && !empty($arrState))
                                        @foreach ($arrState as $key => $val)
                                            <option value="{{ $val->id }}" @if (isset($data['state_id']) && $val->id == $data['state_id']) selected @endif >{{ $val->states_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label>City<span class="required"><code>*</code></span></label>
                                <div>
                                    <select name="city_id" id="city_id" class="form-control">
                                        @if (isset($arrCity) && !empty($arrCity))
                                        @foreach ($arrCity as $key => $val)
                                            <option value="{{ $val->id }}" @if (isset($data['city_id']) && $val->id == $data['city_id']) selected @endif >{{ $val->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <label>Country<span class="required"><code>*</code></span></label>
                                <select id="country" class='form-control' name="country">
                                    <option value="">Country</option>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label>State<span class="required"><code>*</code></span></label>
                                <select id="region" class='form-control' name="state">
                                    <option value="">State</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>City<span class="required"><code>*</code></span></label>
                                <select id="city" class='form-control' name="city">
                                    <option value="">City</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Role<span class="required"><code>*</code></span></label>
                                <div>
                                    <select name="role_id[]" id="role_id" class="form-control select2"
                                        multiple="multiple">
                                        <option value="">-Select Role-</option>
                                        @if (isset($arrRole) && !empty($arrRole))
                                            @foreach ($arrRole as $key => $val)
                                                <option value="{{ $val->id }}"
                                                    {{ in_array($val->id, explode(',', $data['role_id'])) ? 'selected' : '' }}>
                                                    {{ $val->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Image Upload<span class="required">*</span></label>
                                <input type="file" id="file" name="file" data-toggle="tooltip"
                                    title="file" class="form-control" placeholder="profile photo"
                                    value="{{ old('profile_photo') }}">
                                @if (in_array(pathinfo($data->profile_photo, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'bmp']))
                                    <img src="{{ url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $data->profile_photo) }}"
                                        alt="image">
                                @elseif(in_array(pathinfo($data->profile_photo, PATHINFO_EXTENSION), ['mp4']))
                                    <img src="{{ url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . str_replace(pathinfo($data->profile_photo, PATHINFO_EXTENSION), 'png', $data->media_file)) }}"
                                        alt="image">
                                @else
                                    <a
                                        href="{{ url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $data->profile_photo) }}">{{ $data->profile_photo }}</a>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="exampleSelect1">Status<span class="required">*</span></label>
                                <select class="form-control" id="status" name="status">
                                    <option {{ $data['status'] == 1 ? 'selected' : '' }} value="1">Active</option>
                                    <option {{ $data['status'] == 0 ? 'selected' : '' }} value="0">Inactive
                                    </option>
                                </select>
                            </div>
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" id="reset" class="btn btn-secondary">Reset</button>
                                    <a href="{{ url(VIEW_INFO['url']) }}"><button type="button" class="btn btn-success"
                                            id="back">Cancel</button></a>
                                </div>
                            </div>
                    </form>

                    <!--end::Form-->
                </div>

                <!--end::Portlet-->
            </div>
        </div>
    </div>
    <!-- Main content -->
@stop

@section('metronic_js')
    <script src="{{ asset('admin/assets/js/pages/custom/user.js') }}"></script>
    <script>
        $(document).ready(function() {
            //-------------------------------SELECT CASCADING-------------------------//
            var selectedCountry = (selectedRegion = selectedCity = "");
            // This is a demo API key for testing purposes. You should rather request your API key (free) from http://battuta.medunes.net/
            var BATTUTA_KEY = "00000000000000000000000000000000";
            // Populate country select box from battuta API
            url =
                "https://battuta.medunes.net/api/country/all/?key=" +
                BATTUTA_KEY +
                "&callback=?";

            // EXTRACT JSON DATA.
            $.getJSON(url, function(data) {
                console.log(data);
                $.each(data, function(index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $("#country").append(
                        '<option value="' + value.code + '">' + value.name + "</option>"
                    );
                });
            });
            // Country selected --> update region list .
            $("#country").change(function() {
                selectedCountry = this.options[this.selectedIndex].text;
                countryCode = $("#country").val();
                // Populate country select box from battuta API
                url =
                    "https://battuta.medunes.net/api/region/" +
                    countryCode +
                    "/all/?key=" +
                    BATTUTA_KEY +
                    "&callback=?";
                $.getJSON(url, function(data) {
                    $("#region option").remove();
                    $('#region').append('<option value="">Please select your State</option>');
                    $.each(data, function(index, value) {
                        // APPEND OR INSERT DATA TO SELECT ELEMENT.
                        $("#region").append(
                            '<option value="' + value.region + '">' + value.region +
                            "</option>"
                        );
                    });
                });
            });
            // Region selected --> updated city list
            $("#region").on("change", function() {
                selectedRegion = this.options[this.selectedIndex].text;
                // Populate country select box from battuta API
                countryCode = $("#country").val();
                region = $("#region").val();
                url =
                    "https://battuta.medunes.net/api/city/" +
                    countryCode +
                    "/search/?region=" +
                    region +
                    "&key=" +
                    BATTUTA_KEY +
                    "&callback=?";
                $.getJSON(url, function(data) {
                    console.log(data);
                    $("#city option").remove();
                    $('#city').append('<option value="">Please select your city</option>');
                    $.each(data, function(index, value) {
                        // APPEND OR INSERT DATA TO SELECT ELEMENT.
                        $("#city").append(
                            '<option value="' + value.city + '">' + value.city +
                            "</option>"
                        );
                    });
                });
            });
            // city selected --> update location string
            $("#city").on("change", function() {
                selectedCity = this.options[this.selectedIndex].text;
                $("#location").html(
                    "Locatation: Country: " +
                    selectedCountry +
                    ", Region: " +
                    selectedRegion +
                    ", City: " +
                    selectedCity
                );
            });
        });
    </script>
@stop
