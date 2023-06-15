'use strict';
// Class definition

// Class definition

var KTFormControls = function () {
    // Private functions

    var validateform = function () {
        $( "#frmAddEdit" ).validate({
            // define validation rules
            rules: {
                task: {
                    required: true
                },
                description: {
                    required: true
                },
                start_date: {
                    required: true
                },
                end_date: {
                    required: true
                },
                file: {
                    required: true
                },
                Project: {
                    required: true
                },
                features: {
                    required: true
                },
                Pryority: {
                    required: true
                },
                assignee: {
                    required: true
                },
                cycle: {
                    required: true
                },
            },
            messages: {
                'task': {
                    required: "Please select Task",
                },
                'description': {
                    required: "Please enter Description",
                },
                'start_date': {
                    required: "Please enter Start Date",
                },
                'end_date': {
                    required: "Please enter End Date",
                },
                'file': {
                    required: "Please enter Attachment"
                },
                'Project': {
                    required: "Please enter Project"
                },
                'features': {
                    required: "Please enter Features"
                },
                'Pryority': {
                    required: "Please enter Features"
                },
                'assignee': {
                    required: "Please enter Assignee"
                },
                'cycle': {
                    required: "Please enter Cycle"
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
        $("#Pryority").attr('data-id',0).trigger('change');
        $("#Project").attr('data-id',0).trigger('change');
        $("#assignee").attr('data-id',0).trigger('change');
        $("#cycle").attr('data-id',0).trigger('change');
        $("#features").attr('data-id',0).trigger('change');
    });
});