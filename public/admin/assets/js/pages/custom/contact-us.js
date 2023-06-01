'use strict';
// Class definition

// Class definition

var KTFormControls = function () {
    // Private functions
    $('#morning_start,#morning_start_validate').timepicker({defaultTime:"7:00:00 AM"});
    $('#morning_end,#morning_end_validate').timepicker({defaultTime:"12:00:00 PM"});
    $('#afternoon_start,#afternoon_start_validate').timepicker({defaultTime:"2:00:00 PM"});
    $('#afternoon_end,#afternoon_end_validate').timepicker({defaultTime:"4:00:00 PM"});
    $('#evening_start,#evening_start_validate').timepicker({defaultTime:"5:00:00 PM"});
    $('#evening_end,#evening_end_validate').timepicker({defaultTime:"8:00:00 PM"});
    $('#night_start,#night_start_validate').timepicker({defaultTime:"9:00:00 PM"});
    $('#night_end,#night_end_validate').timepicker({defaultTime:"11:59:59 PM"});
    var validateform = function () {
        $( "#frmAddEdit" ).validate({
            // define validation rules
            rules: {
                /*country_id: {
                    required: true,
                },
                state_id: {
                    required: true
                },*/
                name: {
                    required: true
                },
                morning_start: {
                    required: true
                },
                morning_end: {
                    required: true
                },
                afternoon_start: {
                    required: true
                },
                afternoon_end: {
                    required: true
                },
                evening_start: {
                    required: true
                },
                evening_end: {
                    required: true
                },
                night_start: {
                    required: true
                },
                night_end: {
                    required: true
                },
                status: {
                    required: true
                },
            },

            messages: {
                country_id: {
                    required: 'Please select Country'
                },
                state_id: {
                    required: 'Please select State'
                },
                name: {
                    required:'Please specify Booking',
                },
                status: {
                    required:'Please select Status'
                },
            },

            errorPlacement: function(error, element) {
                var group = element.closest('.input-group');
                if (group.length) {
                    group.after(error.addClass('invalid-feedback'));
                } else {
                    element.after(error.addClass('invalid-feedback'));
                }
            },

            //display error alert on form submit
            invalidHandler: function(event, validator) {
                var alert = $('#kt_form_1_msg');
                alert.removeClass('kt--hide').show();
                KTUtil.scrollTop();
            },

            submitHandler: function (form) {
                var timeFlag = true;
                var morning_start_time = $("#morning_start").val();
                var morning_end_time = $("#morning_end").val();
                var afternoon_start_time = $("#afternoon_start").val();
                var afternoon_end_time = $("#afternoon_end").val();
                var evening_start_time = $("#evening_start").val();
                var evening_end_time = $("#evening_end").val();
                var night_start_time = $("#night_start").val();
                var night_end_time = $("#night_end").val();

                var morning_start = new Date("November 20, 2011 " + morning_start_time);
                morning_start = morning_start.getTime();
                var morning_end = new Date("November 20, 2011 " + morning_end_time);
                morning_end = morning_end.getTime();
                if(morning_start >= morning_end) {
                    $("#morning_start").after('<div id="morning_start-error" class="error invalid-feedback">Start-time must be smaller then End-time.</div>');
                    $('#morning_start-error').show();
                    $("#morning_end").after('<div id="morning_end-error" class="error invalid-feedback">End-time must be bigger then Start-time.</div>');
                    $('#morning_end-error').show();
                    timeFlag = false;
                }

                var afternoon_start = new Date("November 20, 2011 " + afternoon_start_time);
                afternoon_start = afternoon_start.getTime();
                var afternoon_end = new Date("November 20, 2011 " + afternoon_end_time);
                afternoon_end = afternoon_end.getTime();
                if(afternoon_start >= afternoon_end) {
                    $("#afternoon_start").after('<div id="afternoon_start-error" class="error invalid-feedback">Start-time must be smaller then End-time.</div>');
                    $('#afternoon_start-error').show();
                    $("#afternoon_end").after('<div id="afternoon_end-error" class="error invalid-feedback">End-time must be bigger then Start-time.</div>');
                    $('#afternoon_end-error').show();
                    timeFlag = false;
                }

                var evening_start = new Date("November 20, 2011 " + evening_start_time);
                evening_start = evening_start.getTime();
                var evening_end = new Date("November 20, 2011 " + evening_end_time);
                evening_end = evening_end.getTime();
                if(evening_start >= evening_end) {
                    $("#evening_start").after('<div id="evening_start-error" class="error invalid-feedback">Start-time must be smaller then End-time.</div>');
                    $('#evening_start-error').show();
                    $("#evening_end").after('<div id="evening_end-error" class="error invalid-feedback">End-time must be bigger then Start-time.</div>');
                    $('#evening_end-error').show();
                    timeFlag = false;
                }

                var night_start = new Date("November 20, 2011 " + night_start_time);
                night_start = night_start.getTime();
                var night_end = new Date("November 20, 2011 " + night_end_time);
                night_end = night_end.getTime();
                if(night_start >= night_end) {
                    $("#night_start").after('<div id="night_start-error" class="error invalid-feedback">Start-time must be smaller then End-time.</div>');
                    $('#night_start-error').show();
                    $("#night_end").after('<div id="night_end-error" class="error invalid-feedback">End-time must be bigger then Start-time.</div>');
                    $('#night_end-error').show();
                    timeFlag = false;
                }

                if(timeFlag == false){
                    return false;
                }

                form.submit(); // submit the form
            }
        });
    }

    return {
        // public functions
        init: function() {
            validateform();
        }
    };
}();

jQuery(document).ready(function() {
    KTFormControls.init();
    $("#reset").click(function () {
        $(':input', '#frmAddEdit').not(':button, :submit, :reset, :hidden').val('').prop('checked', false).prop('selected', false);
        $("#status").val('1').trigger('change');
    });
});


function getStates(sel){
    alert(sel.value);
	var csrf_token=	document.getElementById("_token").val;
	console.log(csrf_token);
	$.ajax({
                type:'POST',
                url:'getStates',
                data:{'country_id':+sel.value,"_token": csrf_token},
                success:function(data){
                    $('#state').html('<option value="">Select State</option>'); 
                    var dataObj = jQuery.parseJSON(data);
                    if(dataObj){
                        $(dataObj).each(function(){
                            var option = $('<option />');
                            option.attr('value', this.id).text(this.name);           
                            $('#state').append(option);
                        });
                    }else{
                        $('#state').html('<option value="">State not available</option>');
                    }
                }
            }); 
}