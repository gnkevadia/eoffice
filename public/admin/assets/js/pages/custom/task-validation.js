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
                priority: {
                    required: true
                },
                assignee: {
                    required: true
                },
                cycle: {
                    required: true
                },
                hour_task: {
                    required: true
                },
                company_id: {
                    required: true
                },
                status: {
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
                'priority': {
                    required: "Please enter Priority"
                },
                'assignee': {
                    required: "Please enter Assignee"
                },
                'cycle': {
                    required: "Please enter Cycle"
                },
                'hour_task': {
                    required: "Please enter Hour of Task"
                },
                'company_id': {
                    required: "Please enter Company Name"
                },
                'status': {
                    required: "Please enter Status"
                },
                'department_id': {
                    required: "Please enter Department Name"
                },
                'manager': {
                    required: "Please enter Manager Name"
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
        $("#status").attr('data-id',0).trigger('change');
        $("#priority").attr('data-id',0).trigger('change');
        $("#Project").attr('data-id',0).trigger('change');
        $("#assignee").attr('data-id',0).trigger('change');
        $("#cycle").attr('data-id',0).trigger('change');
        $("#features").attr('data-id',0).trigger('change');
        $("#company").attr('data-id',0).trigger('change');
    });
});