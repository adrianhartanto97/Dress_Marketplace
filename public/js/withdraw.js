jQuery(document).ready(function() {    
    $( "#form1" ).validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
          rules: {
            amount: {
                required: true,
                number  : true,
                min : 50000
            },
            bank_name: {
                required: true
            },
            account_number: {
                required: true,
                number : true
            },
            branch: {
                required: true
            },
            name_in_account: {
                required: true
            },
            password: {
                required: true,
                
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

    var input_year = $("input[name='year']");
    var input_month = $("input[name='month']");


    var date = $("select[name='date']").val();
    var year="";
    var month="";
    for(var i=0 ; i<=3;i++){
        year+=date[i];
    }
    for(var i=5 ; i<=6;i++){
        month+=date[i];
    }

      date.change(function() {
        $.ajax({
            type:"POST",
            url : "http://localhost/dress_marketplace/api/financial_history",
            async: false,
             data: {
                token : jwt,
                year: year,
                month:month
            },
            success : function(response) {
                input_year.val() = year;
                input_month.val() = month;

               
            },
            error: function() {
                alert('Error occured');
            }
        });
    });

    

    App.unblockUI();
    
});



