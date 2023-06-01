@extends('admin.layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	 <div class="page-breadcrumb">
		<div class="row">
			<div class="col-12 d-flex no-block align-items-center">
				<h4 class="page-title">View PageType</h4>
				<div class="ml-auto text-right">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
							<li class="breadcrumb-item"><a href="{{ url('admin/page-types') }}">PageTypes</a></li>
							<li class="breadcrumb-item active" aria-current="page">View PageType</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!-- ============================================================== -->
	<!-- End Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<!-- ============================================================== -->
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		@if(Session::has('flash_message_error'))
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" aria-label="Close" data-dismiss="alert">
					<span aria-hidden="true">&times;</span>
				</button>
				{!! session('flash_message_error') !!}
			</div>
		@endif	
		@if(Session::has('flash_message_success'))
			<div class="alert alert-success" role="alert">
				<button type="button" class="close" aria-label="Close" data-dismiss="alert">
					<span aria-hidden="true">&times;</span>
				</button>
				{!! session('flash_message_success') !!}
			</div>
		@endif
		{{ csrf_field() }}
		<input type="hidden" name="id" id="id" value="{{ $pageTypeDetails->id }}">
		<div class="card">
			<div class="card-body">
				<div class="form-group">
					<label>Name</label>
					<input type="text" id="name" name="name" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" required value="{{ $pageTypeDetails->name }}">
				</div>
				<div class="form-group">
					<label>Icon</label>
					<input type="text" id="icon" name="icon" data-toggle="tooltip" title="Enter Icon" class="form-control" placeholder="Enter Icon" value="{{ $pageTypeDetails->icon }}">
				</div>
				<div class="form-group">
					<label>Status</label>
					<select name="status" id="status" class="form-control">
						<option {{($pageTypeDetails->status == 1 ? 'selected' : '')}} value="1">Active</option>
						<option {{($pageTypeDetails->status == 0 ? 'selected' : '')}} value="0">Inactive</option>
					</select>
				</div>
			</div>
			<div class="border-top">
				<div class="card-body">
					<a href="{{ url('/admin/page-types') }}"><button type="button" class="btn btn-danger" id="back">Back</button></a>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End PAge Content -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- Right sidebar -->
		<!-- ============================================================== -->
		<!-- .right-sidebar -->
		<!-- ============================================================== -->
		<!-- End Right sidebar -->
		<!-- ============================================================== -->
	</div>
	<!-- ============================================================== -->
	<!-- End Container fluid  -->
	<!-- ============================================================== -->
	@include('admin.layouts.footer')
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
@endsection
@section('data')
<script>
</script>
@endsection