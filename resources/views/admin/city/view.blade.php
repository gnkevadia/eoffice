@extends('admin.layouts.default')

@section('title', 'VIEW '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/city') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
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
                                                <label>Country<span class="required"><code>*</code></span></label>
                                                <select name="country_id" id="country_id" class="form-control" >
                                                    <option value="">-Select-</option>
                                                    @if(isset($countries) && !empty($countries))
                                                        @foreach($countries as $keycountry=>$valcountry)
                                                            <option value="{{ $valcountry->id }}" @if(isset($data->country_id) && $valcountry->id == $data->country_id) selected @endif >{{ $valcountry->nicename }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Tier<span class="required"><code>*</code></span></label>
                                                <select name="tier_id" id="tier_id" class="form-control" >
                                                    <option value="">-Select-</option>
                                                    @if(isset($tiers) && !empty($tiers))
                                                        @foreach($tiers as $keytiers=>$valtiers)
                                                            <option value="{{ $valtiers->id }}" @if(isset($data->tier_id) && $valtiers->id == $data['tier_id']) selected @endif >{{ $valtiers->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>City Name<span class="required"><code>*</code></span></label>
                                                <input type="text" id="name" name="name" maxlength="50" data-toggle="tooltip" title="Enter City Name" class="form-control" placeholder="Enter City Name" @if(isset($data->name)) value="{{ $data->name }}" @endif>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleSelect1">Status<span class="required"><code>*</code></span></label>
                                                <select class="form-control" id="status" name="status">
                                                    <option {{($data->status == 1 ? 'selected' : '')}} value="1">Active</option>
                                                    <option {{($data->status == 0 ? 'selected' : '')}} value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label >Add Multiple Cluster</label>
                                            <div class="dynamicElements clearfix" id="dynamicElements">
                                                <div class='element row' id='div_1'><div class='form-group'></div></div>
                                                @php
                                                    if(isset($data->cluster) && !empty($data->cluster)){
                                                        $dynamicClusterDetails = json_decode($data->cluster);
                                                    }
                                                    if(isset($data->area) && !empty($data->area)){
                                                        $dynamicAreaDetails = json_decode($data->area);
                                                    }
                                                @endphp
                                                @if(isset($dynamicClusterDetails) && !empty($dynamicClusterDetails))
                                                    @foreach($dynamicClusterDetails as $keyCluster => $valCluster)
                                                        <div class='element cityrow' id='div_{{$keyCluster+2}}'>
                                                            <div class='row'>
                                                                <div class='form-group col-md-5'>
                                                                    <input type="text" id="cluster{{$keyCluster+2}}" name="cluster[{{$keyCluster+2}}]" maxlength="50" data-toggle="tooltip" title="Enter Cluster" class="form-control" placeholder="Enter Cluster" value="{{ $valCluster }}">
                                                                </div>
                                                                <div class='form-group col-md-5'>
                                                                    <input type="text" id="area{{$keyCluster+2}}" name="area[{{$keyCluster+2}}]" maxlength="50" data-toggle="tooltip" title="Enter area with comma seprated" class="form-control" placeholder="Enter area with comma seprated" @if(isset($dynamicAreaDetails->$keyCluster)) value="{{ @$dynamicAreaDetails->$keyCluster }}" @endif>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <div class="col-md-12 card-header">
                                                <h3 class="display-5">Slot</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-2">
                                                <label>Morning<span class="required"><code>*</code></span></label>
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="is_morning" @if(isset($data->is_morning) && !empty($data->is_morning)) checked @endif value="1"> &nbsp;
                                                    <span></span>
                                                </label>
                                                <input type="text" id="morning_name" name="morning_name" maxlength="50" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" @if(isset($data->morning_name)) value="{{ $data->morning_name }}" @else value="Morning" @endif>
                                                <span class="form-text text-muted">Time Slot Name</span>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>&nbsp;</label>
                                                <input type="text" id="morning_start" name="morning_start" maxlength="50" data-toggle="tooltip" title="Enter Start Time" class="form-control" placeholder="Enter Start Time" @if(isset($data->morning_start)) value="{{ $data->morning_start }}" @endif>
                                                <span class="form-text text-muted">Morning Start Time</span>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>&nbsp;</label>
                                                <input type="text" id="morning_end" name="morning_end" maxlength="50" data-toggle="tooltip" title="Enter Time" class="form-control" placeholder="Enter Time" @if(isset($data->morning_end)) value="{{ $data->morning_end }}" @endif>
                                                <span class="form-text text-muted">Morning End Time</span>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>&nbsp;</label>
                                                <input type="text" id="morning_prime_day_traveling_time" name="morning_prime_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Prime Day Traveling Time" class="form-control" placeholder="Enter Prime Day Traveling Time" @if(isset($data->morning_prime_day_traveling_time)) value="{{ $data->morning_prime_day_traveling_time }}" @else value="20" @endif required>
                                                <span class="form-text text-muted">Prime Day Traveling Time (In Min.)</span>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>&nbsp;</label>
                                                <input type="text" id="morning_normal_day_traveling_time" name="morning_normal_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Normal Day Traveling Time" class="form-control" placeholder="Enter Normal Day Traveling Time" @if(isset($data->morning_normal_day_traveling_time)) value="{{ $data->morning_normal_day_traveling_time }}" @else value="20" @endif required>
                                                <span class="form-text text-muted">Normal Day Traveling Time (In Min.)</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-2">
                                                <label>Afternoon<span class="required"><code>*</code></span></label>
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="is_afternoon" @if(isset($data->is_afternoon) && !empty($data->is_afternoon)) checked @endif value="1"> &nbsp;
                                                    <span></span>
                                                </label>
                                                <input type="text" id="afternoon_name" name="afternoon_name" maxlength="50" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" @if(isset($data->afternoon_name)) value="{{ $data->afternoon_name }}" @else value="Afternoon" @endif>
                                                <span class="form-text text-muted">Time Slot Name</span>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>&nbsp;</label>
                                                <input type="text" id="afternoon_start" name="afternoon_start" maxlength="50" data-toggle="tooltip" title="Enter Start Time" class="form-control" placeholder="Enter Start Time" @if(isset($data->afternoon_start)) value="{{ $data->afternoon_start }}" @endif>
                                                <span class="form-text text-muted">Afternoon Start Time</span>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>&nbsp;</label>
                                                <input type="text" id="afternoon_end" name="afternoon_end" maxlength="50" data-toggle="tooltip" title="Enter Time" class="form-control" placeholder="Enter Time" @if(isset($data->afternoon_end)) value="{{ $data->afternoon_end }}" @endif>
                                                <span class="form-text text-muted">Afternoon End Time</span>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>&nbsp;</label>
                                                <input type="text" id="afternoon_prime_day_traveling_time" name="afternoon_prime_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Prime Day Traveling Time" class="form-control" placeholder="Enter Prime Day Traveling Time" @if(isset($data->afternoon_prime_day_traveling_time)) value="{{ $data->afternoon_prime_day_traveling_time }}" @else value="20" @endif required>
                                                <span class="form-text text-muted">Prime Day Traveling Time (In Min.)</span>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>&nbsp;</label>
                                                <input type="text" id="afternoon_normal_day_traveling_time" name="afternoon_normal_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Normal Day Traveling Time" class="form-control" placeholder="Enter Normal Day Traveling Time" @if(isset($data->afternoon_normal_day_traveling_time)) value="{{ $data->afternoon_normal_day_traveling_time }}" @else value="20" @endif required>
                                                <span class="form-text text-muted">Normal Day Traveling Time (In Min.)</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-2">
                                                <label>Evening<span class="required"><code>*</code></span></label>
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="is_evening" @if(isset($data->is_evening) && !empty($data->is_evening)) checked @endif value="1"> &nbsp;
                                                    <span></span>
                                                </label>
                                                <input type="text" id="evening_name" name="evening_name" maxlength="50" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" @if(isset($data->evening_name)) value="{{ $data->evening_name }}" @else value="Evening" @endif>
                                                <span class="form-text text-muted">Time Slot Name</span>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>&nbsp;</label>
                                                <input type="text" id="evening_start" name="evening_start" maxlength="50" data-toggle="tooltip" title="Enter Start Time" class="form-control" placeholder="Enter Start Time" @if(isset($data->evening_start)) value="{{ $data->evening_start }}" @endif>
                                                <span class="form-text text-muted">Evening Start Time</span>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>&nbsp;</label>
                                                <input type="text" id="evening_end" name="evening_end" maxlength="50" data-toggle="tooltip" title="Enter Time" class="form-control" placeholder="Enter Time" @if(isset($data->evening_end)) value="{{ $data->evening_end }}" @endif>
                                                <span class="form-text text-muted">Evening End Time</span>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>&nbsp;</label>
                                                <input type="text" id="evening_prime_day_traveling_time" name="evening_prime_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Prime Day Traveling Time" class="form-control" placeholder="Enter Prime Day Traveling Time" @if(isset($data->evening_prime_day_traveling_time)) value="{{ $data->evening_prime_day_traveling_time }}" @else value="20" @endif required>
                                                <span class="form-text text-muted">Prime Day Traveling Time (In Min.)</span>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>&nbsp;</label>
                                                <input type="text" id="evening_normal_day_traveling_time" name="evening_normal_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Edit Normal Day Traveling Time" class="form-control" placeholder="Enter Normal Day Traveling Time" @if(isset($data->evening_normal_day_traveling_time)) value="{{ $data->evening_normal_day_traveling_time }}" @else value="20" @endif required>
                                                <span class="form-text text-muted">Normal Day Traveling Time (In Min.)</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-2">
                                                <label>Night<span class="required"><code>*</code></span></label>
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="is_night" @if(isset($data->is_night) && !empty($data->is_night)) checked @endif value="1"> &nbsp;
                                                    <span></span>
                                                </label>
                                                <input type="text" id="night_name" name="night_name" maxlength="50" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" @if(isset($data->night_name)) value="{{ $data->night_name }}" @else value="Night" @endif>
                                                <span class="form-text text-muted">Time Slot Name</span>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>&nbsp;</label>
                                                <input type="text" id="night_start" name="night_start" maxlength="50" data-toggle="tooltip" title="Enter Start Time" class="form-control" placeholder="Enter Start Time" @if(isset($data->night_start)) value="{{ $data->night_start }}" @endif>
                                                <span class="form-text text-muted">Night Start Time</span>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>&nbsp;</label>
                                                <input type="text" id="night_end" name="night_end" maxlength="50" data-toggle="tooltip" title="Enter Time" class="form-control" placeholder="Enter Time" @if(isset($data->night_end)) value="{{ $data->night_end }}" @endif>
                                                <span class="form-text text-muted">Night End Time</span>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>&nbsp;</label>
                                                <input type="text" id="night_prime_day_traveling_time" name="night_prime_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Prime Day Traveling Time" class="form-control" placeholder="Enter Prime Day Traveling Time" @if(isset($data->night_prime_day_traveling_time)) value="{{ $data->night_prime_day_traveling_time }}" @else value="20" @endif required>
                                                <span class="form-text text-muted">Prime Day Traveling Time (In Min.)</span>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>&nbsp;</label>
                                                <input type="text" id="night_normal_day_traveling_time" name="night_normal_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Normal Day Traveling Time" class="form-control" placeholder="Enter Normal Day Traveling Time" @if(isset($data->night_normal_day_traveling_time)) value="{{ $data->night_normal_day_traveling_time }}" @else value="20" @endif required>
                                                <span class="form-text text-muted">Normal Day Traveling Time (In Min.)</span>
                                            </div>
                                        </div>
                                
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label>General Notes</label>
                                                <textarea id="general_notes" name="general_notes" rows="10" cols="20" data-toggle="tooltip" title="Enter General Notes"
                                                class="form-control" placeholder="Enter General Notes">{{$data->general_notes }}</textarea>
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
<script src="{{ asset('admin/assets/js/pages/custom/city.js') }}"></script>
<script>
CKEDITOR.replace( 'general_notes' );
</script>
<script>
jQuery(document).ready(function() {
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

            var citySelect = '<input type="text" id="cluster'+ nextindex +'" name="cluster['+ nextindex +']" maxlength="50" data-toggle="tooltip" title="Enter Cluster" class="form-control" placeholder="Enter Cluster">';
            var areaSelect = '<input type="text" id="area'+ nextindex +'" name="area['+ nextindex +']" maxlength="50" data-toggle="tooltip" title="Enter area with comma seprated" class="form-control" placeholder="Enter area with comma seprated">';
            $("#div_" + nextindex).append("<div class='row'><div class='form-group col-md-5'>"+citySelect+"</div><div class='form-group col-md-5'>"+areaSelect+"</div><div class='form-group col-md-2'><button type='button' id='remove_" + nextindex + "' class='remove btn btn-danger float-right'><i title='Remove Cluster' class='fa fa-trash'></i> Remove Cluster</button></div></div></div>");
            $('.kt-selectpicker').selectpicker('refresh');
		}
    });
    // Remove element
    $(".dynamicElements").on('click','.remove',function(){
        var id = this.id;
        var split_id = id.split("_");
        var deleteindex = split_id[1];
        
        // Remove <div> with id
        $("#div_" + deleteindex).remove();
    });
    // Remove element
    $(".dynamicElementsDate").on('click','.removeDate',function(){
        var id = this.id;
        var split_id = id.split("_");
        var deleteindex = split_id[1];
        var deleteDateindex = split_id[2];
        
        // Remove <div> with id
        $("#datediv_" + deleteindex + "_"+ deleteDateindex).remove();
    });
});
</script>
@stop