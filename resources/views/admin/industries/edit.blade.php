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
                            <input type="hidden" value="{{csrf_token()}}" id="csrfToken" class="csrfToken">
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
                                                <label>Title<span class="required"><code>*</code></span></label>
                                                <input type="text" id="title" name="title" data-toggle="tooltip" title="Enter Title" class="form-control" placeholder="Enter Title" value="{{ $data->title }}" />
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
                                                <label>Description<span class="required"><code>*</code></span></label>
                                                <textarea id="content" name="content" class="form-control" rows="3">{{ $data->content }}</textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Slug</label>&nbsp;&nbsp;<i title="Edit" class="fa fa-edit editslug"></i>
                                                <div class="row">
                                                    <div class="col-10">
                                                        <input type="text" id="alias" name="alias" data-toggle="tooltip" class="form-control valid" value="{{ $data['alias'] }}" data-original-title="" title="" aria-invalid="false" readonly="readonly">
                                                    </div>
                                                    <div class="col-2 toggleslug" >
                                                        <input type="button" name="btnEdit" id="btnEdit" class="btn btn-success" value="Save">
                                                        <input type="button" name="btnCancel" id="btnCancel" class="btn btn-danger" value="Cancel">
                                                        <input type="hidden" name="updateslug" id="updateslug" class="updateslug" value="0">
                                                    </div>
                                                </div>	
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
<script src="{{ asset('admin/assets/js/pages/custom/industries-selection.js')}}" type="text/javascript"></script>
<script src="{{ asset('admin/assets/js/pages/custom/industriesSlug.js') }}"></script>
<script>
CKEDITOR.replace( 'general_notes' );
</script>
@stop