'use strict';
// Class definition

// Class definition

var KTFormControls = function () {
    // Private functions

    var validateform = function () {
        $( "#frmAddEdit" ).validate({
            // define validation rules
            rules: {
                name: {
                    required: true
                },
                manager: {
                    required: true
                },
                start_date: {
                    required: true
                },
                end_date: {
                    required: true
                },
            },
            messages: {
                'name': {
                    required: "Please enter Name",
                },
                'manager': {
                    required: "Please enter Manager Name",
                },
                'start_date': {
                    required: "Please select Start Date",
                },
                'end_date': {
                    required: "Please select End Date",
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