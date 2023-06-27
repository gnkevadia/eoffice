@extends('admin.layouts.default')

@section('title', 'Edit ' . VIEW_INFO['title'])
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

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
                <form enctype="multipart/form-data" id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'] . '/edit/' . $data->id) }}" class="form-horizontal" method="post">
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
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Name<span class="required">*</span></label>
                                    <input type="text" id="name" name="name" data-toggle="tooltip" title=" Name" class="form-control" placeholder="Enter  Name" value="{{ $data['name'] }}" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Email<span class="required">*</span></label>
                                    <input type="text" id="email" name="email" data-toggle="tooltip" title="Email" class="form-control" placeholder="Email" value="{{ $data['email'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Address1<span class="required">*</span></label>
                                    <input type="text" id="address1" name="address1" data-toggle="tooltip" title="Address1" class="form-control" placeholder="Address1" value="{{ $data['address1'] }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Address2<span class="required">*</span></label>
                                    <input type="text" id="address2" name="address2" data-toggle="tooltip" title="Address2" class="form-control" placeholder="Address2" value="{{ $data['address2'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Postal Code<span class="required">*</span></label>
                                    <input type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" id="postal_code" name="postal_code" data-toggle="tooltip" title="Postal Code" class="form-control" placeholder="Postal Code" value="{{ $data['postal_code'] }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Country<span class="required"><code>*</code></span></label>
                                    <div>
                                        <select name="country_id" id="country_id" class="form-control">
                                            <option value="">-Select Country-</option>
                                            @if (isset($arrCountry) && !empty($arrCountry))
                                            @foreach ($arrCountry as $key => $val)
                                            <option value="{{ $val->id }}" @if (isset($data['country_id']) && $val->id == $data['country_id']) selected @endif >{{ $val->nicename }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>State<span class="required"><code>*</code></span></label>
                                    <div>
                                        <select name="state_id" id="state_id" class="form-control">
                                            <option value="">-Select State-</option>
                                            @if (isset($arrState) && !empty($arrState))
                                            @foreach ($arrState as $key => $val)
                                            <option value="{{ $val->id }}" @if (isset($data['state_id']) && $val->id == $data['state_id']) selected @endif >{{ $val->states_name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>City<span class="required"><code>*</code></span></label>
                                    <div>
                                        <select name="city_id" id="city_id" class="form-control">
                                            <option value="">-Select City-</option>
                                            @if (isset($arrCity) && !empty($arrCity))
                                            @foreach ($arrCity as $key => $val)
                                            <option value="{{ $val->id }}" @if (isset($data['city_id']) && $val->id == $data['city_id']) selected @endif >{{ $val->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (session()->get('superAdmin'))
                        <div class="form-group">
                            <label>Company<span class="required"><code>*</code></span></label>
                            <div>
                                <select name="company_id" id="company" class="form-control">
                                    <option value="">-Select Company-</option>
                                    @foreach ($companyData as $company)
                                    <option value="{{ $company->id }}" {{($company->id == $data->company_id ? 'selected' : '')}}>{{ $company->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Department<span class="required"><code>*</code></span></label>
                                    <div>
                                        <select name="department_id" id="department" class="form-control">
                                            <option value="">-Select Department-</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Business<span class="required"><code>*</code></span></label>
                                    <div>
                                        <select name="business_id" id="business" class="form-control">
                                            <option value="">-Select Business-</option>
                                            @foreach ($arrBusiness as $business)
                                            <option value="{{ $business->id }}" {{($business->id == $data->business_id ? 'selected' : '')}}>{{ $business->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        @if(Session::get('sub_admin'))
                        <div class="form-group">
                            <label>Department<span class="required"><code>*</code></span></label>
                            <div>
                                <select name="department_id" id="department" class="form-control">
                                    <option value="">-Select Department-</option>
                                    @foreach ($arrDepartment as $department)
                                    <option value="{{ $department->id }}" {{($department->id == $data->department_id ? 'selected' : '')}}>{{ $department->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        @endif
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Role<span class="required"><code>*</code></span></label>
                                    <div>
                                        <select name="role_id[]" id="role_id" class="form-control select2" multiple="multiple">
                                            <option value="">-Select Role-</option>
                                            @if (isset($arrRole) && !empty($arrRole))
                                            @foreach ($arrRole as $key => $val)
                                            <option value="{{ $val->id }}" {{ in_array($val->id, explode(',', $data['role_id'])) ? 'selected' : '' }}>
                                                {{ $val->name }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Image Upload<span class="required">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" id="file" name="file" data-toggle="tooltip" title="file" class="custom-file-input" placeholder="profile photo" value="{{ old('profile_photo') }}">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                    @if (in_array(pathinfo($data->profile_photo, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'bmp']))
                                    <img src="{{ url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $data->profile_photo) }}" class="kt-radius-100 mt-3" alt="image" width="100" onclick="onClick(this)">
                                    @elseif(in_array(pathinfo($data->profile_photo, PATHINFO_EXTENSION), ['mp4']))
                                    <img src="{{ url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . str_replace(pathinfo($data->profile_photo, PATHINFO_EXTENSION), 'png', $data->media_file)) }}" alt="image">
                                    @else
                                    <a href="{{ url($arrFile['path'] . $arrFile['resize'] . 'x' . $arrFile['resize'] . '/' . $data->profile_photo) }}">{{ $data->profile_photo }}</a>
                                    @endif
                                </div>
                            </div>
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
                                <a href="{{ url(VIEW_INFO['url']) }}"><button type="button" class="btn btn-success" id="back">Cancel</button></a>
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
<div id="modal01" class="w3-modal" onclick="this.style.display='none'">
    <div class="w3-modal-content w3-animate-zoom">
        <img id="img01" style="width:100%">
        <span class="w3-button w3-hover-red w3-xlarge w3-display-topright bg-light" style="height: 40px;">&times;</span>
        <span class="w3-button w3-hover-green w3-xlarge w3-display-topright downloadImg mr-5 bg-light border-right boder-primary" style="margin-right: 48px !important;"><i class="fa fa-download"></i></span>
    </div>
</div>
@stop

@section('metronic_js')
<script src="{{ asset('admin/assets/js/pages/custom/user.js') }}"></script>
<script>
    $(document).ready(function() {
        // console.log('values', $("#company").val());
        // $("#company").trigger('change');
        $("#company").change(function() {
            let id = $(this).val();
            let url = '{{url("getDepartments")}}';
            if (id == null) {
                id = '0';
            }
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
                    var html = '<option value="">-Select Department-</option>';
                    let departId = <?php echo $data->department_id; ?>;
                    // if (departId != null) {
                    $.each(data, function(i) {
                        if (departId == data[i].id) {
                            html += '<option value="' + data[i].id + '" selected>' + data[i].name + '</option>';
                        } else {
                            html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }
                    });
                    // }
                    $("#department").html(html);
                }
            });
        }).change();

    });

    function onClick(element) {
        document.getElementById("img01").src = element.src;
        document.getElementById("modal01").style.display = "block";
        $('.downloadImg').wrap('<a href="' + element.src + '" download />')
    }
</script>
@stop