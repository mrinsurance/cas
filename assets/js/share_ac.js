
// Date Picker
    $("#transaction_date,#date_of_cheque").datepicker({
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      yearRange: "-100:+0",
    });
// Mode of Transaction
  $('input[type=radio][name=mode_of_transaction]').change(function() {
    if (this.value == 'Cash') {
      // console.log('fsdlk');
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
    else if (this.value == 'Withdrawal') {
        var mode_of_transaction = $("input[name='mode_of_transaction']:checked").val();
      // alert(mode_of_transaction);
      $('textarea#trans_particular').html("Withdrawal by "+mode_of_transaction);
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
