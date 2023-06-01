@extends('admin.layouts.default')

@section('title', 'EDIT '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/booking') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="#" class="kt-subheader__breadcrumbs-link">View {{ VIEW_INFO['title'] }} Details</a>
    <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
</div>
@stop

@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
<form method="post" name="frmBookingX" id="frmBookingX">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
            <input type="hidden" name="city_date_package" value="" id="city_date_package">
            <input type="hidden" id="adddiscountedamt" name="adddiscountedamt" value="">
            <input type="hidden" id="basepriceamt" name="basepriceamt" value="">
            <input type="hidden" id="kids_start_from" name="kids_start_from" value="">
            <input type="hidden" id="package_date" name="package_date" value="">
            <input type="hidden" id="package_time" name="package_time" value="">
            <input type="hidden" id="choosedgift1" name="choosedgift1" value="">
            <input type="hidden" id="choosedgift2" name="choosedgift2" value="">
            <input type="hidden" id="addamt" name="addamt" value="">
                <!--begin::Portlet-->
                <div class="kt-portlet">
								<div class="kt-portlet__body kt-portlet__body--fit">
									
                                <div class="accordion" id="">
												<div class="card">
													<div class="card-header" id="headingOne">
														<div class="card-title" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                                                            Booking Details
														</div>
													</div>
													<div id="collapseOne1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample1">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>City</label>
                                                                        <select class="custom-select" name="city_id" id="city_id" required="true">
                                                                        <option value="">Choose your city</option>
                                                                        @if(isset($arrCity) && !empty($arrCity))
                                                                        @foreach($arrCity as $keyCity=>$valCity)
                                                                            <option value="{{$valCity->id}}">{{$valCity->name}}</option>                 
                                                                        @endforeach
                                                                        @endif
                                                                        </select>                                                                        
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Area</label>
                                                                        <select class="custom-select" id="area_id" name="area_id" required="true">
                                                                            @if(isset($arrAreaList) && !empty($arrAreaList))
                                                                            <option value="">Choose your area</option>
                                                                            @foreach($arrAreaList as $keyArea=>$valArea)
                                                                            <option data-id="{{$valArea->city_id}}" value="{{$valArea->id}}">{{$valArea->name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>                                                                        
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="card-body">                                                                    
                                                                    <div class="package_detail_city_drp form-group">
                                                                        <label>Package</label>
                                                                        <select class="custom-select" name='package_id' id='package_id' required="true">
                                                                            <option value="">Choose your package</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>No of Kids</label>
                                                                        <select class="custom-select" name='kids' id='kids' >
                                                                            <option value="">No of Kids</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Booking Dates</label>
                                                                        <div class="package_detail_date">
                                                                        <select class="custom-select" name='surprice_package_date' id='surprice_package_date' required="true">          <option value="">Choose your Booking Date</option>                
                                                                        </select>
                                                                        </div>
                                                                    </div>                                                                   
                                                            </div>
                                                        </div>
													</div>
                                                </div>
                                                <div class="card">
                                                    <div id="package_plan_div"></div>
                                                </div>
												<div class="card">
													<div class="card-header" id="headingTwo">
														<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
                                                            Guardian Details
														</div>
													</div>
													<div id="collapseTwo1" class="collapse show" aria-labelledby="headingTwo1" data-parent="#accordionExample1">
														<div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Name Of Guardian</label>
                                                                        <input type="text" name="guardian_name" id="guardian_name" id="" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Alternate Number</label>
                                                                        <input type="text" maxLength="10" name="guardian_alt_mobile" id="guardian_alt_mobile" id="" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Address</label>
                                                                        <textarea type="text" name="guardian_address" id="guardian_address" class="form-control" ></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Mobile</label>
                                                                        <input type="text" maxLength="10" name="guardian_mobile" id="guardian_mobile" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input type="text" name="guardian_email" id="guardian_email" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card-body">    
                                                                    <input type="checkbox" name="chkSame" id="chkSame" class="copyAdrs">&nbsp;&nbsp;Same as above
                                                                </div>
                                                            </div>  
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Billing Name</label>
                                                                        <input type="text" name="bill_name" id="bill_name" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Alternate Number</label>
                                                                        <input type="text" maxLength="10" name="bill_alt_mobile" id="bill_alt_mobile" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Address</label>
                                                                        <textarea type="text" name="bill_address" id="bill_address" class="form-control"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Mobile</label>
                                                                        <input type="text" maxLength="10" name="bill_mobile" id="bill_mobile" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input type="text" name="bill_email" id="bill_email" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
														</div>
													</div>
												</div>
												<div class="card">
													<div class="card-header" id="headingThree1">
														<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree1" aria-expanded="false" aria-controls="collapseThree1">
                                                        Information of Kids
														</div>
													</div>
													<div id="collapseThree1" class="collapse show" aria-labelledby="headingThree1" data-parent="#accordionExample1">
														<div class="card-body">
                                                            <div class="row">
                                                                <div class="noofkidit" id="noofkidit">No Kids selected</div>
                                                                <!--<div class="col-md-4">
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <label>Name</label>
                                                                            <input type="text" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <label>Age</label>
                                                                            <input type="text" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <label>Gender</label>
                                                                            <input type="text" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card">
													<div class="card-header" id="headingFour1">
														<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseFour1" aria-expanded="false" aria-controls="collapseFour1">
                                                            Gift
														</div>
													</div>
													<div id="collapseFour1" class="collapse show" aria-labelledby="headingFour1" data-parent="#accordionExample1">
														<div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <input type="checkbox" name="choodegift" id="choodegift_hand" class="choodegift" value="gift" >
                                                                        <label>Santa gifts your child the gift of your choice</label>                                       
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Special Instruction</label>
                                                                        <textarea id="special_notes" name="special_instruction"  class="form-control"> </textarea>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Special Message</label>
                                                                        <textarea  id="special_message" name="special_message" class="form-control"></textarea>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Special Notes</label>
                                                                        <textarea id="special_notes" name="special_notes" class="form-control"></textarea>           
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Inclusion</label>
                                                                        <textarea id="admin_inclusion" name="admin_inclusion" class="form-control"></textarea>       
                                                                    </div>
                                                                </div>
                                                            </div>                                                            
                                                        </div>
														</div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="card">
													<div class="card-header" id="headingFive1">
														<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseFive1" aria-expanded="false" aria-controls="collapseFive1">
                                                        Price Summary
														</div>
													</div>
													<div id="collapseFive1" class="collapse show" aria-labelledby="headingFive1" data-parent="#accordionExample1">
														<div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Base Price</label>
                                                                        <input type="text" name="basepriceactulaamt" id="basepriceactulaamt" readonly class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Discount</label>
                                                                        <input type="text" name="discountamt" id="discountamt" readonly class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Discounted Price</label>
                                                                        <input type="text" name="discountedamt" id="discountedamt" readonly class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Tax</label>
                                                                        <input type="text" name="taxamt" id="taxamt" readonly class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Coupon</label>
                                                                        <input type="text" name="coupon_code" id="coupon_code" class="form-control coupon_code">
                                                                        <input type="button" value="Apply Now" name="coupon_appy" id="coupon_appy" class="coupon_appy btn btn-info">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Additional Kids</label>
                                                                        <div class="form-control addamountadmin"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Total</label>
                                                                        <input type="text" name="totalpriceamt" readonly id="totalpriceamt" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
														</div>
                                                    </div>                                                    
                                                </div>
                                                <div class="card">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <div class="card-body">
                                                            <input class="btn btn-success" type="submit" value="Save" name="Save" id="save_booking"/>
                                                            </div>
                                                        </div> 
                                                        <div class="col-md-1">
                                                            <div class="card-body">
                                                                
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>    
                                            </div>
										</div>
								</div>
							</div>
                    <!--end::Portlet-->
            </div>
        </div>
</form>
	</div>
<!-- Main content -->
@stop

@section('metronic_js')
<script src="{{ asset('admin/assets/js/pages/custom/booking.js') }}"></script>
<script src="{{ asset('admin/assets/js/ckeditor/ckeditor.js') }}"></script>
<script>
   CKEDITOR.replace( 'admin_inclusion' );
</script>
<script>
$('#area_id').find('option').hide();
$('#city_id').change(function() {    
    $('#area_id').find('option').hide()
    $('#area_id').find('option[data-id="'+$('#city_id').val()+'"]').show();
    $('#area_id').val('');
    $('#package_id').val('');
    $('#kids').val('');
    $('#surprice_package_date').val('');
    $("#noofkidit").html('');
    $("#package_plan_div").html('');
    $.ajax({
        url: '/admin/booking/add',        
        type: 'get',        
        data: { 'getPackage' : '1','city_id': $('#city_id').val() },
        success: function( data, textStatus, jQxhr ){
            $('#package_id').html(data);
            $('#package_id').trigger('change');
        }
    });
})
$('#package_id').change(function(){
    $.ajax({
        url: '/admin/booking/add',        
        type: 'get',        
        data: { 'getPackageDateTime' : '1','package_id': $('#package_id').val(), 'city_id': $('#city_id').val() },
        success: function( data, textStatus, jQxhr ){
            $('#surprice_package_date').html(data);
            $.ajax({
                url: '/admin/booking/add',        
                type: 'get',        
                data: { 'getChild' : '1','package_id': $('#package_id').val(), 'city_id': $('#city_id').val() },
                success: function( data, textStatus, jQxhr ){
                    $('#kids').html(data);                    
                }
            });
        }
    });
    
    
})
$('#surprice_package_date').change(function(){
    $.ajax({
        url: '/admin/booking/add',        
        type: 'get',        
        data: { 'getPackageDetails' : '1','booking_date': $('#surprice_package_date').val(),'package_id': $('#package_id').val(), 'city_id': $('#city_id').val(),'city_date_package': '' },
        success: function( data, textStatus, jQxhr ){
            $('#package_plan_div').html(data);
        }
    });    
})
$(".copyAdrs").on("click",function () {
      if($(this).prop('checked') == true){
        $('#bill_name').val($('#guardian_name').val());
        $('#bill_mobile').val($('#guardian_mobile').val());
        $('#bill_alt_mobile').val($('#guardian_alt_mobile').val());
        $('#bill_email').val($('#guardian_email').val());
        $('#bill_address').val($('#guardian_address').val());
      }else{
        $('#bill_name').val('');
        $('#bill_mobile').val('');
        $('#bill_alt_mobile').val('');
        $('#bill_email').val('');
        $('#bill_address').val('');
      }
    });   
    $('#kids').on('change', function(slick) {
      $("#noofkidit").html('');
      var $availableKids = '';
      var cild;      
      if($("#kids").val() > 0){
         for(cild=1;cild<=$("#kids").val();cild++){
           if($availableKids) {
            $("#noofkidit").append('<div class="row"><div class="col-md-4"><div class="card-body"><div class="form-group"><input type="text" id="kidname_'+cild+'" name="kidname[]" class="kidname form-control" placeholder="Kids name goes here" value="'+(typeof $availableKids['kidname'][cild] !== "undefined" ? $availableKids['kidname'][cild] : '' )+'"></div></div></div></div><div class="col-md-4"><div class="card-body"><div class="form-group"><input value="'+(typeof $availableKids['kidage'][cild] !== "undefined" ? $availableKids['kidage'][cild] : '' )+'" type="text" placeholder="Age" id="kidage_'+cild+'" name="kidage[]" class="kidage number form-control" onkeypress="return isNumberKey(event)"></div></div></div><div class="col-md-4"><div class="card-body"><div class="form-group"><select name="kidgender[]" class="kidgender form-control" id="kidgender_'+cild+'"><option '+($availableKids['kidname'][cild] == 'Boy' ? 'selected="selected"' : '')+' value="Boy">Boy</option><option '+($availableKids['kidname'][cild] == 'Girl' ? 'selected="selected"' : '')+' value="Girl">Girl</option></select></div></div></div></div>');
           } else {
            $("#noofkidit").append('<div class="row"><div class="col-md-4"><div class="card-body"><div class="form-group"><input type="text" id="kidname_'+cild+'" name="kidname[]" class="kidname form-control" placeholder="Kids name goes here"></div></div></div><div class="col-md-4"><div class="card-body"><div class="form-group"><input type="text" placeholder="Age" id="kidage_'+cild+'" name="kidage[]" class="kidage number form-control" onkeypress="return isNumberKey(event)"></div></div></div><div class="col-md-4"><div class="card-body"><div class="form-group"><select name="kidgender[]" class="kidgender form-control" id="kidgender_'+cild+'"><option value="Boy">Boy</option><option value="Girl">Girl</option></select></div></div></div></div>');
           }            
         }
      }
      applyCoupon();
   });

   $('.coupon_appy').on('click', function(slick) {
    applyCoupon();
   });
    function applyCoupon() {
      $.ajax({
            type: 'GET',
            url: '/check-coupon',
            dataType: 'json',
            data: {coupon:$('.coupon_code').val(),kids_start_from:$('#kids_start_from').val(),baseprice:$('#basepriceamt').val(),discountamt:$('#discountamt').val(),basepriceactulaamt:$('#basepriceactulaamt').val(),noofkids:$('#kids').val(),addamt:$('#addamt').val(),tax:$('#taxamt').val(),_token : '{{csrf_token()}}','booking_number': '{{isset($orderDetails) ? $orderDetails->order_number : ''}}'},
            success: function(response){
               if(response.success == true){
                  $(".discountamt").text(response.discount);
                  $("#discountamt").val(response.discount);
                  $(".addamt").html(response.addamount);                  
                  $(".addamountadmin").html(response.addamountadmin);                  
                  $(".discountedamt").text(response.discountedPrice);
                  $("#discountedamt").val(response.discountedPrice);
                  $(".adddiscountedamt").text(response.discountValue);
                  $("#adddiscountedamt").val(response.discountValue);
                  $(".totalpriceamt").text(response.totalpriceamt);
                  $("#totalpriceamt").val(response.totalpriceamt);
               }
            }
      });
   }
   $(document).on('click','.package_plan',function(slick) {     
      $('#kids_start_from').val($(this).attr('data-minkid'));
        $('.basepriceamt').html($(this).attr('data-price'));
      $('.basepriceactulaamt').html($(this).attr('data-actual-price'));
      $('.discountamt').html($(this).attr('data-actual-price')-$(this).attr('data-price'));
      $("#discountamt").val($(this).attr('data-actual-price')-$(this).attr('data-price'));
      $('#basepriceamt').val($(this).attr('data-price'));
      $('#basepriceactulaamt').val($(this).attr('data-actual-price'));
      $('#city_date_package').val($(this).val());
      $('#package_date').val($(this).attr('data-formatdate'));
      $('#package_time').val($(this).attr('data-name'));
      $('#addamt').val($(this).attr('data-kid-price'));
      $('.copuponoption').trigger("click");
      //$(".coupon_appy").trigger("click");
      applyCoupon();      
   });
   $("#choodegift_hand").on("click",function () {
    if($(this).prop('checked') == true){
      $("#giftmodal").modal();
      $('.gift-option-1').text('Santa gifts your child the gift of your choice.');
      $('#choosedgift1').val('Santa gifts your child the gift of your choice.')
    } else {
      $('.gift-option-1').text('');
      $('#choosedgift1').val('')
    }
  });

function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>
<style>
    .linethrough {text-decoration: line-through;}
</style>
@stop