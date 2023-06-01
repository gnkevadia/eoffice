@extends('admin.layouts.default')

@section('title', VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ucwords(str_replace("-"," ", VIEW_INFO['title']))}} Management </h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
	<a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	<span class="kt-subheader__breadcrumbs-separator"></span>
	<a href="{{ url('admin/email-template-types') }}" class="kt-subheader__breadcrumbs-link">{{ucwords(str_replace("-"," ", VIEW_INFO['title']))}}</a>
</div>
@stop


@section('content')
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<div class="alert alert-light alert-elevate" role="alert">
		<div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
		<div class="alert-text">
			The {{ucwords(str_replace("-"," ", VIEW_INFO['title']))}} is useful to define {{ucwords(str_replace("-"," ", VIEW_INFO['title']))}} available in the application which is managed by SA.
		</div>
	</div>
	<div class="kt-portlet kt-portlet--mobile">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-sm-3">
						<div class="kt-portlet__head kt-portlet__head--lg">
							<div class="kt-portlet__head-label">
								<span class="kt-portlet__head-icon">
									<i class="kt-font-brand flaticon2-line-chart"></i>
								</span>
								<h3 class="kt-portlet__head-title">
									State's Document
								</h3>
							</div>
						</div>
						<div class="container">
							<div class="form-group form-group-last">
								<div class="alert alert-secondary" role="alert">
									<div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
									<div class="alert-text">
										Before Upload/Import File please check the below format.
									</div>
								</div>
								<div class="text-center">
									<div class="row">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-sm-6">
													<div class="kt-portlet__head-toolbar">
														<div class="kt-portlet__head-wrapper">
															<div class="dropdown dropdown-inline">
																<button type="button" class="btn btn-success btn-icon-sm" aria-haspopup="true" aria-expanded="false">
																	<a href="/assets/review-file/State-Total-G-A-Sheet.xlsx" class="kt-nav__link" style="color:#ffffff" download><i class="icon-2x text-dark-50 flaticon-download"></i> Download States</a>
																</button>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="kt-portlet__head-toolbar">
														<div class="kt-portlet__head-wrapper">
															<div class="dropdown dropdown-inline">
																<button type="button" class="btn btn-brand btn-icon-sm" aria-haspopup="true" aria-expanded="false">
																	<a href="#" class="kt-nav__link" style="color:#ffffff" data-toggle="modal" data-target="#form"><i class="icon-2x text-dark-50 flaticon-upload"></i> Import States</a>
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="kt-portlet__head kt-portlet__head--lg">
							<div class="kt-portlet__head-label">
								<span class="kt-portlet__head-icon">
									<i class="kt-font-brand flaticon2-line-chart"></i>
								</span>
								<h3 class="kt-portlet__head-title">
									Brand Document
								</h3>
							</div>
						</div>
						<div class="container">
							<div class="form-group form-group-last">
								<div class="alert alert-secondary" role="alert">
									<div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
									<div class="alert-text">
										Before Upload/Import File please check the below format.
									</div>
								</div>
								<div class="text-center">
									<div class="row">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-sm-6">
													<div class="kt-portlet__head-toolbar">
														<div class="kt-portlet__head-wrapper">
															<div class="dropdown dropdown-inline">
																<button type="button" class="btn btn-success btn-icon-sm" aria-haspopup="true" aria-expanded="false">
																	<a href="/assets/review-file/Code-Gas-Stataion.xlsx" class="kt-nav__link" style="color:#ffffff" download><i class="icon-2x text-dark-50 flaticon-download"></i> Download Brand</a>
																</button>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="kt-portlet__head-toolbar">
														<div class="kt-portlet__head-wrapper">
															<div class="dropdown dropdown-inline">
																<button type="button" class="btn btn-brand btn-icon-sm" aria-haspopup="true" aria-expanded="false">
																	<a href="#" class="kt-nav__link" style="color:#ffffff" data-toggle="modal" data-target="#form"><i class="icon-2x text-dark-50 flaticon-upload"></i> Import Brand</a>
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="kt-portlet__head kt-portlet__head--lg">
							<div class="kt-portlet__head-label">
								<span class="kt-portlet__head-icon">
									<i class="kt-font-brand flaticon2-line-chart"></i>
								</span>
								<h3 class="kt-portlet__head-title">
									Allen Terminal Document
								</h3>
							</div>
						</div>
						<div class="container">
							<div class="form-group form-group-last">
								<div class="alert alert-secondary" role="alert">
									<div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
									<div class="alert-text">
										Before Upload/Import File please check the below format.
									</div>
								</div>
								<div class="text-center">
									<div class="row">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-sm-6">
													<div class="kt-portlet__head-toolbar">
														<div class="kt-portlet__head-wrapper">
															<div class="dropdown dropdown-inline">
																<button type="button" class="btn btn-success btn-icon-sm" aria-haspopup="true" aria-expanded="false">
																	<a href="/assets/review-file/Allen-Terminal-Master-75013.xlsx" class="kt-nav__link" style="color:#ffffff" download><i class="icon-2x text-dark-50 flaticon-download"></i> Download Allen</a>
																</button>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="kt-portlet__head-toolbar">
														<div class="kt-portlet__head-wrapper">
															<div class="dropdown dropdown-inline">
																<button type="button" class="btn btn-brand btn-icon-sm" aria-haspopup="true" aria-expanded="false">
																	<a href="#" class="kt-nav__link" style="color:#ffffff" data-toggle="modal" data-target="#form"><i class="icon-2x text-dark-50 flaticon-upload"></i> Import Allen</a>
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="kt-portlet__head kt-portlet__head--lg">
							<div class="kt-portlet__head-label">
								<span class="kt-portlet__head-icon">
									<i class="kt-font-brand flaticon2-line-chart"></i>
								</span>
								<h3 class="kt-portlet__head-title">
									Trand Document
								</h3>
							</div>
						</div>
						<div class="container">
							<div class="form-group form-group-last">
								<div class="alert alert-secondary" role="alert">
									<div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
									<div class="alert-text">
										Before Upload/Import File please check the below format.
									</div>
								</div>
								<div class="text-center">
									<div class="row">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-sm-6">
													<div class="kt-portlet__head-toolbar">
														<div class="kt-portlet__head-wrapper">
															<div class="dropdown dropdown-inline">
																<button type="button" class="btn btn-success btn-icon-sm" aria-haspopup="true" aria-expanded="false">
																	<a href="/assets/review-file/Texas-Amount-Fuel-Trand-Sheet.xlsx" class="kt-nav__link" style="color:#ffffff" download><i class="icon-2x text-dark-50 flaticon-download"></i> Download Trand</a>
																</button>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="kt-portlet__head-toolbar">
														<div class="kt-portlet__head-wrapper">
															<div class="dropdown dropdown-inline">
																<button type="button" class="btn btn-brand btn-icon-sm" aria-haspopup="true" aria-expanded="false">
																	<a href="#" class="kt-nav__link" style="color:#ffffff" data-toggle="modal" data-target="#form"><i class="icon-2x text-dark-50 flaticon-upload"></i> Import Trand</a>
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="kt-portlet__body"></div>
		<div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header border-bottom-0">
						<h5 class="modal-title" id="exampleModalLabel">Import File</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form name="frmAddEdit" id="frmAddEdit" method="post" class="wow fadeInUp needs-validation" action="inventory/import" enctype="multipart/form-data">{{ csrf_field() }}
						<div class="modal-body">
							<div class="form-group form-group-last">
								<div class="alert alert-secondary" role="alert">
									<div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
									<div class="alert-text">
										<code>*</code> indicates a required field.
									</div>
								</div>
							</div>
							<div class="form-group has-validation">
								<label>Choose File<span class="required"><code>*</code></span></label>
								<div></div>
								<div class="custom-file">
									<input type="file" class="custom-file-input shadow-2" id="customFile" name="file" required>
									<label class="custom-file-label" for="customFile">Choose file</label>
								</div>
								<div class="invalid-feedback">
									Please Select File.
								</div>
							</div>
							<div class="kt-form__actions">
								<button type="submit" class="btn btn-primary shadow-2">Submit</button>
								<a href="{{ url(VIEW_INFO['url']) }}"><button type="button" class="btn btn-success" id="back">Cancel</button></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.content -->
@stop
@section('footerScript')
@parent
<script type="text/javascript">
	(function() {
		'use strict'
		var forms = document.querySelectorAll('.needs-validation')
		Array.prototype.slice.call(forms)
			.forEach(function(form) {
				form.addEventListener('submit', function(event) {
					if (!form.checkValidity()) {
						event.preventDefault()
						event.stopPropagation()
					}

					form.classList.add('was-validated')
				}, false)
			})
	})()
</script>
@stop