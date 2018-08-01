$( document ).ready(function() {
    $(".my-rating").starRating({
        starSize: 25,
        readOnly: true,   
    });
});


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
set_range_slider_value($("#range_26"),$("#price_min"),$("#price_max"),0,10000,10000000,0,0,3);



jQuery(document).ready(function() {
  
  
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
   
    localStorage.clear();

App.unblockUI();
    
});

 
function reload() {
  localStorage.setItem('min_order',$("input[name='min_order']").val());
  localStorage.setItem('price_min',$("input[name='price_min']").val());
  localStorage.setItem('price_max',$("input[name='price_max']").val());
  localStorage.setItem('rating_min',$("input[name='rating_min']").val());
  localStorage.setItem('rating_max',$("input[name='rating_max']").val());
  location.reload(true);
}