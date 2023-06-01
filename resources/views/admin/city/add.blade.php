@extends('admin.layouts.default')

@section('title', 'Add '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/city') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="#" class="kt-subheader__breadcrumbs-link">Add {{ VIEW_INFO['title'] }} Details</a>
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
                                        Add {{ VIEW_INFO['title'] }}
                                </h3>
                            </div>
                        </div>

						<!--begin::Form-->
                        <form id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/add') }}" class="form-horizontal" enctype="multipart/form-data" 
                    method="post">{{ csrf_field() }}
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
                                                            <option value="{{ $valcountry->id }}" @if($valcountry->id == 1) selected @endif >{{ $valcountry->nicename }}</option>
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
                                                <input type="text" id="name" name="name" maxlength="50" data-toggle="tooltip" title="Enter City Name" class="form-control" placeholder="Enter City Name" @if(isset($data['name'])) value="{{ $data['name'] }}" @endif>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleSelect1">Status<span class="required"><code>*</code></span></label>
                                                <select class="form-control" id="status" name="status">
                                                        <option value="1" selected>Active</option>
                                                        <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label >Add Multiple Cluster</label>
                                            <div class="dynamicElements clearfix" id="dynamicElements">
                                                <div class='element row' id='div_1'><div class='form-group'></div></div>
                                            </div>
                                            <button type="button" id="addMore" class="btn btn-primary clear"><i title="Add Cluster" class="fa fa-plus"></i> Add Cluster</button>
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
                                                    <input type="checkbox" name="is_morning" checked value="1"> &nbsp;
                                                    <span></span>
                                                </label>
                                                <input type="text" id="morning_name" name="morning_name" maxlength="50" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" value="Morning">
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
                                                <input type="text" id="morning_prime_day_traveling_time" name="morning_prime_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Prime Day Traveling Time" class="form-control" placeholder="Enter Prime Day Traveling Time" required value="20">
                                                <span class="form-text text-muted">Prime Day Traveling Time (In Min.)</span>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>&nbsp;</label>
                                                <input type="text" id="morning_normal_day_traveling_time" name="morning_normal_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Normal Day Traveling Time" class="form-control" placeholder="Enter Normal Day Traveling Time" required value="20">
                                                <span class="form-text text-muted">Normal Day Traveling Time (In Min.)</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-2">
                                                <label>Afternoon<span class="required"><code>*</code></span></label>
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="is_afternoon" checked value="1"> &nbsp;
                                                    <span></span>
                                                </label>
                                                <input type="text" id="afternoon_name" name="afternoon_name" maxlength="50" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" value="Afternoon">
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
                                                <input type="text" id="afternoon_prime_day_traveling_time" name="afternoon_prime_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Prime Day Traveling Time" class="form-control" placeholder="Enter Prime Day Traveling Time" required value="20">
                                                <span class="form-text text-muted">Prime Day Traveling Time (In Min.)</span>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>&nbsp;</label>
                                                <input type="text" id="afternoon_normal_day_traveling_time" name="afternoon_normal_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Normal Day Traveling Time" class="form-control" placeholder="Enter Normal Day Traveling Time" required value="20">
                                                <span class="form-text text-muted">Normal Day Traveling Time (In Min.)</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-2">
                                                <label>Evening<span class="required"><code>*</code></span></label>
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="is_evening" checked value="1"> &nbsp;
                                                    <span></span>
                                                </label>
                                                <input type="text" id="evening_name" name="evening_name" maxlength="50" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" value="Evening">
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
                                                <input type="text" id="evening_prime_day_traveling_time" name="evening_prime_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Prime Day Traveling Time" class="form-control" placeholder="Enter Prime Day Traveling Time" required value="20">
                                                <span class="form-text text-muted">Prime Day Traveling Time (In Min.)</span>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>&nbsp;</label>
                                                <input type="text" id="evening_normal_day_traveling_time" name="evening_normal_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Normal Day Traveling Time" class="form-control" placeholder="Enter Normal Day Traveling Time" required value="20">
                                                <span class="form-text text-muted">Normal Day Traveling Time (In Min.)</span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-lg-2">
                                                <label>Night<span class="required"><code>*</code></span></label>
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="is_night" checked value="1"> &nbsp;
                                                    <span></span>
                                                </label>
                                                <input type="text" id="night_name" name="night_name" maxlength="50" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" value="Night">
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
                                                <input type="text" id="night_prime_day_traveling_time" name="night_prime_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Prime Day Traveling Time" class="form-control" placeholder="Enter Prime Day Traveling Time" required value="20">
                                                <span class="form-text text-muted">Prime Day Traveling Time (In Min.)</span>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>&nbsp;</label>
                                                <input type="text" id="night_normal_day_traveling_time" name="night_normal_day_traveling_time" maxlength="50" data-toggle="tooltip" title="Enter Normal Day Traveling Time" class="form-control" placeholder="Enter Normal Day Traveling Time" required value="20">
                                                <span class="form-text text-muted">Normal Day Traveling Time (In Min.)</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>General Notes</label>
                                            <textarea id="general_notes" name="general_notes" rows="10" cols="20" data-toggle="tooltip" title="Enter General Notes"
                                            class="form-control" placeholder="Enter General Notes">{{ old('general_notes') }}</textarea>
                                        </div>
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
<script>

</script>
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
            $("#div_" + nextindex).append("<div class='row'><div class='form-group col-md-5'>"+citySelect+"</div><div class='form-group col-md-5'>"+areaSelect+"</div><div class='form-group col-md-2'><button type='button' id='remove_" + nextindex + "' class='remove btn btn-danger float-right'><i title='Add City' class='fa fa-trash'></i> Remove Cluster</button></div></div></div>");
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
});
</script>
@stop