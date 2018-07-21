$( document ).ready(function() {
    $(".my-rating").starRating({
        starSize: 25,
        readOnly: true,   
    });
});

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

     var style = document.createElement('link');
     style.href = filename;
     style.type = 'text/css';
     style.rel = 'stylesheet';
     head.append(style);
}
       
       
jQuery(document).ready(function() {
    var sort_by = $("select[name='sort_by']");
    var all_product= $("div[name='list']");
    var product_list = null;
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
  
   sort_by.change(function() {
        all_product.empty();

        $.ajax({
            type:"POST",
            url : "http://localhost/dress_marketplace/api/get_sort_by_id_store",
            data : {
                sort_id : $(this).val(),
                store_id : $("input[type=text][name=id_store]" ).val()
            },
            async: false,
            success : function(response) {
                product_list = response.product_info;
                $.each(product_list, function(index, value) {   
                 addCSS('public/star-rating-svg-master/src/css/star-rating-svg.css');       
                    all_product.append(
                        $('<a href="http://localhost/dress_marketplace/product_detail/'+value.product_id+'" target="_blank" style="text-decoration:none;position:left;"></a>').val(value.product_id).html(
                            "<div class='col-xs-6 col-sm-4 col-md-3'>" + 
                            "<div class='thumbnail'>"+
                                '<img src="http://localhost/dress_marketplace/public/storage/' + value.photo + '" style="width: 100%; height: 35%;">'+
                                "<div class='caption' style='text-align:center;'>"+
                                    " <h4>"+value.product_name+"</h4>"+
                                    " <h3> IDR "+value.max_price+"</h3>"+
                                    " <p>" +
                                    '<a class="my-rating satu" data-rating="'+value.average_rating+'"></a>'+
                                    "</p>"+
                                "</div>"+
                            value.average_rating+
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
set_range_slider_value($("#range_26"),$("#price_min"),$("#price_max"),0,10000,10000000,0,0,3);






