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
                country_id: {
                    required: true,
                },
                city_id: {
                    required: true,
                },
                name: {
                    required: true
                },
                current_city_of_residence:{
                    required: true
                },
                current_city_residential_address:{
                    required:true
                },
                available_date_from: { 
                    required: true 
                },
                visa_status:{   
                    required:true
                },
                foreign_country:{
                    required:true
                },
                status: {
                    required: true
                },
            },

            messages: {
                country_id: {
                    required: 'Please select Country'
                },
                city_id: {
                    required: 'Please select City'
                },
                name: {
                    required:'Please specify Name of Santa',
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