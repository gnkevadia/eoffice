@extends('admin.layouts.default')

@section('title', 'Edit '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/package') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="#" class="kt-subheader__breadcrumbs-link">View {{ VIEW_INFO['title'] }} Details</a>

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
                                        View {{ VIEW_INFO['title'] }}
                                </h3>
                            </div>
                        </div>
                        <!--begin::Form-->
                            <input type="hidden" name="id" id="id" value="{{ $data->id }}">
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
                                                <input type="text" id="name" name="name" data-toggle="tooltip" title="Enter Package" class="form-control" placeholder="Enter Question" value="{{ $data->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Category<span class="required"><code>*</code></span></label>
                                                <input type="text" id="name" name="name" data-toggle="tooltip" title="Enter Package"
                                                    class="form-control" placeholder="Enter Package" value="{{ old('name') }}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label>Description</label>
                                                <textarea id="detail_description" name="detail_description" rows="10" cols="20" data-toggle="tooltip" title="Enter Detail Description"
                                                class="form-control" placeholder="Enter Detail Description">{{ $data['detail_description'] }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label>Features</label>
                                                <textarea id="inclusion" name="inclusion" rows="10" cols="20" data-toggle="tooltip" title="Enter Inclusion"
                                                class="form-control" placeholder="Enter Inclusion">{{ $data['inclusion'] }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label>Image/Video<span class="required"></span></label>
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
                                                    @elseif(in_array(pathinfo($data->media_file, PATHINFO_EXTENSION),array('png','jpg','jpeg','bmp')))
                                                        <img src="{{url($arrFile['path'].'/'.$data->media_file)}}" alt="image" width="100">
                                                    @elseif(in_array(pathinfo($data->media_file, PATHINFO_EXTENSION),array('mp4')) && isset($arrFile['resize']) && !empty($arrFile['resize']))
                                                        <img src="{{url($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'.str_replace(pathinfo($data->media_file, PATHINFO_EXTENSION),'png',$data->media_file))}}" alt="image">
                                                    @elseif(in_array(pathinfo($data->media_file, PATHINFO_EXTENSION),array('mp4')))
                                                        <img src="{{url($arrFile['path'].'/'.str_replace(pathinfo($data->media_file, PATHINFO_EXTENSION),'png',$data->media_file))}}" alt="image" width="100">
                                                    @else
                                                        <a href="{{url($arrFile['path'].$arrFile['resize'].'x'.$arrFile['resize'].'/'.$data->media_file)}}">{{$data->media_file}}</a>
                                                    @endif
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Performance Time<span class="required"></span></label>
                                                <input type="text" id="activity_time" name="activity_time" data-toggle="tooltip" title="Enter Activity Time"
                                                    class="form-control" placeholder="Enter Activity Time" value="{{ $data->activity_time }}" />
                                                <span class="form-text text-muted">Time should be in Minutes</span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>No. of Attendees Included<span class="required"></span></label>
                                                <input type="text" id="no_of_attendees" name="no_of_attendees" data-toggle="tooltip" title="No. of Attendees Included"
                                                    class="form-control" placeholder="Enter No. of Attendees Included" value="{{ $data->no_of_attendees }}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Minimum Number of Attendees<span class="required"></span></label>
                                                <input type="text" id="min_no_of_attendees" name="min_no_of_attendees" data-toggle="tooltip" title="Minimum Number of Attendees"
                                                    class="form-control" placeholder="Enter Minimum Number of Attendees" value="{{ $data->min_no_of_attendees }}" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Maximum Number of Attendees<span class="required"></span></label>
                                                <input type="text" id="max_no_of_attendees" name="max_no_of_attendees" data-toggle="tooltip" title="Maximum Number of Attendees"
                                                    class="form-control" placeholder="Enter Maximum Number of Attendees" value="{{ $data->max_no_of_attendees }}" />
                                            </div>
                                        </div>
                                
                                <div class="form-group">
                                    <label for="exampleSelect1">Status<span class="required">*</span></label>
                                    <select class="form-control" id="status" name="status">
                                        <option {{($data->status == 1 ? 'selected' : '')}} value="1">Active</option>
                                        <option {{($data->status == 0 ? 'selected' : '')}} value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label >Add Multiple Tier</label>
                                    <div class="dynamicElements clearfix" id="dynamicElements">
                                        <div class='element row' id='div_1'><div class='form-group'></div></div>
                                        @if(isset($dynamicTierDetails) && !empty($dynamicTierDetails))
                                            @foreach($dynamicTierDetails as $keyCity => $valCity)
                                                @php
                                                    $dynamicDateDetails = $objModel->getTierDaysPackage($valCity->package_id,$valCity->tier_id);
                                                @endphp
                                                <div class='element cityrow' id='div_{{$keyCity+2}}'>
                                                    <div class='row'>
                                                        <div class='form-group col-md-2'>
                                                            <select name='tier_id[{{$keyCity+2}}]' id='tier_id{{$keyCity+2}}' data-id='{{$keyCity+2}}' class='form-control cityselection' >
                                                                <option value=''>-Select City-</option>
                                                                @if(isset($arrTier) && !empty($arrTier))
                                                                    @foreach($arrTier as $key=>$val)
                                                                        tierSelect += "<option value='{{$val->id}}' {{ $val->id == $valCity->tier_id ? 'selected' : '' }}>{{$val->name}}</option>";
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="form-text text-muted">Tier</span>
                                                        </div>
                                                        
                                                        <div class='form-group col-md-2'>
                                                            <!-- <button type='button' id='remove_{{$keyCity+2}}' class='remove btn btn-danger float-right'><i title='Remove City' class='fa fa-trash'></i> Remove City</button>-->
                                                        </div>
                                                    </div>
                                                    <div class="row"><div class="col-md-2"></div><div class="col-md-4"><strong>Normal Days</strong></div><div class="col-md-4"><strong>Prime Days</strong></div><div class="col-md-2"></div></div>
                                                    @if(isset($dynamicDateDetails) && !empty($dynamicDateDetails))
                                                            @foreach($dynamicDateDetails as $keyDate => $valDate)
                                                                <div class='row'>
                                                                    <div class='form-group col-md-2'>
                                                                        <label>Morning</label>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='normal_morning_actual_price[{{$keyCity+2}}]' id='normal_morning_actual_price_{{$keyCity+2}}' placeholder='Actual Price' value="{{$valDate->normal_morning_actual_price}}">
                                                                        <span class="form-text text-muted">Actual Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='normal_morning_discount_price[{{$keyCity+2}}]' id='normal_morning_discount_price_{{$keyCity+2}}' placeholder='Discount Price' value="{{$valDate->normal_morning_discount_price}}">
                                                                        <span class="form-text text-muted">Discount Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='prime_morning_actual_price[{{$keyCity+2}}]' id='prime_morning_actual_price_{{$keyCity+2}}' placeholder='Actual Price' value="{{$valDate->prime_morning_actual_price}}">
                                                                        <span class="form-text text-muted">Actual Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='prime_morning_discount_price[{{$keyCity+2}}]' id='prime_morning_discount_price_{{$keyCity+2}}' placeholder='Discount Price' value="{{$valDate->prime_morning_discount_price}}">
                                                                        <span class="form-text text-muted">Discount Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <select name='morning_active[{{$keyCity+2}}]' id='morning_active{{$keyCity+2}}' data-id='{{$keyCity+2}}' class='form-control' >
                                                                            <option value='1' {{ $valDate->morning_active == 1 ? 'selected' : '' }}>Active</option>
                                                                            <option value='0' {{ $valDate->morning_active == 0 ? 'selected' : '' }}>InActive</option>
                                                                            <option value='2' {{ $valDate->morning_active == 2 ? 'selected' : '' }}>Sold Out</option>
                                                                        </select>
                                                                        <span class="form-text text-muted">Status</span>
                                                                    </div>
                                                                </div>
                                                                <div class='row'>
                                                                    <div class='form-group col-md-2'>
                                                                        <label>Afternoon</label>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='normal_afternoon_actual_price[{{$keyCity+2}}]' id='normal_afternoon_actual_price_{{$keyCity+2}}' placeholder='Actual Price' value="{{$valDate->normal_afternoon_actual_price}}">
                                                                        <span class="form-text text-muted">Actual Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='normal_afternoon_discount_price[{{$keyCity+2}}]' id='normal_afternoon_discount_price_{{$keyCity+2}}' placeholder='Discount Price' value="{{$valDate->normal_afternoon_discount_price}}">
                                                                        <span class="form-text text-muted">Discount Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='prime_afternoon_actual_price[{{$keyCity+2}}]' id='prime_afternoon_actual_price_{{$keyCity+2}}' placeholder='Actual Price' value="{{$valDate->prime_afternoon_actual_price}}">
                                                                        <span class="form-text text-muted">Actual Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='prime_afternoon_discount_price[{{$keyCity+2}}]' id='prime_afternoon_discount_price_{{$keyCity+2}}' placeholder='Discount Price' value="{{$valDate->prime_afternoon_discount_price}}">
                                                                        <span class="form-text text-muted">Discount Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <select name='afternoon_active[{{$keyCity+2}}]' id='afternoon_active{{$keyCity+2}}' data-id='{{$keyCity+2}}' class='form-control' >
                                                                            <option value='1' {{ $valDate->afternoon_active == 1 ? 'selected' : '' }}>Active</option>
                                                                            <option value='0' {{ $valDate->afternoon_active == 0 ? 'selected' : '' }}>InActive</option>
                                                                            <option value='2' {{ $valDate->afternoon_active == 2 ? 'selected' : '' }}>Sold Out</option>
                                                                        </select>
                                                                        <span class="form-text text-muted">Status</span>
                                                                    </div>
                                                                </div>
                                                                <div class='row'>
                                                                    <div class='form-group col-md-2'>
                                                                        <label>Evening</label>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='normal_evening_actual_price[{{$keyCity+2}}]' id='normal_evening_actual_price_{{$keyCity+2}}' placeholder='Actual Price' value="{{$valDate->normal_evening_actual_price}}">
                                                                        <span class="form-text text-muted">Actual Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='normal_evening_discount_price[{{$keyCity+2}}]' id='normal_evening_discount_price_{{$keyCity+2}}' placeholder='Discount Price' value="{{$valDate->normal_evening_discount_price}}">
                                                                        <span class="form-text text-muted">Discount Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='prime_evening_actual_price[{{$keyCity+2}}]' id='prime_evening_actual_price_{{$keyCity+2}}' placeholder='Actual Price' value="{{$valDate->prime_evening_actual_price}}">
                                                                        <span class="form-text text-muted">Actual Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='prime_evening_discount_price[{{$keyCity+2}}]' id='prime_evening_discount_price_{{$keyCity+2}}' placeholder='Discount Price' value="{{$valDate->prime_evening_discount_price}}">
                                                                        <span class="form-text text-muted">Discount Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <select name='evening_active[{{$keyCity+2}}][]' id='evening_active{{$keyCity+2}}' data-id='{{$keyCity+2}}' class='form-control' >
                                                                            <option value='1' {{ $valDate->evening_active == 1 ? 'selected' : '' }}>Active</option>
                                                                            <option value='0' {{ $valDate->evening_active == 0 ? 'selected' : '' }}>InActive</option>
                                                                            <option value='2' {{ $valDate->evening_active == 2 ? 'selected' : '' }}>Sold Out</option>
                                                                        </select>
                                                                        <span class="form-text text-muted">Status</span>
                                                                    </div>
                                                                </div>
                                                                <div class='row'>
                                                                    <div class='form-group col-md-2'>
                                                                        <label>Night</label>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='normal_night_actual_price[{{$keyCity+2}}]' id='normal_night_actual_price_{{$keyCity+2}}' placeholder='Actual Price' value="{{$valDate->normal_night_actual_price}}">
                                                                        <span class="form-text text-muted">Actual Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='normal_night_discount_price[{{$keyCity+2}}]' id='normal_night_discount_price_{{$keyCity+2}}' placeholder='Discount Price' value="{{$valDate->normal_night_discount_price}}">
                                                                        <span class="form-text text-muted">Discount Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='prime_night_actual_price[{{$keyCity+2}}]' id='prime_night_actual_price_{{$keyCity+2}}' placeholder='Actual Price' value="{{$valDate->prime_night_actual_price}}">
                                                                        <span class="form-text text-muted">Actual Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <input type='text' class='form-control' name='prime_night_discount_price[{{$keyCity+2}}]' id='prime_night_discount_price_{{$keyCity+2}}' placeholder='Discount Price' value="{{$valDate->prime_night_discount_price}}">
                                                                        <span class="form-text text-muted">Discount Price</span>
                                                                    </div>
                                                                    <div class='form-group col-md-2'>
                                                                        <select name='night_active[{{$keyCity+2}}]' id='night_active{{$keyCity+2}}' data-id='{{$keyCity+2}}' class='form-control' >
                                                                            <option value='1' {{ $valDate->night_active == 1 ? 'selected' : '' }}>Active</option>
                                                                            <option value='0' {{ $valDate->night_active == 0 ? 'selected' : '' }}>InActive</option>
                                                                            <option value='2' {{ $valDate->night_active == 2 ? 'selected' : '' }}>Sold Out</option>
                                                                        </select>
                                                                        <span class="form-text text-muted">Status</span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label >Add Multiple Addons</label>
                                    <div class='element1 row' id='div_11'><div class='form-group'></div></div>
                                    @if(isset($dynamicAddonDetails) && !empty($dynamicAddonDetails))
                                        @foreach($dynamicAddonDetails as $keyCity => $valCity)
                                            @php
                                                $dynamicFileDetails = $objModel->getAddonPackageFiles($valCity->package_id,$valCity->id);
                                            @endphp
                                            <div class='element1 cityrow' id='div_11_{{$keyCity+2}}'>
                                            <input type="hidden" id="addon_id_{{$keyCity+2}}" name="addon_id[{{$keyCity+2}}]" value="{{$valCity->id}}">
                                                    <div class='row'>
                                                        <div class="form-group col-md-6"><label>Add-on Name<span class="required"></span></label><input type="text" id="addon_name_{{$keyCity+2}}" name="addon_name[{{$keyCity+2}}]" data-toggle="tooltip" title="Enter Add-on Name" class="form-control" placeholder="Enter Add-on Name" value="{{$valCity->addon_name}}"></div>
                                                        <div class="form-group col-md-6"><label>Add-on Price<span class="required"></span></label><input type="text" id="addon_price_{{$keyCity+2}}" name="addon_price[{{$keyCity+2}}]" data-toggle="tooltip" title="Enter Add-on Name" class="form-control" placeholder="Enter Add-on Price" value="{{$valCity->addon_price}}"></div>
                                                    </div>
                                                    <div class='row'>
                                                        <div class='form-group col-md-6'><label>Add-on Description</label><textarea id='addon_description_{{$keyCity+2}}' name='addon_description[{{$keyCity+2}}]' rows='10' cols='20' data-toggle='tooltip' title='Enter Add-on Description'class='form-control' placeholder='Enter Add-on Description'>{{$valCity->addon_description}}</textarea></div>
                                                        <div class='form-group col-md-6'>
                                                            <label>Image<span class='required'></span></label>
                                                            <div></div>
                                                            <div class='custom-file'><input type='file' class='custom-file-input' id='customFile' name='addonfile[{{$keyCity+2}}][]' multiple><label class='custom-file-label' for='customFile'>Choose file</label></div>
                                                            <span class='form-text text-muted'>Image should be .png and size should be less than 10 MB</span>
                                                            <div class="gallery1">
                                                                @if(isset($dynamicFileDetails) && !empty($dynamicFileDetails))
                                                                    @foreach($dynamicFileDetails as $key => $val)
                                                                        <a href="{{url('files/package_addon/'.$val->name)}}" id="package_addon_files_{{$val->id}}">
                                                                            @if(in_array(pathinfo($val->name, PATHINFO_EXTENSION),array('png','jpg','jpeg','bmp')))
                                                                                <img src="{{url('files/package_addon/'.$val->name)}}" alt="image" width="100" height="100">
                                                                            @else
                                                                                <img src="{{url('assets/images/file.png')}}" alt="file" width="100" height="100">
                                                                            @endif
                                                                        </a>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                    @endif    
                                </div>
                                <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>General Notes</label>
                                            <textarea id="general_notes" name="general_notes" rows="10" cols="20" data-toggle="tooltip" title="Enter General Notes"
                                            class="form-control" placeholder="Enter General Notes">{{ $data->general_notes }}</textarea>
                                        </div>
                                    </div>
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <a href="{{ url(VIEW_INFO['url']) }}"><button type="button" class="btn btn-success"
                                        id="back">Cancel</button></a>
                                </div>
                            </div>
                        
    
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
<script src="{{ asset('admin/assets/js/simple-lightbox.jquery.min.js') }}"></script>
<script>
   CKEDITOR.replace( 'inclusion' );
   CKEDITOR.replace( 'detail_description' );
   CKEDITOR.replace( 'general_notes' );
</script>
<script src="{{ asset('admin/assets/js/pages/custom/package.js') }}"></script>
<script>
    $('document').ready(function() {
    <?php if(isset($dynamicFileDetails) && !empty($dynamicFileDetails) && count($dynamicFileDetails) > 0) {?>
        var gallery1 = $('.gallery1 a').simpleLightbox({});
    <?php }?>
    });
    // Add new element
	$("#addMore").click(function(){
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
            var tierSelect = "<select name='tier_id["+ nextindex +"]' id='tier_id"+ nextindex +"' class='form-control tierselection' required><option value=''>-Select Tier-</option>";
            @if(isset($arrTier) && !empty($arrTier))
                @foreach($arrTier as $key=>$val)
                tierSelect += "<option value='{{$val->id}}' >{{$val->name}}</option>";
                @endforeach
            @endif
            tierSelect += "</select><span class='form-text text-muted'>Tier</span>";
            $("#div_" + nextindex).append("<div class='row'><div class='form-group col-md-2'>"+tierSelect+"</div><div class='form-group col-md-2'><button type='button' id='remove_" + nextindex + "' class='remove btn btn-danger float-right'><i title='Add Tier' class='fa fa-trash'></i> Remove</button></div></div><div class='row'><div class='col-md-2'></div><div class='col-md-4'><strong>Normal Days</strong></div><div class='col-md-4'><strong>Prime Days</strong></div><div class='col-md-2'></div></div><div class='row'><div class='form-group col-md-2'><label>Morning</label></div><div class='form-group col-md-2'><input type='text' class='form-control' name='normal_morning_actual_price["+ nextindex +"]' id='normal_morning_actual_price_"+ nextindex +"' placeholder='Actual Price'><span class='form-text text-muted'>Actual Price</span></div><div class='form-group col-md-2'><input type='text' class='form-control' name='normal_morning_discount_price["+ nextindex +"]' id='normal_morning_discount_price_"+ nextindex +"' placeholder='Discount Price'><span class='form-text text-muted'>Discount Price</span></div><div class='form-group col-md-2'><input type='text' class='form-control' name='prime_morning_actual_price["+ nextindex +"]' id='prime_morning_actual_price_"+ nextindex +"' placeholder='Actual Price'><span class='form-text text-muted'>Actual Price</span></div><div class='form-group col-md-2'><input type='text' class='form-control' name='prime_morning_discount_price["+ nextindex +"]' id='prime_morning_discount_price_"+ nextindex +"' placeholder='Discount Price'><span class='form-text text-muted'>Discount Price</span></div><div class='form-group col-md-2'><select class='form-control' name='morning_active["+ nextindex +"]' id='morning_active_"+ nextindex +"'><option value='1' selected>Active</option><option value='0'>InActive</option><option value='2'>Sold Out</option><span class='form-text text-muted'>Status</span></select></div></div><div class='row'><div class='form-group col-md-2'><label>Afternoon</label></div><div class='form-group col-md-2'><input type='text' class='form-control' name='normal_afternoon_actual_price["+ nextindex +"]' id='normal_afternoon_actual_price_"+ nextindex +"' placeholder='Actual Price'><span class='form-text text-muted'>Actual Price</span></div><div class='form-group col-md-2'><input type='text' class='form-control' name='normal_afternoon_discount_price["+ nextindex +"]' id='normal_afternoon_discount_price_"+ nextindex +"' placeholder='Discount Price'></div><div class='form-group col-md-2'><input type='text' class='form-control' name='prime_afternoon_actual_price["+ nextindex +"]' id='prime_afternoon_actual_price_"+ nextindex +"' placeholder='Actual Price'><span class='form-text text-muted'>Actual Price</span></div><div class='form-group col-md-2'><input type='text' class='form-control' name='prime_afternoon_discount_price["+ nextindex +"]' id='prime_afternoon_discount_price_"+ nextindex +"' placeholder='Discount Price'></div><div class='form-group col-md-2'><select class='form-control' name='afternoon_active["+ nextindex +"]' id='afternoon_active_"+ nextindex +"'><option value='1' selected>Active</option><option value='0'>InActive</option><option value='2'>Sold Out</option></select><span class='form-text text-muted'>Status</span></div></div><div class='row'><div class='form-group col-md-2'><label>Evening</label></div><div class='form-group col-md-2'><input type='text' class='form-control' name='normal_evening_actual_price["+ nextindex +"]' id='normal_evening_actual_price_"+ nextindex +"' placeholder='Actual Price'><span class='form-text text-muted'>Actual Price</span></div><div class='form-group col-md-2'><input type='text' class='form-control' name='normal_evening_discount_price["+ nextindex +"]' id='normal_evening_discount_price_"+ nextindex +"' placeholder='Discount Price'><span class='form-text text-muted'>Discount Price</span></div><div class='form-group col-md-2'><input type='text' class='form-control' name='prime_evening_actual_price["+ nextindex +"]' id='prime_evening_actual_price_"+ nextindex +"' placeholder='Actual Price'><span class='form-text text-muted'>Actual Price</span></div><div class='form-group col-md-2'><input type='text' class='form-control' name='prime_evening_discount_price["+ nextindex +"]' id='prime_evening_discount_price_"+ nextindex +"' placeholder='Discount Price'><span class='form-text text-muted'>Discount Price</span></div><div class='form-group col-md-2'><select class='form-control' name='evening_active["+ nextindex +"]' id='evening_active_"+ nextindex +"'><option value='1' selected>Active</option><option value='0'>InActive</option><option value='2'>Sold Out</option></select><span class='form-text text-muted'>Status</span></div></div><div class='row'><div class='form-group col-md-2'><label>Night</label></div><div class='form-group col-md-2'><input type='text' class='form-control' name='normal_night_actual_price["+ nextindex +"]' id='normal_night_actual_price_"+ nextindex +"' placeholder='Actual Price'><span class='form-text text-muted'>Actual Price</span></div><div class='form-group col-md-2'><input type='text' class='form-control' name='normal_night_discount_price["+ nextindex +"]' id='prime_night_discount_price_"+ nextindex +"' placeholder='Discount Price'><span class='form-text text-muted'>Discount Price</span></div><div class='form-group col-md-2'><input type='text' class='form-control' name='prime_night_actual_price["+ nextindex +"]' id='prime_night_actual_price_"+ nextindex +"' placeholder='Actual Price'><span class='form-text text-muted'>Actual Price</span></div><div class='form-group col-md-2'><input type='text' class='form-control' name='prime_night_discount_price["+ nextindex +"]' id='prime_night_discount_price_"+ nextindex +"' placeholder='Discount Price'><span class='form-text text-muted'>Discount Price</span></div><div class='form-group col-md-2'><select class='form-control' name='night_active["+ nextindex +"]' id='night_active_"+ nextindex +"'><option value='1' selected>Active</option><option value='0'>InActive</option><option value='2'>Sold Out</option></select><span class='form-text text-muted'>Status</span></div>");
		}
    });
    // Add new element
	$("#addMore1").click(function(){
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
    function deleteFile(tableName, id, path, file, remove){
        $.ajax({
            url: '/admin/user/delete-file',        
            type: 'post',        
            data: { 'tableName': tableName, 'path': path, 'file': file, 'id': id, _token : '{{csrf_token()}}'  },
            success: function( data, textStatus, jQxhr ){
                $("#"+tableName+"_"+id).hide();
                $("#"+remove+"_"+tableName+"_"+id).hide();
            }
        });
    }
</script>
@stop