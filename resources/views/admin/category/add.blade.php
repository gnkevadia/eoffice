@extends('admin.layouts.default')

@section('title', 'Add '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/module') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
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
                                <label>Name<span class="required"><code>*</code></span></label>
                                <input type="text" id="name" name="name" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" value="{{ old('name') }}" />
                            </div>
                            <div class="form-group">
                                <label for="exampleSelect1">Parent<span class="required"><code>*</code></span></label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                <option value="0">No Parent</option>
                                @if(isset($allcategory) && !empty($allcategory))
                                    @foreach($allcategory as $key=>$val)
                                        <option value="{{ $val['id'] }}" {{ old('parent_id') == $val['id'] ? 'selected' : '' }}>{{ $val['name'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                            </div>
                            <div class="form-group">
                                    <label>Ordering</label>
                                    <input type="text" id="ordering" name="ordering" data-toggle="tooltip" title="Enter Ordering"
                                    class="form-control" placeholder="Enter Ordering" value="{{ old('ordering') }}" />
                                </div>
                            <div class="form-group">
                                <label>URL</label>
                                <textarea id="description" name="description" rows="2" cols="5" data-toggle="tooltip" title="Enter Category Description"
                                class="form-control" placeholder="Enter Category Description">{{ old('description') }}</textarea>
                            </div>
                        
                            <div class="form-group">
                                <label for="exampleSelect1">Status<span class="required"><code>*</code></span></label>
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
<script src="{{ asset('admin/assets/js/pages/custom/category.js') }}"></script>
@stop