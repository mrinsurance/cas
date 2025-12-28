// Date picker calander
$( "#maturity_date_cal, #matured_on_date_cal, #old_matured_on_date_cal, #date_of_cheque").datepicker({
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      yearRange: "-100:+15",
    });
// Interest Run From
    $( "#int_from_date" ).datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+15",
        onClose: function() {
            var date2 = $('#int_from_date').datepicker('getDate');
            date2.setMonth(date2.getMonth())
            $( "#int_on_date" ).datepicker("setDate", date2);
            $("#month_of_period").val('');
        }
    });
    $( "#int_on_date" ).datepicker({
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
    });

// Mode of Transaction
  $('input[type=radio][name=mode_of_transaction]').change(function() {
    if (this.value == 'Cash') {
        $('#cheque_mode').addClass('hide');
        $('input[type=text][name=cheque_number]').attr('disabled', true);
        $('input[type=text][name=cheque_date]').attr('disabled', true);
      
      var type_of_transaction = $("input[name='type_of_transaction']:checked").val();
      // alert(type_of_transaction);
      $('textarea#trans_particular').html(type_of_transaction+" by Cash");
    }
    else if (this.value == 'Cheque') {
        $('#cheque_mode').removeClass('hide');
        $('input[type=text][name=cheque_number]').attr('disabled', false);
        $('input[type=text][name=cheque_date]').attr('disabled', false);
      
      var type_of_transaction = $("input[name='type_of_transaction']:checked").val();
      // alert(type_of_transaction);
      $('textarea#trans_particular').html(type_of_transaction+" by Cheque");
    }
});

// Type of transaction

$('input[type=radio][name=type_of_transaction]').change(function() {
    if (this.value == 'Deposit') {
      var mode_of_transaction = $("input[name='mode_of_transaction']:checked").val();
      // alert(mode_of_transaction);
      $('textarea#trans_particular').html("Deposit by "+mode_of_transaction);
    }
    else if (this.value == 'Withdraw') {
        var mode_of_transaction = $("input[name='mode_of_transaction']:checked").val();
      // alert(mode_of_transaction);
      $('textarea#trans_particular').html("Withdraw by "+mode_of_transaction);
    }
});

// only numeric value
function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;

   return true;
}

// Period of months

$("#month_of_period,.amount,.interest_rate,.type_of_interest").on('keyup change',function(){
    console.warn($(".interest_rate"));
          var periods = parseFloat($("#month_of_period").val());
// add month into date          
          var date2 = $('#int_from_date').datepicker('getDate');
            date2.setMonth(date2.getMonth() + periods);
            $( "#maturity_date_cal, #matured_on_date_cal" ).datepicker("setDate", date2);
// Interest calculation
          var amount = parseFloat($(".amount").val());
          var interest_rate = $(".interest_rate").val();
          var type_of_interest = $(".type_of_interest").val();
          
          switch ($(".type_of_interest").val()){
            case "Simple Interest":
                var start= $("#int_from_date").datepicker("getDate");
                var end= $("#matured_on_date_cal").datepicker("getDate");
                var days = (end- start) / (1000 * 60 * 60 * 24);

                var x = (amount + Math.round(amount * (interest_rate * ((periods / 12) * 365) / 36500)));
                x = isNaN(x) ? '0' : x;
              break;
            case "Quarterly Interest":
                var x = amount;
                var y = 0;
                for (var i = 1; i <= ((periods / 12) * 4); i++) {
                    y = ((((interest_rate / 4) + 100) / 100) * x);
                    x = y;
                }
                  x = Math.round(isNaN(x) ? '0' : x);
              break;
            case "Yearly Interest":
                var x = amount;
                var y = 0;
                for (var i = 1; i <= (periods / 12); i++) {
                    y = (((parseFloat(interest_rate) + 100) / 100) * x);
                    x = y;
                }
                  x = Math.round(isNaN(x) ? '0' : x);
            break;
          }
          var maturity_amount = $(".maturity_amount").val(x);
            // console.log(x);
});
// Renew FD
$("#renew_month_of_period,.renew_amount,.renew_interest_rate,.renew_type_of_interest").on('keyup change',function(){
    console.warn($(".renew_interest_rate"));
    var periods = parseFloat($("#renew_month_of_period").val());
// add month into date
    var date2 = $('#int_from_date').datepicker('getDate');
    date2.setMonth(date2.getMonth() + periods);
    $( "#maturity_date_cal, #matured_on_date_cal" ).datepicker("setDate", date2);
// Interest calculation
    var amount = parseFloat($(".renew_amount").val());
    var interest_rate = $(".renew_interest_rate").val();
    var type_of_interest = $(".renew_type_of_interest").val();

    switch ($(".renew_type_of_interest").val()){
        case "Simple Interest":
            var start= $("#int_from_date").datepicker("getDate");
            var end= $("#matured_on_date_cal").datepicker("getDate");
            var days = (end- start) / (1000 * 60 * 60 * 24);

            var x = (amount + Math.round(amount * (interest_rate * ((periods / 12) * 365) / 36500)));
            x = isNaN(x) ? '0' : x;
            break;
        case "Quarterly Interest":
            var x = amount;
            var y = 0;
            for (var i = 1; i <= ((periods / 12) * 4); i++) {
                y = ((((interest_rate / 4) + 100) / 100) * x);
                x = y;
            }
            x = Math.round(isNaN(x) ? '0' : x);
            break;
        case "Yearly Interest":
            var x = amount;
            var y = 0;
            for (var i = 1; i <= (periods / 12); i++) {
                y = (((parseFloat(interest_rate) + 100) / 100) * x);
                x = y;
            }
            x = Math.round(isNaN(x) ? '0' : x);
            break;
    }
    var maturity_amount = $(".maturity_amount").val(x);
    // console.log(x);
});

// Show renew FD Part
$(document).ready(function(){
        $("#show_renew_btn :input").prop("disabled", true);
    });

$("#show_renew_btn").on('click', function(){
    $("#renew_fd_area").removeClass('hide');
    $("#show_renew_btn :input").prop("disabled", false);
    $("[name='renew_transaction_date']").val($("[name='matured_on_date']").val());
    $("[name='old_amount']").val($("[name='amount']").val());
    $("[name='old_maturity_amount']").val($("[name='maturity_amount']").val());
    $("[name='old_matured_on_date']").val($("[name='matured_on_date']").val());
    $("[name='renew_amount']").val($("[name='maturity_amount']").val());
});
