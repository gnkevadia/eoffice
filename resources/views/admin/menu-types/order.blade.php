@extends('admin.layouts.default')

@section('title', 'Add '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/menu-types') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
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
                                    Order {{ VIEW_INFO['title'] }}
                            </h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/order/'.$menuTypeDetails->id) }}" class="kt-form" method="post">
                        {{ csrf_field() }}
                        <div class="kt-portlet__body">
												<input type="hidden" name="id" id="id" value="{{ $menuTypeDetails->id }}">
			<input type="hidden" name="reorder" id="reorder" value="" />
                                <div class="form-group form-group-last">
                                        <div class="alert alert-secondary" role="alert">
                                            <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                                            <div class="alert-text">
                                                    <code>*</code> indicates a required field.
                                            </div>
                                        </div>
                                    </div>
                                    @include('admin.includes.errormessage')
																		<div class="card-body">
																			<h6 class="card-subtitle">Sort Menu {{$menuTypeDetails->name}}</h6>
																			<div id="list2" class="dd myadmin-dd-empty">
																				{!! $nLevelMenus !!}
																			</div>
																		</div>

																		<div class="border-top">
																		<div class="card-body">
																			<button type="submit" class="btn btn-success">Save</button>
																			<a href="{{ url('/admin/menu-types') }}"><button type="button" class="btn btn-danger" id="back">Back</button></a>
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
<script src="{{ asset('admin/assets/js/jquery.nestable.js') }}"></script>
<script src="{{ asset('admin/assets/js/pages/custom/menu-types.js') }}"></script>
@stop