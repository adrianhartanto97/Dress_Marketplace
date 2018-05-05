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
    
});
