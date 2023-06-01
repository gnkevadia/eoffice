@extends('admin.layouts.default')

@section('title', 'Add ' . VIEW_INFO['title'])

@section('content_header')
    <h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
    <span class="kt-subheader__separator kt-hidden"></span>
    <div class="kt-subheader__breadcrumbs">
        <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="{{ url('admin/package') }}" class="kt-subheader__breadcrumbs-link">{{ VIEW_INFO['title'] }}</a>
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
                    <form id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'] . '/add') }}"
                        class="form-horizontal" enctype="multipart/form-data" method="post">{{ csrf_field() }}
                        <div class="kt-portlet__body">
                            <div class="form-group form-group-last">
                                <div class="alert alert-secondary" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                                    <div class="alert-text">
                                        indicates a required field.
                                    </div>
                                </div>
                            </div>
                            @include('admin.includes.errormessage')
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Package<span class="required"><code>*</code></span></label>
                                    <input type="text" id="name" name="name" data-toggle="tooltip"
                                        title="Enter Package" class="form-control" placeholder="Enter Package"
                                        value="{{ old('name') }}" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Category<span class="required"><code>*</code></span></label>
                                    <select name="category" id="category" class="form-control name" required>
                                        <option value="">-Select Category-</option>
                                        @if (isset($arrCategory) && !empty($arrCategory))
                                            @foreach ($arrCategory as $key => $val)
                                                tierSelect += "<option value='{{ $val->id }}'>{{ $val->name }}
                                                </option>";
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Heading</label>
                                    <input type="text" id="heading" name="heading" data-toggle="tooltip"
                                        title="Enter Heading" class="form-control" placeholder="Enter Heading"
                                        value="{{ old('heading') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Inquire?</label>
                                    <select name="inquire" id="inquire" class="form-control name">
                                        <option value="">-Select Inquire-</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="exampleTextarea">Short Description<span class="required"></span></label>
                                    <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Description</label>
                                    <textarea id="detail_description" name="detail_description" rows="10" cols="20" data-toggle="tooltip"
                                        title="Enter Detail Description" class="form-control" placeholder="Enter Detail Description">{{ old('detail_description') }}</textarea>
                                </div>
                            </div>
                            <!-- <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Features</label>
                                            <textarea id="inclusion" name="inclusion" rows="10" cols="20" data-toggle="tooltip" title="Enter Inclusion"
                                                class="form-control" placeholder="Enter Inclusion"></textarea>
                                        </div>
                                    </div> -->
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Image</label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="file">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                    <span class="form-text text-muted">Image/Video should be .png/.mp4 and size should be
                                        less than 2 MB</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Banner Mobile Image<span class="required"></span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile"
                                            name="banner_mobile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                    <span class="form-text text-muted">Image should be .png and size should be less than 1
                                        MB</span>
                                </div>  
                                <div class="form-group col-md-6">
                                    <label>Banner Image<span class="required"></span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="banner">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                    <span class="form-text text-muted">Image should be .png and size should be less than 1
                                        MB</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Add Report Prices</label>
                                <div class="dynamicElements clearfix" id="dynamicElements">
                                    <div class='element row' id='div_1'>
                                        <div class='form-group'></div>
                                    </div>
                                </div>
                                <button type="button" id="addMore" class="btn btn-primary clear"><i title="Add Tier"
                                        class="fa fa-plus"></i> Add Prices</button>
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
    <script src="{{ asset('admin/assets/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('inclusion');
        CKEDITOR.replace('detail_description');
    </script>
    <script src="{{ asset('admin/assets/js/pages/custom/package.js') }}"></script>
    <script>
        // Add new element
        $("#addMore").click(function() {
            var arrows;
            if (KTUtil.isRTL()) {
                arrows = {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                }
            } else {
                arrows = {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            }
            // Finding total number of elements added
            var total_element = $(".element").length;

            // last <div> with element class id
            var lastid = $(".element:last").attr("id");
            var split_id = lastid.split("_");
            var nextindex = Number(split_id[1]) + 1;

            var max = 11;
            // Check total number elements
            if(total_element < max ){
			// Adding new div container after last occurance of element class
			$(".element:last").after("<div class='element cityrow' id='div_"+ nextindex +"'></div>");
			// Adding element to <div>
			var htmlSelect = "<select name='attribute_ids[]' id='attribute_ids_"+ nextindex +"' class='form-control select2-autocomplete-attribute' style='width: 100%'></select>";
            var newSelect = $(htmlSelect);
            $("#div_" + nextindex).append("<div class='row'><div class='form-group col-md-0'><button type='button' id='remove_" + nextindex + "' class='remove btn btn-danger float-right'><i title='Add Tier' class='fa fa-trash'></i> Remove</button></div></div><div class='row'><div class='col-md-4'><strong>Report Title</strong></div><div class='col-md-2'></div></div><div class='row'><div class='form-group col-md-2'><input type='text' class='form-control' name='report_title["+ nextindex +"]' id='normal_morning_actual_price_"+ nextindex +"' placeholder='Report Title'><span class='form-text text-muted'>(6 Month, 1 Year) Price</span></div><div class='form-group col-md-2'><input type='text' class='form-control' name='report_prices["+ nextindex +"]' id='normal_morning_discount_price_"+ nextindex +"' placeholder='Discount Price'><span class='form-text text-muted'>Discount Price</span></div></div>");
		}
        });
        // Add new element
        $("#addMore1").click(function() {
            var arrows;
            if (KTUtil.isRTL()) {
                arrows = {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                }
            } else {
                arrows = {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            }
            // Finding total number of elements added
            var total_element = $(".element1").length;

            // last <div> with element class id
            var lastid = $(".element1:last").attr("id");
            var split_id = lastid.split("_");
            var nextindex = Number(split_id[1]) + 1;

            var max = 11;
            // Check total number elements
            if(total_element < max ){
			// Adding new div container after last occurance of element class
			$(".element1:last").after("<div class='element1 cityrow' id='div_"+ nextindex +"'></div>");
			// Adding element to <div>
			$("#div_" + nextindex).append("<div class='row'><div class='form-group col-md-6'><label>Add-on Name<span class='required'></span></label><input type='text' id='addon_name_"+nextindex+"' name='addon_name["+ nextindex +"]' data-toggle='tooltip' title='Enter Add-on Name' class='form-control' placeholder='Enter Add-on Name' value=''></div><div class='form-group col-md-6'><label>Add-on Price<span class='required'></span></label><input type='text' id='addon_price_"+nextindex+"' name='addon_price["+ nextindex +"]' data-toggle='tooltip' title='Enter Add-on Price' class='form-control' placeholder='Enter Add-on Price' value=''></div></div><div class='row'><div class='form-group col-md-6'><label>Add-on Description</label><textarea id='addon_description_"+ nextindex +"' name='addon_description["+ nextindex +"]' rows='10' cols='20' data-toggle='tooltip' title='Enter Add-on Description'class='form-control' placeholder='Enter Add-on Description'></textarea></div><div class='form-group col-md-6'><label>Image<span class='required'></span></label><div></div><div class='custom-file'><input type='file' class='custom-file-input' id='customFile' name='addonfile["+ nextindex +"][]' multiple><label class='custom-file-label' for='customFile'>Choose file</label></div><span class='form-text text-muted'>Image should be .png and size should be less than 10 MB</span></div></div>");
            
            $('.kt-selectpicker').selectpicker('refresh');
		}
        });
    </script>
@stop
