'use strict';
// Class definition

// Class definition

var KTFormControls = function () {
    // Private functions
    //$('#morning_start,#morning_start_validate').timepicker({defaultTime:"7:00:00 AM"});
    var validateform = function () {
        $( "#frmAddEdit" ).validate({
            // define validation rules
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email:true
                },
                mobile: {
                    required: true
                },
                address: {
                    required: true
                },
                city_id: {
                    required: true
                },
                executive_type: {
                    required: true
                },
                username: {
                    required: true,
                    email:true
                },
                status: {
                    required: true
                },
            },

            messages: {
                name: {
                    required:'Please specify name'
                },
                email: {
                    required:'Please specify email'
                },
                mobile: {
                    required:'Please specify mobile'
                },
                city_id: {
                    required:'Please select city'
                },
                address: {
                    required:'Please specify address'
                },
                executive_type: {
                    required:'Please select executive type'
                },
                username: {
                    required:'Please specify username',
                    email:'Please specify valid email',
                },
                status: {
                    required:'Please select status'
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