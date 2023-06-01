'use strict';
// Class definition

// Class definition

var KTFormControls = function () {
    // Private functions
    var arrows;
    if (KTUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }
    $('#kt_datepicker_date, #kt_datepicker_date_validate').datepicker({
        rtl: KTUtil.isRTL(),
        todayHighlight: true,
        orientation: "bottom left",
        templates: arrows
    });

    $('#kt_timepicker_time,#kt_timepicker_time_validate').timepicker();
    $('#kt_select2_faq_ids, #kt_select2_faq_ids_validate').select2({
        placeholder: "Select FAQs"
    });
    $('#kt_select2_inclusion_ids, #kt_select2_inclusion_ids_validate').select2({
        placeholder: "Select Inclusion"
    });
    tinymce.init({
        selector: '#kt_ckeditor_description',
        toolbar: false,
        statusbar: false
    });    
    var ignore = '';
    if(typeof $('#file_exist').val() !== "undefined"){
        ignore = "#customFile";
    }
    var validateform = function () {
        $( "#frmAddEdit" ).validate({
            // define validation rules
            ignore: ignore,

            rules: {
                name: {
                    required: true,
                },
                /*heading: {
                    required: true,
                },*/
                /*description: {
                    required: true,
                },
                file: {
                    required: true,
                    accept: 'mp4,png'
                },
                activity_time: {
                    required: true,
                },*/
                // price: {
                //     required: true,
                // },
                /*order: {
                    required: true,
                },
                terms: {
                    required: true,
                }*/
            },

            messages: {
                name: {
                    required: 'Please specify Package'
                },
                /*description: {
                    required: 'Please specify Description'
                },*/
                /*file: {
                    required:'Please select Image/Video',
                    accept: 'Only image/video type png,mp4 is allowed'
                },
                activity_time: {
                    required: 'Please specify Activity Time',
                },*/
                // price: {
                //     required: 'Please specify Price',
                // },
                /*order: {
                    required: 'Please specify Order',
                },
                terms: {
                    required: 'Please specify Terms',
                },
                status: {
                    required:'Please select Status'
                },*/
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
                // adding rules for inputs with class 'comment'
                var timeFlag = true;
                $('select.cityselection').each(function() {
                    if($(this).val() == ''){
                        $(this).after('<div id="'+$(this).attr('id')+'-error" class="error invalid-feedback">Please select City</div>');
                        $('#'+$(this).attr('id')+'-error').show();
                        timeFlag = false;
                    }else{
                        $('#'+$(this).attr('id')+'-error').hide();
                    }
                });
                $('select.multiplearea').each(function() {
                    if($(this).val() == ''){
                        $(this).parent().find(".selectmultiplearea").after('<div id="'+$(this).attr('id')+'-error" class="error invalid-feedback">Please select Area</div>');
                        $('#'+$(this).attr('id')+'-error').show();
                        timeFlag = false;
                    }else{
                        $('#'+$(this).attr('id')+'-error').hide();
                    }
                });
                
                $('input.packagedate').each(function() {
                    if($(this).val() == ''){
                        $(this).after('<div id="'+$(this).attr('id')+'-error" class="error invalid-feedback">Please specify Pacakge Date</div>');
                        $('#'+$(this).attr('id')+'-error').show();
                        timeFlag = false;
                    }else{
                        $('#'+$(this).attr('id')+'-error').hide();
                    }
                    if($('#morning_actual_price'+$(this).attr('data-unique')).val() == ''){
                        $('#morning_actual_price'+$(this).attr('data-unique')).after('<div id="'+'morning_actual_price'+$(this).attr('data-unique')+'-error" class="error invalid-feedback">Please specify Actual Price</div>');
                        $('#morning_actual_price'+$(this).attr('data-unique')+'-error').show();
                        timeFlag = false;
                    }else{
                        $('#morning_actual_price'+$(this).attr('data-unique')+'-error').hide();
                    }
                    if($('#morning_discount_price'+$(this).attr('data-unique')).val() == ''){
                        $('#morning_discount_price'+$(this).attr('data-unique')).after('<div id="'+'morning_discount_price'+$(this).attr('data-unique')+'-error" class="error invalid-feedback">Please specify Discount Price</div>');
                        $('#morning_discount_price'+$(this).attr('data-unique')+'-error').show();
                        timeFlag = false;
                    }else{
                        $('#morning_discount_price'+$(this).attr('data-unique')+'-error').hide();
                    }
                    if($('#morning_traveling_time'+$(this).attr('data-unique')).val() == ''){
                        $('#morning_traveling_time'+$(this).attr('data-unique')).after('<div id="'+'morning_traveling_time'+$(this).attr('data-unique')+'-error" class="error invalid-feedback">Please specify Traveling Time</div>');
                        $('#morning_traveling_time'+$(this).attr('data-unique')+'-error').show();
                        timeFlag = false;
                    }else{
                        $('#morning_traveling_time'+$(this).attr('data-unique')+'-error').hide();
                    }
                });

                // prevent default submit action         
                //event.preventDefault();
                if(timeFlag == false){
                    return false;
                }else{
                    form.submit(); // submit the form
                }
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
    // Remove element
	$('.dynamicElements').on('click','.remove',function(){
		
		var id = this.id;
		var split_id = id.split("_");
		var deleteindex = split_id[1];
		
		// Remove <div> with id
		$("#div_" + deleteindex).remove();
	});
});