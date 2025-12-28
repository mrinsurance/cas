
// Date Picker
    $("#transaction_date,#date_of_cheque,#date_receiving").datepicker({
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
        $("#saving_account_balance").addClass('hidden');
        $('input[type=text][name=cheque_number]').attr('disabled', true);
        $('input[type=text][name=cheque_date]').attr('disabled', true);

        $('#submit-btn').attr('disabled',false).removeClass('hidden');
        $(".is_sufficiante_balance").addClass('hidden').html('');
      
      var type_of_transaction = $("input[name='type_of_transaction']:checked").val();
      // alert(type_of_transaction);
      $('textarea#trans_particular').html(type_of_transaction+" by Cash");
    }
    else if (this.value == 'Cheque') {
        $('#cheque_mode').removeClass('hide');
        $("#saving_account_balance").removeClass('hidden');
        let is_sufficiante_balnce = $('input[type=text][name=is_sufficiante_balnce]').val();
        if (is_sufficiante_balnce < 0)
        {
            alert("You have insufficient balance in A/c");
            $('#submit-btn').attr('disabled',true).addClass('hidden');
            $(".is_sufficiante_balance").removeClass('hidden').html('You have insufficient balance in A/c');
        }
        else {
            $('#submit-btn').attr('disabled',false).removeClass('hidden');
            $(".is_sufficiante_balance").addClass('hidden').html('');
        }
      
      var type_of_transaction = $("input[name='type_of_transaction']:checked").val();
      // alert(type_of_transaction);
      $('textarea#trans_particular').html(type_of_transaction+" by Saving A/c");
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

// Select Loan type detail
$(document).on('change','#loan_type_request',function(){
  var product_id = $(this).val();
  var postURL = $("#loan_type_url").val();
        $.ajax({
          type: "POST",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: {"_method": 'POST',"id": product_id},
          dataType: 'json',
          url: postURL,
          beforeSend: function () { 
            $("#overlay").show();
        },
            success: function (data) {
              console.log(data);
           
                $(".term").val(data['success'].term_of_loan);   
                $(".month_value").val(data['success'].loan_month);
                $(".interest").val(data['success'].int_at);
                $(".pannelty_interest").val(data['success'].panelty_in_at);
                $(".additional-interest").val(data['success'].additional_interest);
                $(".type_of_interest").val(data['success'].loan_intr_type);
            },
            error: function (jqXHR, textStatus, errorThrown) {
            $("#overlay").hide();
            console.log(jqXHR, textStatus, errorThrown);
            },
            complete: function () {
              $("#overlay").hide();
            }
        });
});

// only numeric value
function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;

   return true;
}

// Toggle div
$(document).ready(function(){
  $("#togle_table").hide();
  $("#togle").on('click',function(){
  $("#togle_table").slideToggle(200);
});
}); 

$(".total_received").on('keyup blur', function(){
  
  var total_received = parseFloat($(this).val());
  var interest_recover = parseFloat($(".interest_recover").val());
  var principal_recover = parseFloat($(".principal_recover").val());
  var pending_interest = parseFloat($(".pending_interest").val());
 var total_recover_intr = (interest_recover + pending_interest);
  var principal_received = $(".principal_received").val();
  var principal = 0;
 
  $("#total_received").html('');

  if(total_received <= total_recover_intr)
  {
    $(".interest_received").val(total_received);
    $(".principal_received").val(0);
  }
  else if(total_received > total_recover_intr){
    if (total_received > (total_recover_intr + principal_recover)) {
      $("#total_received").html('Please check principal amount!');
      $(".interest_received").val('');
      $(".principal_received").val('');
    }
    else{
      principal = total_received - total_recover_intr;
      $(".interest_received").val(total_recover_intr);
      $(".principal_received").val(principal);
    }
  }
  else
  {
    $(".interest_received").val('');
    $(".principal_received").val('');
  }
}); 

$("#date1_receiving").on('blur', function(){
var product_id = $(this).val();
  var postURL = $("#rec_date_url").val();
  $.ajax({
    type: "GET",
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: postURL+"/"+product_id,
    
    success: function() {   
        location.href = postURL+"/"+product_id;  
    }
});
});
