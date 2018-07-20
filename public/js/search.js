$( document ).ready(function() {
            $(".my-rating").starRating({
                starSize: 25,
                readOnly: true,   
            });
        });
       
       
jQuery(document).ready(function() {
    var province_list = null;
    var city_list = null;
    var courier_list = null;
    var province_input = $("select[name='province']");
    var city_input = $("select[name='city']");
    var courier_input = $("select[name='shipping']");
    var sort_by = $("select[name='sort_by']");
    var all_product= $("div[name='list']");
    var product_list = null;
    var province_value = document.querySelector('input[name="province"]');
    var city_value = document.querySelector('input[name="city"]');
    var courier_value = document.querySelector('input[name="courier_id"]');

    $.ajax({
        type:"POST",
        url : "http://localhost/dress_marketplace/api/get_province_list",
        async: false,
        success : function(response) {
            province_list = response.province;
            $.each(province_list, function(index, value) {          
                province_input.append(
                    $('<option></option>').val(value.province_id).html(value.province_name)
                );
            });

        },
        error: function() {
            alert('Error occured');
        }
    });

    

    province_input.change(function() {
        city_input.empty();
        $.ajax({
            type:"POST",
            url : "http://localhost/dress_marketplace/api/get_city_by_province",
            data : {
                province_id : $(this).val()
            },
            async: false,
            success : function(response) {
                city_list = response.city;
                $.each(city_list, function(index, value) {          
                    city_input.append(
                        $('<option></option>').val(value.city_id).html(value.city_type+" "+value.city_name)
                    );

                });
            },
            error: function() {
                alert('Error occured');
            }
        });

         var selected = $("select[name='province'] option:selected").val();
        province_value.value=selected;
       

    });


    province_input.trigger('change');

    city_input.change(function() {
        var selected2 = $("select[name='city'] option:selected").val();
        city_value.value=selected2;
    });
    city_input.trigger('change');




    $.ajax({
        type:"POST",
        url : "http://localhost/dress_marketplace/api/get_courier_list",
        async: false,
        success : function(response) {
            courier_list = response.courier;
            $.each(courier_list, function(index, value) {          
                courier_input.append(
                    $('<option></option>').val(value.courier_id).html(value.courier_name)
                );
            });
           
        },
        error: function() {
            alert('Error occured');
        }
    });

    
    courier_input.change(function() {
        var selected2 = $("select[name='shipping'] option:selected").val();
        courier_value.value=selected2;
    });
    courier_input.trigger('change');

   
    App.unblockUI();
});

 
//RAnge 25  
 

function set_range_slider_value($range, $from,$to,range,min,max,from,to,num)
{
   
    var updateValues = function () {
        $from.prop("value", from);
        $to.prop("value", to);
    };

    $range.ionRangeSlider({
        type: "double",
        min: min,
        max: max,
        prettify_enabled: false,
        grid: true,
        grid_num: num,
        onChange: function (data) {
            from = data.from;
            to = data.to;
            
            updateValues();
        }
    });

    range = $range.data("ionRangeSlider");

    var updateRange = function () {
        range.update({
            from: from,
            to: to
        });
    };

    $from.on("change", function () {
        from = +$(this).prop("value");
        if (from < min) {
            from = min;
        }
        if (from > to) {
            from = to;
        }

        updateValues();    
        updateRange();
    });

    $to.on("change", function () {
        to = +$(this).prop("value");
        if (to > max) {
            to = max;
        }
        if (to < from) {
            to = from;
        }

        updateValues();    
        updateRange();
    });

}

set_range_slider_value($("#range_25"),$("#rating_min"),$("#rating_max"),0,0,5,0,0,4);
set_range_slider_value($("#range_26"),$("#price_min"),$("#price_max"),0,10000,50000000,0,0,4);






