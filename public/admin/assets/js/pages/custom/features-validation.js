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
                Project: {
                    required: true
                },
                priority: {
                    required: true
                },
                company_id: {
                    required: true
                },
                department_id: {
                    required: true
                },
                manager: {
                    required: true
                },
            },
            messages: {
                'name': {
                    required: "Please select Features Name",
                },
                'description': {
                    required: "Please enter description",
                },
                'Project': {
                    required: "Please Select Project",
                },
                'priority': {
                    required: "Please Select Priority",
                },
                'company_id': {
                    required: "Please Select Company Name",
                },
                'department_id': {
                    required: "Please Select Department Name",
                },
                'manager': {
                    required: "Please Select Manager Name",
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
        $("#Project").attr('data-id',0).trigger('change');
        $("#priority").attr('data-id',0).trigger('change');
        $("#company").attr('data-id',0).trigger('change');
        $("#department").attr('data-id',0).trigger('change');
        $("#manager").attr('data-id',0).trigger('change');
    });
});