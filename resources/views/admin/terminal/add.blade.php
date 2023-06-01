@extends('admin.layouts.default')

@section('title', 'Add '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ucwords(str_replace("-"," ", VIEW_INFO['title']))}} Managment</h3>   
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/email-template-types') }}" class="kt-subheader__breadcrumbs-link">{{ucwords(str_replace("-"," ", VIEW_INFO['title']))}}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="#" class="kt-subheader__breadcrumbs-link">Add {{ucwords(str_replace("-"," ", VIEW_INFO['title']))}} Details</a>

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
                                    Add {{ucwords(str_replace("-"," ", VIEW_INFO['title']))}}
                            </h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/add') }}" class="form-horizontal"
                    method="post">{{ csrf_field() }}
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
                                            <div class="form-group col-md-6">
                                                <label>Code<span class="required"><code>*</code></span></label>
                                                <input type="text" id="code" name="code" data-toggle="tooltip" title="Enter Code" class="form-control" placeholder="Enter Code" value="" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Zip Code<span class="required"><code>*</code></span></label>
                                                <input type="text" id="zip_code" name="zip_code" data-toggle="tooltip" title="Enter Zip Code" class="form-control" placeholder="Enter Zip Code" value="" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                    <label>Terminal<span class="required"><code>*</code></span></label>
                                                    <input type="text" id="terminal" name="terminal" data-toggle="tooltip" title="Enter Terminal" class="form-control" placeholder="Enter Terminal" value="" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                    <label>Gas Brand<span class="required"><code>*</code></span></label>
                                                    <input type="text" id="gas_brand" name="gas_brand" data-toggle="tooltip" title="Enter Gas Brand" class="form-control" placeholder="Enter Gas Brand" value="" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                    <label>Store Address<span class="required"><code>*</code></span></label>
                                                    <input type="text" id="store_address" name="store_address" data-toggle="tooltip" title="Enter Store Address" class="form-control" placeholder="Enter Store Address" value="" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                    <label>Nos of Pump<span class="required"><code>*</code></span></label>
                                                    <input type="text" id="nos_of_pump" name="nos_of_pump" data-toggle="tooltip" title="Enter Nos of Pump" class="form-control" placeholder="Enter Nos of Pump" value="" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                    <label>Unleaded<span class="required"><code>*</code></span></label>
                                                    <input type="text" id="unleaded" name="unleaded" data-toggle="tooltip" title="Enter Unleaded" class="form-control" placeholder="Enter Unleaded" value="" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                    <label>Midgrede<span class="required"><code>*</code></span></label>
                                                    <input type="text" id="midgrede" name="midgrede" data-toggle="tooltip" title="Enter Midgrede" class="form-control" placeholder="Enter Midgrede" value="" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                    <label>Premium<span class="required"><code>*</code></span></label>
                                                    <input type="text" id="premium" name="premium" data-toggle="tooltip" title="Enter Premium" class="form-control" placeholder="Enter Premium" value="" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                    <label>Diesel<span class="required"><code>*</code></span></label>
                                                    <input type="text" id="diesel" name="diesel" data-toggle="tooltip" title="Enter Diesel" class="form-control" placeholder="Enter Diesel" value="" />
                                            </div>
                                        </div>
                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <button type="submit" class="btn btn-primary">Save</button>
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
<script src="{{ asset('admin/assets/js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('admin/assets/js/pages/custom/terminal-selection.js')}}" type="text/javascript"></script>
<script>
CKEDITOR.replace( 'general_notes' );
</script>
@stop