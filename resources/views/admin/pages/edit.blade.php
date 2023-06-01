@extends('admin.layouts.default')

@section('title', 'Edit '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/pages') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="#" class="kt-subheader__breadcrumbs-link">Update {{ VIEW_INFO['title'] }} Details</a>

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
                                        Update {{ VIEW_INFO['title'] }}
                                </h3>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/edit/'.$data['page_id']) }}"
                        class="form-horizontal" method="post" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                        <input type="hidden" value="{{csrf_token()}}" id="csrfToken" class="csrfToken">
                        <input type="hidden" value="{{ $data['page_id'] }} " id="id" class="id">
                        
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
                                                    <option value="{{ $val->id }}" {{ $data['type_id'] == $val->id ? 'selected' : '' }} >{{ $val->name }}</option>
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
                                                    <option value="{{ $val->id }}" {{ $data['region_id'] == $val->id ? 'selected' : '' }} >{{ $val->name }}</option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>

                                <div class="form-group showdiv">
                                        <label for="exampleSelect1">Page Sub Category</label>
                                        <select name="parent_id" id="parent_id" class="form-control">
                                        <option value="0">No Parent</option>
                                        @if(isset($allCategory) && !empty($allCategory))
                                            @foreach($allCategory as $key=>$val)
                                                <option value="{{ $val['id'] }}" {{ (isset($data['parent_id']) && $data['parent_id'] == $val['id'] ? 'selected' : '') }}>{{ $val['name'] }}</option>
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
                                                <option value="{{ $val['id'] }}" {{ $data['page_type_id'] == $val['id'] ? 'selected' : '' }}>{{ $val['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                            <div class="form-group">
                                <label>Name<span class="required">*</span></label>
                                <input type="text" id="page_name" name="page_name" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" value="{{ $data['page_name'] }}" />
                            </div>
                            
                            <div class="form-group">
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

                            <div class="form-group">
                                <label>Content</label>
                                <textarea id="content" name="content" rows="10" cols="20" data-toggle="tooltip" title="Enter Category Description"
                                class="form-control" placeholder="Enter content">{{ $data['content'] }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Featured Image</label>
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="file">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <span class="form-text text-muted">Image should be .png and size should be less than 1 MB</span>
                                @if(isset($data->media_file) && !empty($data->media_file))
                                <div class="kt-widget__media">
                                    <input type="hidden" id="file_exist" name="file_exist" value="{{$data->media_file}}">
                                    @if(in_array(pathinfo($data->media_file, PATHINFO_EXTENSION),array('png','jpg','jpeg','bmp')) && isset($arrFile['resize']) && !empty($arrFile['resize']))
                                        <img src="{{url($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'.$data->media_file)}}" alt="image">
                                    @endif
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" id="title" name="title" data-toggle="tooltip" title="Enter Title"
                                    class="form-control" placeholder="Enter Name" value="{{$data['title'] }}" />
                            </div>
                            
                            <div class="form-group">
                                <label>Keywords</label>
                                <textarea id="keywords" name="keywords" rows="2" cols="5" data-toggle="tooltip" title="Enter keywords Description"
                                class="form-control" placeholder="Enter Keyword">{{  $data['keywords']  }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea id="page_description" name="page_description" rows="5" cols="5" data-toggle="tooltip" title="Enter Category Description"
                                class="form-control" placeholder="Enter Description">{{ $data['page_description']  }}</textarea>
                            </div>

                            <label>Select Tags</label>
                            <div class="facilities">
                                <div class="row">
                                @if(in_array("1",$data['tags']))
                                    <div class="col-2">
                                        <input type="checkbox" id="tags" name="tags[]" value="1" checked>
                                        <label for="tags">Global</label><br>
                                    </div>
                                @else
                                    <div class="col-2">
                                        <input type="checkbox" id="tags" name="tags[]" value="1">
                                        <label for="tags">Global</label><br>
                                    </div>
                                @endif
                                @if(in_array("2",$data['tags']))
                                    <div class="col-2">
                                        <input type="checkbox" id="tags" name="tags[]" value="2" checked>
                                        <label for="tags">Industry Updates</label><br>
                                    </div>
                                @else
                                    <div class="col-2">
                                        <input type="checkbox" id="tags" name="tags[]" value="2">
                                        <label for="tags">Industry Updates</label><br>
                                    </div>
                                @endif
                                @if(in_array("3",$data['tags']))
                                    <div class="col-2">
                                        <input type="checkbox" id="tags" name="tags[]" value="3" checked>
                                        <label for="tags">Hotels</label><br>
                                    </div>
                                @else
                                    <div class="col-2">
                                        <input type="checkbox" id="tags" name="tags[]" value="3">
                                        <label for="tags">Hotels</label><br>
                                    </div>
                                @endif
                                @if(in_array("4",$data['tags']))
                                    <div class="col-2">
                                        <input type="checkbox" id="tags" name="tags[]" value="4" checked>
                                        <label for="tags">Tourism</label><br>
                                    </div>  
                                @else
                                    <div class="col-2">
                                        <input type="checkbox" id="tags" name="tags[]" value="4">
                                        <label for="tags">Tourism</label><br>
                                    </div>  
                                @endif
                                @if(in_array("5",$data['tags']))
                                    <div class="col-2">
                                        <input type="checkbox" id="tags" name="tags[]" value="5" checked>
                                        <label for="tags">Recovery</label><br>
                                    </div>
                                @else
                                    <div class="col-2">
                                        <input type="checkbox" id="tags" name="tags[]" value="5">
                                        <label for="tags">Recovery</label><br>
                                    </div>
                                @endif
                                {{-- <div class="row">
                                    <div class="col-2">
                                        <input type="checkbox" id="tags" name="tags[]" value="7">
                                        <label for="tags">North America</label><br>
                                    </div>
                                    <div class="col-2">
                                        <input type="checkbox" id="tags" name="tags[]" value="8">
                                        <label for="tags">Historical Data</label><br>
                                    </div>
                                    <div class="col-2">
                                        <input type="checkbox" id="tags" name="tags[]" value="9">
                                        <label for="tags">Research</label><br>
                                    </div>
                                </div> --}}
                            </div>
                        
                            <div class="form-group">
                                <label for="exampleSelect1">Status</label>
                                <select class="form-control" id="status" name="status">
                                <option {{($data['status'] == 1 ? 'selected' : '')}} value="1">Active</option>
                                <option {{($data['status'] == 0 ? 'selected' : '')}} value="0">Inactive</option>
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
<script src="{{ asset('admin/assets/js/pages/custom/pagesSlug.js') }}"></script>
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