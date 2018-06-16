var FormRepeater = function () {

    return {
        //main function to initiate the module
        init: function () {
        	$('.mt-repeater').each(function(){
                $(this).repeater({
        			show: function () {
	                	$(this).slideDown();
                        $('.max_button').click(function() {
                            $(this).parent().parent().find("input").val("max");
                        });
                        
                        var current = parseInt($(this).prev().find("input.qty_max").val()) + 1;
                        $(this).find("input.qty_min").val(current);
		            },

		            hide: function (deleteElement) {
		                if(confirm('Are you sure you want to delete this price range?')) {
		                    $(this).slideUp(deleteElement);
		                }
		            },

		            ready: function (setIndexes) {

		            }

        		});
        	});
        }

    };

}();

jQuery(document).ready(function() {
    FormRepeater.init();
    
    var min_order = 0;
    $( "input[name='min_order']" ).on("change paste keyup", function() {
        min_order = $(this).val();
        $( "input[name='price_range[0][qty_min]']" ).val(min_order).attr('readonly',true);
    });
    
    $('.max_button').click(function() {
        $(this).parent().parent().find('input').val("max");
    });
    
    $( "#submit_form" ).validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
          rules: {
            name: {
                required: true
            },
            min_order: {
                required: true,
                number : true
            },
            weight: {
                required: true,
                number : true
            },
            description: {
                required: true
            },
            photo: {
                required: true
            },
            'size[]': {
                required: true
            }
          },
        messages: {
            'size[]': "Please select at least 1 size"
        },
         errorPlacement: function (error, element) { // render error placement for each input type
                var cont = $(element).parent('.input-group');
                if (cont.size() > 0) {
                    cont.after(error);
                } else {
                    element.after(error);
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
    });
    
});
