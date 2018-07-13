jQuery(document).ready(function() {    
    $( "#submit_form" ).validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
          rules: {
            item_name: {
                required: true,
            },
            description: {
                required:true,
            },
            qty: {
                required:true,
                 number : true,
            },
            request_expired: {
                required:true,
            },
            budget_unit_min: {
                required:true,
                number : true,
            },
            budget_unit_max: {
                required:true,
                number : true,
            },
            photo: {
                required:true,
            }
          },
       
         

        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },

        unhighlight: function (element) { // revert the change done by hightlight
            $(element)
                .closest('.form-group').removeClass('has-error'); // set error class to the control group
        },

        success: function (label) {
            label
                .closest('.form-group').removeClass('has-error'); // set success class to the control group
        },
    }),

    $(".form_datetime").datetimepicker({
        autoclose: true,
        isRTL: App.isRTL(),
        format: "yyyy-mm-dd  hh:ii:ss",
        fontAwesome: true,
        pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left")
    });
    
});
