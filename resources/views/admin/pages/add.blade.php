@extends('admin.layouts.default')
@section('title', 'Add '.VIEW_INFO['title'])
@section('content_header')
    <h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
    <span class="kt-subheader__separator kt-hidden"></span>
    <div class="kt-subheader__breadcrumbs">
        <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="{{ url('admin/pages') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
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
                    <form id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/add') }}" class="kt-form" method="post" enctype="multipart/form-data" >
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
                                        <label for="exampleSelect1">Page Category<span class="required">*</span></label>
                                        <select name="type_id" id="type_id" class="form-control">
                                        <option value="">-Select Category-</option>
                                                @if(isset($allType) && !empty($allType))
                                                    @foreach($allType as $key=>$val)
                                                        <option value="{{ $val->id }}" {{ old('module_id') == $val->id ? 'selected' : '' }} >{{ $val->name }}</option>
                                                    @endforeach
                                                @endif
                                        </select>
                                    </div>

                                    <div class="form-group showdiv">
                                        <label for="exampleSelect1">Region<span class="required">*</span></label>
                                        <select name="region_id" id="region_id" class="form-control">
                                        <option value="">-Select Region-</option>
                                                @if(isset($allRegionType) && !empty($allRegionType))
                                                    @foreach($allRegionType as $key=>$val)
                                                        <option value="{{ $val->id }}" {{ old('module_id') == $val->id ? 'selected' : '' }} >{{ $val->name }}</option>
                                                    @endforeach
                                                @endif
                                        </select>
                                    </div>

                                    <div class="form-group showdiv">
                                        <label for="exampleSelect1">Page Sub Category<span class="required">*</span></label>
                                        <select name="parent_id" id="parent_id" class="form-control">
                                            <option value="0">No Parent</option>
                                            @if(isset($allCategory) && !empty($allCategory))
                                                @foreach($allCategory as $key=>$val)
                                                    <option value="{{ $val['id'] }}" {{ old('parent_id') == $val['id'] ? 'selected' : '' }}>{{ $val['name'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleSelect1">Page Type</label>
                                        <select name="page_type_id" id="page_type_id" class="form-control">
                                            <option value="0">-Select-</option>
                                            @if(isset($allPageType) && !empty($allPageType))
                                                @foreach($allPageType as $key=>$val)
                                                    <option value="{{ $val['id'] }}" {{ old('page_type_id') == $val['id'] ? 'selected' : '' }}>{{ $val['name'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Name<span class="required">*</span></label>
                                        <input type="text" id="page_name" name="page_name" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" value="{{ old('page_name') }}" />
                                    </div>

                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea id="content" name="content" rows="6" cols="5" data-toggle="tooltip" title="Enter Category Description"
                                        class="form-control" placeholder="Enter content">{{ old('content') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Featured Image</label>
                                        <div></div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="file">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                        <span class="form-text text-muted">Image/Video should be .png/.mp4 and size should be less than 2 MB</span>
                                    </div>
                                    <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" id="title" name="title" data-toggle="tooltip" title="Enter Title"
                                            class="form-control" placeholder="Enter Name" value="{{ old('Title') }} " />                            
                                    </div>
                                
                                    <div class="form-group">
                                        <label>Keywords</label>
                                        <textarea id="keywords" name="keywords" rows="2" cols="5" data-toggle="tooltip" title="Enter keywords Description"
                                        class="form-control" placeholder="Enter Keyword">{{ old('keywords') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea id="page_description" name="page_description" rows="2" cols="5" data-toggle="tooltip" title="Enter Category Description" class="form-control" placeholder="Enter Description">{{ old('page_description') }}</textarea>
                                    </div>
                                <label>Select Tags</label>
                                <div class="facilities">
                                    <div class="row">
                                        <div class="col-2">
                                            <input type="checkbox" id="tags" name="tags[]" value="1">
                                            <label for="tags">Global</label><br>
                                        </div>
                                        <div class="col-2">
                                            <input type="checkbox" id="tags" name="tags[]" value="2">
                                            <label for="tags">Industry Updates</label><br>
                                        </div>
                                        <div class="col-2">
                                            <input type="checkbox" id="tags" name="tags[]" value="3">
                                            <label for="tags">Hotels</label><br>
                                        </div>
                                        <div class="col-2">
                                            <input type="checkbox" id="tags" name="tags[]" value="4">
                                            <label for="tags">Tourism</label><br>
                                        </div>
                                        <div class="col-2">
                                            <input type="checkbox" id="tags" name="tags[]" value="5">
                                            <label for="tags">Recovery</label><br>
                                        </div>
                                        <div class="col-2">
                                            <input type="checkbox" id="tags" name="tags[]" value="6">
                                            <label for="tags">Benchmarking</label><br>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelect1">Status</label>
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
<script src="{{ asset('admin/assets/js/ckeditor/ckeditor.js') }}"></script>
<script>
   CKEDITOR.replace( 'content' );
   CKEDITOR.replace( 'page_description' );
</script>
<script src="{{ asset('admin/assets/js/pages/custom/pages.js') }}"></script>
<script>
$(document).ready(function(){
    $('#type_id').on('change', function(){
    	var selectCategory = $(this).val();
        
        if(selectCategory == 3){
            $("div.showdiv").hide();
        }else{
            $("div.showdiv").show();
        }
    });
});
</script> 
@stop