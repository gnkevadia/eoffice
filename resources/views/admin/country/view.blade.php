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
                        <!--begin::Form-->
                        
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
                                                <label>Name<span class="required">*</span></label>
                                                <input type="text" id="nicename" name="nicename" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" value="{{ $data->nicename }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Country Code<span class="required">*</span></label>
                                                <input type="text" id="iso" name="iso" data-toggle="tooltip" title="Enter Country Code"
                                                class="form-control" placeholder="Enter Country Code" value="{{ $data->iso }}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Phone Code</label><span class="required">*</span></label>
                                                <input type="text" id="phonecode" name="phonecode" data-toggle="tooltip" title="Enter Phone Code" class="form-control" placeholder="Enter Phone Code" value="{{ $data->phonecode }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Flag Image<span class="required"><code>*</code></span></label>
                                                <div></div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="flag">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                                <span class="form-text text-muted">Image should be .png and size should be less than 1 MB</span>
                                                @if(isset($data->flag_img) && !empty($data->flag_img))
                                                <div class="kt-widget__media">
                                                    <input type="hidden" id="flag_exist" name="flag_exist" value="{{$data->flag_img}}">
                                                    @if(in_array(pathinfo($data->flag_img, PATHINFO_EXTENSION),array('png','jpg','jpeg','bmp')))
                                                        <img src="{{url($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'.$data->flag_img)}}" alt="image">
                                                    @elseif(in_array(pathinfo($data->flag_img, PATHINFO_EXTENSION),array('mp4')))
                                                        <img src="{{url($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'.str_replace(pathinfo($data->flag_img, PATHINFO_EXTENSION),'png',$data->media_file))}}" alt="image">
                                                    @else
                                                        <a href="{{url($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'.$data->flag_img)}}">{{$data->flag_img}}</a>
                                                    @endif
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label>General Notes</label>
                                                <textarea id="general_notes" name="general_notes" rows="10" cols="20" data-toggle="tooltip" title="Enter General Notes"
                                                class="form-control" placeholder="Enter General Notes">{{$data->general_notes }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="exampleSelect1">Status<span class="required">*</span></label>
                                                <select class="form-control" id="status" name="status">
                                                <option {{($data->status == 1 ? 'selected' : '')}} value="1">Active</option>
                                                    <option {{($data->status == 0 ? 'selected' : '')}} value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="kt-portlet__foot">
                                            <div class="kt-form__actions">
                                                <a href="{{ url(VIEW_INFO['url']) }}"><button type="button" class="btn btn-success"
                                                    id="back">Back</button></a>
                                            </div>
                                        </div>
                        
    
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
<script src="{{ asset('admin/assets/js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('admin/assets/js/pages/custom/country.js') }}"></script>
<script>
CKEDITOR.replace( 'general_notes' );
</script>
@stop