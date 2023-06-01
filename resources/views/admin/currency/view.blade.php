@extends('admin.layouts.default')

@section('title', 'Edit '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/currency') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="#" class="kt-subheader__breadcrumbs-link">View {{ VIEW_INFO['title'] }} Details</a>

    <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
</div>
@stop
@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-md-12">
    
                <!--begin::Portlet-->
                <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                        View {{ VIEW_INFO['title'] }}
                                </h3>
                            </div>
                        </div>
                        <!--begin::Form-->
                        
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
                                                <label>Name<span class="required">*</span></label>
                                                <input type="text" id="name" name="name" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" value="{{ $data->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Country Code<span class="required">*</span></label>
                                                <input type="text" id="code" name="code" data-toggle="tooltip" title="Enter Country Code"
                                                class="form-control" placeholder="Enter Country Code" value="{{ $data->code }}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="exampleSelect1">Status<span class="required">*</span></label>
                                                <select class="form-control" id="status" name="status">
                                                <option {{($data->status == 1 ? 'selected' : '')}} value="1">Active</option>
                                                    <option {{($data->status == 0 ? 'selected' : '')}} value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="kt-portlet__foot">
                                            <div class="kt-form__actions">
                                                <a href="{{ url(VIEW_INFO['url']) }}"><button type="button" class="btn btn-success"
                                                    id="back">Back</button></a>
                                            </div>
                                        </div>
                        
    
                        <!--end::Form-->
                    </div>
    
                    <!--end::Portlet-->
            </div>
        </div>
    </div>
<!-- Main content -->

<!-- /.content -->
@stop

@section('metronic_js')
<script src="{{ asset('admin/assets/js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('admin/assets/js/pages/custom/currency.js') }}"></script>
<script>
CKEDITOR.replace( 'general_notes' );
</script>
@stop