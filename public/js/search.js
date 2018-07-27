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
    App.blockUI({
        boxed: true
    });
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
                    all_product.append(
                        $('<a href="product_detail/'+value.product_id+'" target="_blank" style="text-decoration:none;position:left;"></a>').val(value.product_id).html(
                            "<div class='col-xs-6 col-sm-4 col-md-3 center'>" + 
                            "<div class='thumbnail'>"+
                                '<img src="./public/storage/' + value.photo + '" style="width: 100%; height: 170px;">'+
                                '<div style="height:60px;">'+

                                    '<h4 class="black">'+
                                    (value.product_name.length>=50 ?
                                        value.product_name.substr(0,50)+'...':
                                        value.product_name.substr(0,50)

                                        )+
                                    '</h4>'+
                                '</div>'+
                                    " <b> "+value.store_name+"</b>"+
                                    // " <br><b> "+value.recommendation+"</b>"+

                                    " <h3> IDR "+value.max_price+"</h3>"+
                                    '<p class="my-rating" data-rating="3">'+
                                     (value.average_rating == 0 ?
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<br>' :
                                     (value.average_rating==1 ? 
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+

                                        '<br>':
                                    (value.average_rating==2 ? 
                                         '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<br>':
                                     (value.average_rating==3 ? 
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<br>':
                                        //4
                                     (value.average_rating==4 ? 
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-301{fill:url(#301_SVGID_1_);}.svg-hovered-301{fill:url(#301_SVGID_2_);}.svg-active-301{fill:url(#301_SVGID_3_);}.svg-rated-301{fill:crimson;}</style><linearGradient id="301_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="301_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="301_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-empty-301" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-empty-301" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<br>':         

                                       
                                        //5
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<div class="jq-star" style="width:25px;  height:25px;"><svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve"><style type="text/css">.svg-empty-181{fill:url(#181_SVGID_1_);}.svg-hovered-181{fill:url(#181_SVGID_2_);}.svg-active-181{fill:url(#181_SVGID_3_);}.svg-rated-181{fill:crimson;}</style><linearGradient id="181_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:lightgray"></stop><stop offset="1" style="stop-color:lightgray"></stop> </linearGradient><linearGradient id="181_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:orange"></stop><stop offset="1" style="stop-color:orange"></stop> </linearGradient><linearGradient id="181_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250"><stop offset="0" style="stop-color:#FEF7CD"></stop><stop offset="1" style="stop-color:#FF9511"></stop> </linearGradient><polygon data-side="center" class="svg-empty-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon><polygon data-side="left" class="svg-active-181" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon><polygon data-side="right" class="svg-active-181" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon></svg></div>'+
                                        '<br>'))))) +

                                    '</p>'+
                                "</div>"+
                            "</div>"+
                            "</div>"
                             

                        )
                    );

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

App.unblockUI();
    
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


var yourString = "The quick brown fox jumps over the lazy dog"; //replace with your string.
var maxLength = 6 // maximum number of characters to extract

//trim the string to the maximum length
var trimmedString = yourString.substr(0, maxLength);

//re-trim if we are in the middle of a word
trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")))