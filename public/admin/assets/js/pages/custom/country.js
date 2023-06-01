'use strict';
// Class definition

// Class definition

var KTFormControls = function () {
    // Private functions

    var validateform = function () {
        $( "#frmAddEdit" ).validate({
            // define validation rules
            rules: {
                nicename: {
                    required: true,
                },
                iso: {
                    required: true
                },
                phonecode: {
                    required: true
                },
                flag_img:{
                    required: true,
                    accept: 'png'
                },
                status: {
                    required: true
                },
            },

            messages: {
                nicename: {
                    required: 'Please specify Country'
                },
                iso: {
                    required:'Please specify ISO',
                },
                phonecode: {
                    required:'Please specify Phonecode',
                },
                flag_img: {
                    required:'Please select Image',
                    accept: 'Only image type png is allowed'
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