@extends('admin.layouts.default')

@section('title', 'Edit '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
	<a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	<span class="kt-subheader__breadcrumbs-separator"></span>
	<a href="{{ url('admin/country') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
	<span class="kt-subheader__breadcrumbs-separator"></span>
	<a href="#" class="kt-subheader__breadcrumbs-link">Update {{ VIEW_INFO['title'] }} Details</a>

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
							Add {{ VIEW_INFO['title'] }}
						</h3>
					</div>
				</div>
				<!--begin::Form-->

				<form id="edit-states-form" name="edit-states-form" action="{{ url(VIEW_INFO['url'].'/edit/'.$data['id']) }}" class="" method="post">{{ csrf_field() }}

					<input type="hidden" name="id" id="id" value="{{ $data['id'] }}">
					<div class="card">
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
							@if(Session::has('message'))
                                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                        	@endif    
							<div class="card-body">
								<div class="form-group">
									<label>State Name <span class="text-danger">*</span></label>
									<input type="text" id="states_name" name="states_name" maxlength="50" data-toggle="tooltip" title="Enter State Name" class="form-control" placeholder="Enter State Name" value="{{ $data['states_name'] }}">
								</div>
								<div class="form-group">
									<label>State Code <span class="text-danger">*</span></label>
									<input type="text" id="state_code" name="state_code" maxlength="50" data-toggle="tooltip" title="Enter State Code" class="form-control" placeholder="Enter State Code" value="{{ $data['state_code'] }}">
								</div>
								<div class="form-group">
									<label>Status</label>
									<select name="status" id="status" class="form-control">
										<option {{($data['status'] == 'Active' ? 'selected' : '')}} value="1">Active</option>
										<option {{($data['status'] == 'Inactive' ? 'selected' : '')}} value="0">Inactive</option>
									</select>
								</div>
							</div>
							<div class="border-top">
								<div class="card-body">
									<button type="submit" class="btn btn-success">Update</button>
									<!-- <button type="button" id="reset" class="btn btn-primary">Reset</button> -->
									<a href="{{ url('/admin/state') }}"><button type="button" class="btn btn-danger" id="back">Back</button></a>
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

<!-- /.content -->
@stop

@section('metronic_js')
<script src="{{ asset('admin/assets/js/pages/custom/state.js') }}"></script>
@stop