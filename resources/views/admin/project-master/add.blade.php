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
                            <div class="form-group">
                                <label>Name<span class="required">*</span></label>
                                <input type="text" id="name" name="name" data-toggle="tooltip" title="Enter Project Name" class="form-control" placeholder="Enter Project Name" value="{{ old('name') }}" />
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleSelect1">Manager<span class="required">*</span></label>
                                <select class="form-control" id="manager" name="manager">
                                        <option value="1" selected>GK</option>
                                        <option value="0">Vipul Patel</option>
                                </select>
                            </div>

                            <div class="form-group">
                                    <label>Start Date<span class="required">*</span></label>
                                    <input type="date" id="start_date" name="start_date" data-toggle="tooltip" title="Enter Start Date" class="form-control" placeholder="Enter Start Date" value="{{ old('start_date') }}">
                            </div>
                           
                            <div class="form-group">
                                    <label>End Date<span class="required">*</span></label>
                                    <input type="date" id="end_date" name="end_date" data-toggle="tooltip" title="Enter End Date" class="form-control" placeholder="Enter End Date" value="{{ old('end_date') }}">
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
<script src="{{ asset('admin/assets/js/pages/custom/rights.js') }}"></script>
@stop