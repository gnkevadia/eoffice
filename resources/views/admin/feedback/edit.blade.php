@extends('admin.layouts.default')  
  
@section('title', 'Edit '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ucwords(str_replace("-"," ", VIEW_INFO['title']))}} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/email-template-types') }}" class="kt-subheader__breadcrumbs-link">{{ucwords(str_replace("-"," ", VIEW_INFO['title']))}}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="#" class="kt-subheader__breadcrumbs-link">Edit {{ucwords(str_replace("-"," ", VIEW_INFO['title']))}} Details</a>

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
                                        Edit {{ucwords(str_replace("-"," ", VIEW_INFO['title']))}}
                                </h3>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/edit/'.$data->id) }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
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
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Star<span class="required"><code>*</code></span></label>
                                                <input type="number" id="star" name="star" data-toggle="tooltip" title="Enter Star" class="form-control" placeholder="Enter Sode" value="{{ $data->star }}" min="1" max="5" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Title<span class="required"><code>*</code></span></label>
                                                <input type="text" id="title" name="title" data-toggle="tooltip" title="Enter Title" class="form-control" placeholder="Enter Title" value="{{ $data->title }}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Description<span class="required"><code>*</code></span></label>
                                                <textarea id="description" name="description" class="form-control" rows="3">{{ $data->description }}</textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Photo<span class="required"><code>*</code></span></label>
                                                <div></div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="file">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                                <span class="form-text text-muted">Image should be .png and size should be less than 1 MB</span>
                                                @if(isset($data->media_file) && !empty($data->media_file))
                                                <div class="kt-widget__media">
                                                    <input type="hidden" id="file_exist" name="file_exist" value="{{$data->media_file}}">
                                                    @if(in_array(pathinfo($data->media_file, PATHINFO_EXTENSION),array('png','jpg','jpeg','bmp')))
                                                        <img src="{{url($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'.$data->media_file)}}" alt="image">
                                                    @elseif(in_array(pathinfo($data->media_file, PATHINFO_EXTENSION),array('mp4')))
                                                        <img src="{{url($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'.str_replace(pathinfo($data->media_file, PATHINFO_EXTENSION),'png',$data->media_file))}}" alt="image">
                                                    @else
                                                        <a href="{{url($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'.$data->media_file)}}">{{$data->media_file}}</a>
                                                    @endif
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Name<span class="required"><code>*</code></span></label>
                                                <input type="text" id="name" name="name" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Store Name" value="{{ $data->name }}" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Company<span class="required"><code>*</code></span></label>
                                                <input type="text" id="company" name="company" data-toggle="tooltip" title="Enter Company Name" class="form-control" placeholder="Enter Company Name" value="{{ $data->company }}" />
                                            </div>
                                        </div>
                                        <div class="row">
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
<script src="{{ asset('admin/assets/js/pages/custom/feedback-selection.js')}}" type="text/javascript"></script>
<script>
CKEDITOR.replace( 'general_notes' );
</script>
@stop