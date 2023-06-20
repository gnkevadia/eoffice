@extends('admin.layouts.default')

@section('title', 'Add ' . VIEW_INFO['title'])


@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/module') }}" class="kt-subheader__breadcrumbs-link">{{ VIEW_INFO['title'] }}</a>
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
                            Add {{ VIEW_INFO['title'] }}
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form enctype="multipart/form-data" id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'] . '/add') }}" class="kt-form" method="post">
                    {{ csrf_field() }}
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
                            <input type="text" id="name" name="name" data-toggle="tooltip" title=" Name" class="form-control" placeholder="Enter  Name" value="{{ old('name') }}" />
                        </div>
                        <div class="form-group">
                            <label>Email<span class="required">*</span></label>
                            <input type="text" id="email" name="email" data-toggle="tooltip" title="Email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label>Password<span class="required">*</span></label>
                            <input type="password" id="password" name="password" data-toggle="tooltip" title="Password" class="form-control" placeholder="Password" value="{{ old('password') }}">
                        </div>
                        <!-- <div class="form-group">
                                        <label>Re-Password<span class="required">*</span></label>
                                        <input type="text" id="re_password" name="re_password" data-toggle="tooltip" title="Re-Password"
                                                class="form-control" placeholder="Re-Password" value="{{ old('re_password') }}">
                                    </div> -->

                        <div class="form-group">
                            <label>Address1<span class="required">*</span></label>
                            <input type="text" id="address1" name="address1" data-toggle="tooltip" title="Address1" class="form-control" placeholder="Address1" value="{{ old('address1') }}">
                        </div>
                        <div class="form-group">
                            <label>Address2<span class="required">*</span></label>
                            <input type="text" id="address2" name="address2" data-toggle="tooltip" title="Address2" class="form-control" placeholder="Address2" value="{{ old('address2') }}">
                        </div>
                        <div class="form-group">
                            <label>Postal Code<span class="required">*</span></label>
                            <input type="text" id="postal_code" name="postal_code" data-toggle="tooltip" title="Postal Code" class="form-control" placeholder="Postal Code" value="{{ old('postal_code') }}">
                        </div>
                        <div class="form-group">
                            <label>Country<span class="required"><code>*</code></span></label>
                            <div>
                                <select name="country_id" id="country" class='form-control'>
                                    <option value="">-- Country --</option>
                                    @if (isset($arrCountry) && !empty($arrCountry))
                                    @foreach ($arrCountry as $key => $val)
                                    <option value="{{$val->id}}">{{$val->nicename}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>State<span class="required"><code>*</code></span></label>
                            <div>
                                <select name="state_id" id="state_id" class="form-control">
                                    <option value="">-Select State-</option>
                                    @if (isset($arrState) && !empty($arrState))
                                    @foreach ($arrState as $key => $val)
                                    <option value="{{ $val->id }}" {{ old('state_id') == $val->id ? 'selected' : '' }}>{{ $val->states_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>City<span class="required"><code>*</code></span></label>
                            <div>
                                <select name="city_id" id="city_id" class="form-control">
                                    <option value="">-Select City-</option>
                                    @if (isset($arrCity) && !empty($arrCity))
                                    @foreach ($arrCity as $key => $val)
                                    <option value="{{ $val->id }}" {{ old('city_id') == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        @if (session()->get('superAdmin'))
                        <div class="form-group">
                            <label>Company<span class="required"><code>*</code></span></label>
                            <div>
                                <select name="company_id" id="company" class="form-control">
                                    <option value="">-Select Company-</option>
                                    @foreach ($companyData as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Business<span class="required"><code>*</code></span></label>
                            <div>
                                <select name="business_id" id="business" class="form-control">
                                    <option value="">-Select Business-</option>
                                    @foreach ($arrBusiness as $business)
                                    <option value="{{ $business->id }}">{{ $business->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label>Department<span class="required"><code>*</code></span></label>
                            <div>
                                <select name="department_id" id="department" class="form-control">
                                    <option value="">-Select Department-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Role<span class="required"><code>*</code></span></label>
                            <div>
                                <select name="role_id" id="role_id" class="form-control">
                                    <option value="">-Select Role-</option>
                                    @if (isset($arrRole) && !empty($arrRole))
                                    @foreach ($arrRole as $key => $val)
                                    <option value="{{ $val->id }}" {{ old('role_id') == $val->id ? 'selected' : '' }}>{{ $val->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-group form-group-last ">
                                        <label>Upload Image</label>
                                        <div class="col-lg-9">
                                        <div class="dropzone dropzone-multi" id="kt_dropzone_4">
                                            <div class="dropzone-panel">
                                                <a class="dropzone-select btn btn-label-brand btn-bold btn-sm">Attach files</a>
                                                <a class="dropzone-upload btn btn-label-brand btn-bold btn-sm">Upload All</a>
                                                <a class="dropzone-remove-all btn btn-label-brand btn-bold btn-sm">Remove All</a>
                                            </div>
                                            <div class="dropzone-items">
                                                <div class="dropzone-item" style="display:none">
                                                    <div class="dropzone-file">
                                                        <div class="dropzone-filename" title="some_image_file_name.jpg"><span data-dz-name>some_image_file_name.jpg</span> <strong>(<span  data-dz-size>340kb</span>)</strong></div>
                                                        <div class="dropzone-error" data-dz-errormessage></div>
                                                    </div>
                                                    <div class="dropzone-progress">
                                                        <div class="progress">
                                                            <div class="progress-bar kt-bg-brand" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress></div>
                                                        </div>
                                                    </div>
                                                    <div class="dropzone-toolbar">
                                                        <span class="dropzone-start"><i class="flaticon2-arrow"></i></span>
                                                        <span class="dropzone-cancel" data-dz-remove style="display: none;"><i class="flaticon2-cross"></i></span>
                                                        <span class="dropzone-delete" data-dz-remove><i class="flaticon2-cross"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span>
                                        </div>
                                        </div>
                                    </div> -->
                        <div class="form-group">
                            <label>Image Upload<span class="required">*</span></label>
                            <input type="file" id="file" name="file" data-toggle="tooltip" title="file" class="form-control" placeholder="profile photo" value="{{ old('profile_photo') }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Status<span class="required">*</span></label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" id="reset" class="btn btn-secondary">Reset</button>
                                <a href="{{ url(VIEW_INFO['url']) }}"><button type="button" class="btn btn-success" id="back">Cancel</button></a>
                            </div>
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
<script src="{{ asset('admin/assets/js/pages/crud/file-upload/dropzonejs.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {

        $("#company").change(function() {
            let id = $(this).val();
            let url = '{{url("getDepartments")}}';
            console.log('url', url);
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: url,
                type: 'post',
                data: {
                    'id': id
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log('data', data);
                    var html = '<option value="">-Select Department-</option>';
                    $.each(data, function(i) {
                        console.log(data[i]);
                        html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    });
                    $("#department").html(html);
                }
            });
        });


        /*  var selectedCountry = (selectedRegion = selectedCity = "");
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
                 let id = 1;
                 $.each(data, function(index, value) {
                     // APPEND OR INSERT DATA TO SELECT ELEMENT.
                     $("#region").append(
                         '<option value="' + id + '" data-id="' + value.region + '">' + value.region +
                         "</option>"
                     );
                     id++;
                 });
             });
         });
         // Region selected --> updated city list
         $("#region").on("change", function() {
             selectedRegion = this.options[this.selectedIndex].text;
             // Populate country select box from battuta API
             countryCode = $("#country").val();
             region = $("#region").data('id');
             console.log('region', region);
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
         }); */
    });
</script>
@stop