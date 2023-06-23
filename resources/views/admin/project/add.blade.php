@extends('admin.layouts.default')

@section('title', 'Add '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/rights') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="#" class="kt-subheader__breadcrumbs-link">Add {{ VIEW_INFO['title'] }} Details</a>

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
                <form id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/add') }}" class="kt-form" method="post">
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
                        @if (session()->get('superAdmin'))
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Company<span class="required"><code>*</code></span></label>
                                    <div>
                                        <select name="company_id" id="company" class="form-control">
                                            <option value="">-Select Company-</option>
                                            @foreach ($companyData as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Department<span class="required"><code>*</code></span></label>
                                    <div>
                                        <select name="department_id" id="department" class="form-control department">
                                            <option value="">-Select Department-</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleSelect1">Manager<span class="required">*</span></label>
                                    <select class="form-control manager" id="manager" name="manager">
                                        <option value="" selected>-Select Manager-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Name<span class="required">*</span></label>
                                    <input type="text" id="name" name="name" data-toggle="tooltip" title="Enter Project Name" class="form-control" placeholder="Enter Project Name" value="{{ old('name') }}" />
                                </div>
                            </div>
                        </div>
                        @endif
                        @if (session()->get('sub_admin'))
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Department<span class="required"><code>*</code></span></label>
                                    <div>
                                        <select name="department_id" id="department" class="form-control department">
                                            <option value="">-Select Department-</option>
                                            @foreach ($arrDepartment as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleSelect1">Manager<span class="required">*</span></label>
                                    <select class="form-control manager" id="manager" name="manager">
                                        <option value="" selected>-Select Manager-</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if (!session()->get('superAdmin'))
                        <div class="form-group">
                            <label>Name<span class="required">*</span></label>
                            <input type="text" id="name" name="name" data-toggle="tooltip" title="Enter Project Name" class="form-control" placeholder="Enter Project Name" value="{{ old('name') }}" />
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Start Date<span class="required">*</span></label>
                                    <input type="date" id="start_date" name="start_date" data-toggle="tooltip" title="Enter Start Date" class="form-control" placeholder="Enter Start Date" value="{{ old('start_date') }}">
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>End Date<span class="required">*</span></label>
                                    <input type="date" id="end_date" name="end_date" data-toggle="tooltip" title="Enter End Date" class="form-control" placeholder="Enter End Date" value="{{ old('end_date') }}">
                                </div>
                            </div>
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
<script src="{{ asset('admin/assets/js/pages/custom/project-master-validation.js') }}"></script>
<script>
    $(document).ready(function() {

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
                    console.log('data', data);
                    var html = '<option value="">-Select Department-</option>';
                    $.each(data, function(i) {
                        html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    });
                    $("#department").html(html);
                }
            });
        });

        $(".department").change(function() {
            let id = $(this).val();
            let companyId = $('#company').val();
            let url = '{{url("getManager")}}';
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
                    'id': id,
                    'company_id': companyId
                },
                dataType: 'JSON',
                success: function(data) {
                    var html = '<option value="">-Select Manager-</option>';
                    $.each(data, function(i) {
                        html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    });
                    $(".manager").html(html);
                }
            });
        });
    });
</script>
@stop