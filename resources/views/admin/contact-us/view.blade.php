@extends('admin.layouts.default')

@section('title', 'EDIT '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/contact-us') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
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
		<form id="frmAddEdit" name="frmAddEdit" action="{{ url('admin/contact-us/edit/'.$data->id) }}" class="" method="post">{{ csrf_field() }}
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
									<label>Name<span class="required"><code>*</code></span></label>
									<input type="text" id="name" name="name" maxlength="50" data-toggle="tooltip" title="Enter City" class="form-control" placeholder="Enter City" @if(isset($data->name)) value="{{ $data->name }}" @endif>
                                </div>
                                <div class="form-group">
									<label>Telephone<span class="required"><code>*</code></span></label>
									<input type="text" id="name" name="name" maxlength="50" data-toggle="tooltip" title="Enter City" class="form-control" placeholder="Enter City" @if(isset($data->tel)) value="{{ $data->tel }}" @endif>
                                </div>
                                <div class="form-group">
									<label>Email<span class="required"><code>*</code></span></label>
									<input type="text" id="name" name="name" maxlength="50" data-toggle="tooltip" title="Enter City" class="form-control" placeholder="Enter City" @if(isset($data->email)) value="{{ $data->email }}" @endif>
                                </div>
                                <div class="form-group">
									<label>Subject<span class="required"><code>*</code></span></label>
									<input type="text" id="name" name="name" maxlength="50" data-toggle="tooltip" title="Enter City" class="form-control" placeholder="Enter City" @if(isset($data->subject)) value="{{ $data->subject }}" @endif>
                                </div>
                                <div class="form-group">
                                    <label>Message<span class="required"><code>*</code></span></label>
                                    <textarea class="form-control">{{ $data->message }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelect1">Status<span class="required"><code>*</code></span></label>
                                    <select class="form-control" id="status" name="status">
										<option {{($data->status == 1 ? 'selected' : '')}} value="1">Active</option>
                                        <option {{($data->status == 0 ? 'selected' : '')}} value="0">Inactive</option>
                                    </select>
                                </div>
    
                                
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
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
<script src="{{ asset('admin/assets/js/pages/custom/contact-us.js') }}"></script>
@stop