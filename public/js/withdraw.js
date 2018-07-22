jQuery(document).ready(function() {    
    $( "#withdraw" ).validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
          rules: {
            amount: {
                required: true,
                number  : true,
                min : 10000
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
});

function reload() {
  localStorage.setItem('selectedVal',$('#date').val());
  location.reload(true);
}

$( document ).ready(function() {
    var selectedVal = localStorage.getItem('selectedVal');
    if (selectedVal){
       $('#date').val(selectedVal)
    }
   
});



