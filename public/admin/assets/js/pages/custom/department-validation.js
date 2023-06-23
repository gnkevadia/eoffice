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
                description: {
                    required: true
                },
                business_id: {
                    required: true
                },
                company_id: {
                    required: true
                },
                manager: {
                    required: true
                },
            },
            messages: {
                'name': {
                    required: "Please select Department Name",
                },
                'description': {
                    required: "Please enter description",
                },
                'business_id': {
                    required: "Please enter Business Name",
                },
                'company_id': {
                    required: "Please enter Company Name",
                },
                'manager': {
                    required: "Please enter Manager Name",
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
        $("#business").attr('data-id',0).trigger('change');
    });
});