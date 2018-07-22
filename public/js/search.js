function set_range_slider_value($range, $from,$to,range,min,max,from,to,num,from_input,to_input)
{
   
    var updateValues = function () {
        $from.prop("value", from);
        $to.prop("value", to);
    };

    $range.ionRangeSlider({
        type: "double",
        min: min,
        max: max,
        from:from_input,
        to:to_input,
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





// Include script file
function addScript(filename){
     var head = document.getElementsByTagName('head')[0];

     var script = document.createElement('script');
     script.src = filename;
     script.type = 'text/javascript';

     head.append(script);
}

function addCSS(filename){
     var head = document.getElementsByTagName('head')[0];

     var style = document.createElement('style');
     style.href = filename;
     style.type = 'text/css';
     style.rel = 'stylesheet';
     head.append(style);
}
       
       
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
                var selected = $("select[name='province'] option:selected").val();
                province_value.value=selected;
                var selected2 = $("select[name='city'] option:selected").val();
                city_value.value=selected2;
              

            },
            error: function() {
                alert('Error occured');
            }
        });
    });


    province_input.trigger('change');

    city_input.change(function() {
        var selected2 = $("select[name='city'] option:selected").val();
        city_value.value=selected2;
    });



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

    $.ajax({
        type:"POST",
        url : "http://localhost/dress_marketplace/api/get_sort_by_list",
        async: false,
        success : function(response) {
            product_list = response.sort;
            $.each(product_list, function(index, value) {          
                sort_by.append(
                    $('<option></option>').val(value.sort_id).html(value.sort_name)
                );
            });


        },
        error: function() {
            alert('Error occured');
        }
    });
    courier_input.trigger('change');
  
   sort_by.change(function() {
        all_product.empty();
       
           
        $.ajax({
            type:"POST",
            url : "http://localhost/dress_marketplace/api/get_sort_by_id",
            data : {
                sort_id : $(this).val()
            },
            async: false,
            success : function(response) {

                product_list = response.product_info;
                $.each(product_list, function(index, value) {   
                 addCSS('public/star-rating-svg-master/src/css/star-rating-svg.css');       
                    all_product.append(
                        $('<a href="product_detail/'+value.product_id+'" target="_blank" style="text-decoration:none;position:left;"></a>').val(value.product_id).html(
                            "<div class='col-xs-6 col-sm-4 col-md-3'>" + 
                            "<div class='thumbnail'>"+
                                '<img src="./public/storage/' + value.photo + '" style="width: 100%; height: 35%;">'+
                                "<div class='caption' style='text-align:center;'>"+
                                    " <h4>"+value.product_name+"</h4>"+
                                    " <h3> IDR "+value.max_price+"</h3>"+
                                    " <p>" +
                                    '<a class="my-rating satu" data-rating="'+value.average_rating+'"></a>'+
                                    "</p>"+
                                "</div>"+
                            value.average_rating+" "+
                            "</div>"+
                            "</div>"
                             

                        )
                    );
                    addScript('public/star-rating-svg-master/src/jquery.star-rating-svg.js');

                });
            },
            error: function() {
                alert('Error occured');
            }
        });

      

    });
    if (localStorage.getItem("rating_min") === null || localStorage.getItem("rating_max") === null) {
        set_range_slider_value($("#range_25"),$("#rating_min"),$("#rating_max"),0,0,5,0,5,4,0,5);

    }

    if (localStorage.getItem("price_min") === null || localStorage.getItem("price_max") === null) {
         set_range_slider_value($("#range_26"),$("#price_min"),$("#price_max"),0,10000,10000000,0,0,3,10000,10000000);

    }


   var min_order = localStorage.getItem('min_order');
   var price_min = localStorage.getItem('price_min');
   var price_max = localStorage.getItem('price_max');
   var rating_min = localStorage.getItem('rating_min');
   var rating_max= localStorage.getItem('rating_max');

    var province = localStorage.getItem('province');
    var city = localStorage.getItem('city');
    var shipping = localStorage.getItem('shipping');
    if(min_order){
        $("input[name='min_order']").val(min_order);
    }
    if(price_min || price_max){
        $("input[name='price_min']").val(price_min);
        $("input[name='price_max']").val(price_max);
        set_range_slider_value($("#range_26"),$("#price_min"),$("#price_max"),0,10000,10000000,0,0,3,price_min,price_max);



    }
  
    if(rating_max || rating_min){
        $("input[name='rating_max']").val(rating_max);
        $("input[name='rating_min']").val(rating_min);
        set_range_slider_value($("#range_25"),$("#rating_min"),$("#rating_max"),0,0,5,0,5,4,rating_min,rating_max);

       
    }
    if (province){
       $("select[name='province']").val(province);
       province_input.trigger('change');
    }
    if (city){
       $("select[name='city']").val(city);
    }
    if (shipping){
      $("select[name='shipping']").val(shipping)
    }
    localStorage.clear();


    
});

 
function reload() {
  localStorage.setItem('min_order',$("input[name='min_order']").val());
  localStorage.setItem('price_min',$("input[name='price_min']").val());
  localStorage.setItem('price_max',$("input[name='price_max']").val());
  localStorage.setItem('rating_min',$("input[name='rating_min']").val());
  localStorage.setItem('rating_max',$("input[name='rating_max']").val());
  localStorage.setItem('province',$("select[name='province']").val());
  localStorage.setItem('city',$("select[name='city']").val());
  localStorage.setItem('shipping',$("select[name='shipping']").val());
  location.reload(true);
}

$( document ).ready(function() {
    $(".my-rating").starRating({
        starSize: 25,
        readOnly: true,   
    });

   
   

});

