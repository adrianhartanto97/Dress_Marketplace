var store_availability = $('#store_availability');
var FormWizard = function () {
    var jwt = $('#field').data("field-id");

    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }

            function format(state) {
                if (!state.id) return state.text; // optgroup
                return "<img class='flag' src='../../assets/global/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
            }

            $("#country_list").select2({
                placeholder: "Select",
                allowClear: true,
                formatResult: format,
                width: 'auto', 
                formatSelection: format,
                escapeMarkup: function (m) {
                    return m;
                }
            });

            var form = $('#submit_form');
            var error = $('#alert_error', form);
            var success = $('.alert-success', form);

            form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    //choose address
                    receiver_name: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    province: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    phone_number: {
                        required: true
                    },

                    //store information
                    business_type: {
                        required: true
                    },
                    established_year: {
                        required: true,
                    },
                    province: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    
                    //store bank
                    bank_name: {
                        required: true
                    },
                    branch: {
                        required: true
                    },
                    bank_account_number: {
                        required: true
                    },
                    name_in_bank_account: {
                        required: true
                    },

                    //courier service
                    courier_service: {
                        required: true
                    }
                },

                messages: { // custom messages for radio buttons and checkboxes
                    'payment[]': {
                        required: "Please select at least one option",
                        minlength: jQuery.validator.format("Please select at least one option")
                    }
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.attr("name") == "gender") { // for uniform radio buttons, insert the after the given container
                        error.insertAfter("#form_gender_error");
                    } else if (element.attr("name") == "payment[]") { // for uniform checkboxes, insert the after the given container
                        error.insertAfter("#form_payment_error");
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success.hide();
                    error.show();
                    App.scrollTo(error, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    if (label.attr("for") == "gender" || label.attr("for") == "payment[]") { // for checkboxes and radio buttons, no need to show OK icon
                        label
                            .closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove(); // remove error label here
                    } else { // display success icon for other inputs
                        label
                            .addClass('valid') // mark the current input as valid and display OK icon
                        .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    }
                },

                submitHandler: function (form) {
                    success.show();
                    error.hide();
                    form[0].submit();
                    //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
                }

            });

            var displayConfirm = function() {
                $('#tab4 .form-control-static', form).each(function(){
                    var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                    if (input.is(":radio")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
                    if (input.is(":text") || input.is("textarea")) {
                        $(this).html(input.val());
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio") && input.is(":checked")) {
                        $(this).html(input.attr("data-title"));
                    } else if ($(this).attr("data-display") == 'courier[]') {
                        var courier = [];
                        $('[name="courier[]"]:checked', form).each(function(){ 
                            courier.push($(this).attr('data-title'));
                        });
                        $(this).html(courier.join("<br>"));
                    }
                });
            }

            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                    displayConfirm();
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                App.scrollTo($('.page-title'));
            }

            // default form wizard
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    return false;
                    
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    
                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    if (form.valid() == false) {
                        return false;
                    }
                    
                    if (index == 1) {
                        App.blockUI({
                            boxed: true
                        });
                        $.ajax({
                            url: "http://localhost/dress_marketplace/checkout_courier_page",
                            data : {
                                destination_city : $("select[name='city']").val()
                            },
                            dataType: 'html',
                            success: function(html) {
                                $('#tab2_container').html(html);
                                $(".courier_select").each(function() {
//                                    var opt = this.options[this.selectedIndex];
//                                    var courier_id = opt.getAttribute("data-courier-id");
//                                    var store_id = this.getAttribute("data-store-id");
//                                    
//                                    $('#courier_id_'+store_id).val(courier_id);
                                    $( this ).trigger('change');
                                });
                                App.unblockUI();
                            }
                        });
                    }
                    
                    else if (index == 2) {
                        var total_shipping_price = 0;
                        
                        $(".courier_select").each(function() {
                            total_shipping_price += parseInt($(this).val());
                        });
                        
                        var total_price = subtotal_price + total_shipping_price;
                        global_total_price = total_price;
                        
                        $('#total_price').text('Total Price : IDR ' + total_price.toLocaleString());
                        $('#subtotal_price').text('SubTotal Price : IDR ' + subtotal_price.toLocaleString());
                        $('#shipping_price').text('Shipping Price : IDR ' + total_shipping_price.toLocaleString());
                        $('#available_points').text('IDR ' + balance.toLocaleString());
                    }

                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });

            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').hide();

            //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('#country_list', form).change(function () {
                form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
        }

    };

}();

jQuery(document).ready(function() {
    
    FormWizard.init();

    var province_input = $("select[name='province']");
    var city_input = $("select[name='city']");
    
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
    });
    province_input.trigger('change');
    //$('#form_wizard_1').bootstrapWizard('show',1);
    //$("#tab2_click").trigger('click');
});
