jQuery(document).ready(function() {
   
    var province_list = null;
    var city_list = null;
    var courier_list = null;
    var province_input = $("select[name='province']");
    var city_input = $("select[name='city']");
    var courier_input = $("#courier_input");

     var province_value = document.querySelector('input[name="province"]');
    var city_value = document.querySelector('input[name="city"]');


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
                        '<label><input type="checkbox" class="icheck" name="courier[]" data-title="' + value.courier_name +  '" value="' + value.courier_id + '">' + value.courier_name + '</label>'
                );
            });
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue'
            });
        },
        error: function() {
            alert('Error occured');
        }
    });
});