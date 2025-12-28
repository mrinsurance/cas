
// Date Picker
    $("#date_of_cheque").datepicker({
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
              // console.log(data);

                $(".term").val(data['success'].term_of_loan);
                $(".month_value").val(data['success'].loan_month);
                $(".interest").val(data['success'].int_at);
                $(".pannelty_interest").val(data['success'].panelty_in_at);
                $(".additional_interest").val(data['success'].additional_interest);
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
// Loan installment calculation monthly
$("#install_btn").on('click',function(){
    var share_balance = $("input[name=share_balance]").val();
    var amount = $(".amount").val();
    // if (amount > (share_balance * 10))
    // {
    //     alert('You are not eligible for loan');
    //     return false;
    // }
  $("#userTable").html('');
  $("#loop_input").html('');
  var term = $(".term").val();

  var interest = $(".interest").val();
  var additional_interest = $(".additional_interest").val();
  var month = $(".month_value").val();
  var transaction_date = $("input[name=date_of_transaction]").val();
  var type_of_interest = $(".type_of_interest").val();
  var km = 0;
// For reduce condition code
  if(type_of_interest == 'Reducing')
{
// Monthly Calculation
if (term == 'Monthly')
{
    var p = amount;
    var r = ((parseFloat(interest) + parseFloat(additional_interest)) / 12) / 100;
    var n = month;
    var rn = (1 + r);
    var rnp = 1;
    var emi = 0;

    for (var i = 1; i <= n; i++) {
      rnp = (rnp * rn);
    }
    emi = Math.round((p * r * rnp) / (rnp - 1));
    var pr = p;
    var intr = 0;
    for(var i = 1; i <= n; i++){
               var id = i;
               var date = 0;
               var days = 0;
               intr = Math.round(pr * r);
               var principal = emi - intr;
               var recoberable_int = intr;
               var net = emi;
               pr = Math.round(pr - (emi - intr));
               var prr = 0;
               if (i == n)
               {

                 if (pr > 0) {
                  prr = emi - intr;
                  emi = emi + pr;
                  principal = emi - intr;
                  recoberable_int = intr;
                  net = emi;
                  pr = (pr + (prr - (emi - intr)));
                 }

               else{
                  if (pr < 0) {
                  prr = emi - intr;
                  emi = emi + pr;
                  principal = emi - intr;
                  recoberable_int = intr;
                  net = emi;
                  pr = (pr + (prr - (emi - intr)));
                 }
               }
               }
  // Add month into date
var CurrentDate = new Date(transaction_date);
CurrentDate.setMonth(CurrentDate.getMonth() + i);
var dd = CurrentDate.getDate();
var mm = CurrentDate.getMonth() + 1;
var yyyy = CurrentDate.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
}
if (mm < 10) {
  mm = '0' + mm;
}
CurrentDate = yyyy + '-' + mm + '-' + dd;

               var tr_str = "<tr>" +
                   "<td align='center'>" + id + "</td>" +
                   "<td align='center'>" + CurrentDate + "</td>" +
                   "<td align='center'>" + principal + "</td>" +
                   "<td align='center'>" + recoberable_int + "</td>" +
                   "<td align='center'>" + net + "</td>" +
                "</tr>";
                var input_str = "<input type='hidden' name='loop_date[]' value='"+CurrentDate+"'> <input type='hidden' name='loop_principal[]' value='"+principal+"'> <input type='hidden' name='loop_recoberable_int[]' value='"+recoberable_int+"'> <input type='hidden' name='loop_net[]' value='"+net+"'>";
               $("#userTable").append(tr_str);
               $("#loop_input").append(input_str);
             }
}
// Monthly Society Calculation
      if (term == 'Monthly Society')
      {
          var p = amount;
          var r = ((parseFloat(interest) + parseFloat(additional_interest)));
          var n = month;
          var rn = (1 + r);
          var rnp = 1;
          var emi = 0;

          // for (var i = 1; i <= n; i++) {
          //     rnp = (rnp * rn);
          // }
          // emi = Math.round((p * r * rnp) / (rnp - 1));
          var plemi = Math.round(p / n);
          var pr = p;
          var intr = 0;
          for(var i = 1; i <= n; i++){
              var id = i;
              var date = 0;
              var days = 0;
              intr = Math.round(pr * r);
              // var principal = emi - intr;
              var principal = plemi;
              var recoberable_int = intr;
              var net = emi;
              // pr = Math.round(pr - (emi - intr));
              pr = Math.round(pr - plemi);
              var prr = 0;
              if (i == n)
              {

                  if (pr > 0) {
                      prr = emi - intr;
                      emi = emi + pr;
                      // principal = emi - intr;
                      principal = pr+plemi;
                      recoberable_int = intr;
                      net = emi;
                      pr = (pr + (prr - (emi - intr)));
                  }

                  else{
                      if (pr < 0) {
                          prr = emi - intr;
                          emi = emi + pr;
                          // principal = emi - intr;
                          principal = plemi + pr;
                          recoberable_int = intr;
                          net = emi;
                          pr = (pr + (prr - (emi - intr)));
                      }
                  }
              }
              // Add month into date
              recoberable_int = principal * r;
              var CurrentDate = new Date(transaction_date);
              CurrentDate.setMonth(CurrentDate.getMonth() + i);
              var dd = CurrentDate.getDate();
              var mm = CurrentDate.getMonth() + 1;
              var yyyy = CurrentDate.getFullYear();
              if (dd < 10) {
                  dd = '0' + dd;
              }
              if (mm < 10) {
                  mm = '0' + mm;
              }
              CurrentDate = yyyy + '-' + mm + '-' + dd;

              recoberable_int = Math.round(((pr + principal) * r * 30) / 36500);
               net = principal +  recoberable_int;
              var tr_str = "<tr>" +
                  "<td align='center'>" + id + "</td>" +
                  "<td align='center'>" + CurrentDate + "</td>" +
                  "<td align='center'>" + principal + "</td>" +
                  "<td align='center'>" + recoberable_int + "</td>" +
                  "<td align='center'>" + net + "</td>" +
                  "</tr>";
              var input_str = "<input type='hidden' name='loop_date[]' value='"+CurrentDate+"'> <input type='hidden' name='loop_principal[]' value='"+principal+"'> <input type='hidden' name='loop_recoberable_int[]' value='"+recoberable_int+"'> <input type='hidden' name='loop_net[]' value='"+net+"'>";
              $("#userTable").append(tr_str);
              $("#loop_input").append(input_str);
          }
      }
// Daily Calculation
if (term == 'Daily')
{
    var p = amount;

var CurrentDate = new Date(transaction_date);
CurrentDate.setMonth(CurrentDate.getMonth() + parseInt(month));

var startDay = new Date(CurrentDate);
var endDay = new Date(transaction_date);
var millisecondsPerDay = 1000 * 60 * 60 * 24;

var millisBetween = startDay.getTime() - endDay.getTime();
var days = millisBetween / millisecondsPerDay;

// Round down.
n = Math.floor(days);
var r = ((parseFloat(interest) + parseFloat(additional_interest)) / 365) / 100;
    var n = n;
    var rn = (1 + r);
    var rnp = 1;
    var emi = 0;

console.log("R="+r);
    for (var i = 1; i <= n; i++) {
      rnp = (rnp * rn);
    }
    emi = Math.round((p * r * rnp) / (rnp - 1));
    var pr = p;
    var intr = 0;
    for(var i = 1; i <= n; i++){
               var id = i;
               var date = 0;
               var days = 0;
               intr = Math.round(pr * r);
               var principal = emi - intr;
               var recoberable_int = intr;
               var net = emi;
               pr = Math.round(pr - (emi - intr));
               var prr = 0;
               if (i == n)
               {

                 if (pr > 0) {
                  prr = emi - intr;
                  emi = emi + pr;
                  principal = emi - intr;
                  recoberable_int = intr;
                  net = emi;
                  pr = (pr + (prr - (emi - intr)));
                 }

               else{
                  if (pr < 0) {
                  prr = emi - intr;
                  emi = emi + pr;
                  principal = emi - intr;
                  recoberable_int = intr;
                  net = emi;
                  pr = (pr + (prr - (emi - intr)));
                 }
               }
               }
  // Add month into date
var CurrentDate = new Date(transaction_date);
CurrentDate.setDate(CurrentDate.getDate() + i);
var dd = CurrentDate.getDate();
var mm = CurrentDate.getMonth() + 1;
var yyyy = CurrentDate.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
}
if (mm < 10) {
  mm = '0' + mm;
}
CurrentDate = yyyy + '-' + mm + '-' + dd;

               var tr_str = "<tr>" +
                   "<td align='center'>" + id + "</td>" +
                   "<td align='center'>" + CurrentDate + "</td>" +
                   "<td align='center'>" + principal + "</td>" +
                   "<td align='center'>" + recoberable_int + "</td>" +
                   "<td align='center'>" + net + "</td>" +
                "</tr>";
var input_str = "<input type='hidden' name='loop_date[]' value='"+CurrentDate+"'> <input type='hidden' name='loop_principal[]' value='"+principal+"'> <input type='hidden' name='loop_recoberable_int[]' value='"+recoberable_int+"'> <input type='hidden' name='loop_net[]' value='"+net+"'>";
               $("#userTable").append(tr_str);
               $("#loop_input").append(input_str);
             }
}

// Quarter Calculation
if (term == 'Quarterly')
{
    var p = amount;
    var r = ((parseFloat(interest) + parseFloat(additional_interest)) / 4) / 100;
    var n = month / 3;
    var rn = (1 + r);
    var rnp = 1;
    var emi = 0;
    for (var i = 1; i <= n; i++) {
      rnp = (rnp * rn);
    }
    emi = Math.round((p * r * rnp) / (rnp - 1));
    var pr = p;
    var intr = 0;
    km = 0;
    for(var i = 1; i <= n; i++){
               var id = i;
               var date = 0;
               var days = 0;
               intr = Math.round(pr * r);
               var principal = emi - intr;
               var recoberable_int = intr;
               var net = emi;
               pr = Math.round(pr - (emi - intr));
               var prr = 0;
               if (i == n)
               {

                 if (pr > 0) {
                  prr = emi - intr;
                  emi = emi + pr;
                  principal = emi - intr;
                  recoberable_int = intr;
                  net = emi;
                  pr = (pr + (prr - (emi - intr)));
                 }

               else{
                  if (pr < 0) {
                  prr = emi - intr;
                  emi = emi + pr;
                  principal = emi - intr;
                  recoberable_int = intr;
                  net = emi;
                  pr = (pr + (prr - (emi - intr)));
                 }
               }
               }
  // Add month into date
var CurrentDate = new Date(transaction_date);
km = km + 3;
CurrentDate.setMonth(CurrentDate.getMonth() + km);
var dd = CurrentDate.getDate();
var mm = CurrentDate.getMonth() + 1;
var yyyy = CurrentDate.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
}
if (mm < 10) {
  mm = '0' + mm;
}
CurrentDate = yyyy + '-' + mm + '-' + dd;

               var tr_str = "<tr>" +
                   "<td align='center'>" + id + "</td>" +
                   "<td align='center'>" + CurrentDate + "</td>" +
                   "<td align='center'>" + principal + "</td>" +
                   "<td align='center'>" + recoberable_int + "</td>" +
                   "<td align='center'>" + net + "</td>" +
                "</tr>";
var input_str = "<input type='hidden' name='loop_date[]' value='"+CurrentDate+"'> <input type='hidden' name='loop_principal[]' value='"+principal+"'> <input type='hidden' name='loop_recoberable_int[]' value='"+recoberable_int+"'> <input type='hidden' name='loop_net[]' value='"+net+"'>";
               $("#userTable").append(tr_str);
               $("#loop_input").append(input_str);
             }
}

// Half Yearly Calculation
if (term == 'Half Yearly')
{
    var p = amount;
    var r = ((parseFloat(interest) + parseFloat(additional_interest)) / 2) / 100;
    var n = month / 6;
    var rn = (1 + r);
    var rnp = 1;
    var emi = 0;
    for (var i = 1; i <= n; i++) {
      rnp = (rnp * rn);
    }
    emi = Math.round((p * r * rnp) / (rnp - 1));
    var pr = p;
    var intr = 0;
    km = 0;
    for(var i = 1; i <= n; i++){
               var id = i;
               var date = 0;
               var days = 0;
               intr = Math.round(pr * r);
               var principal = emi - intr;
               var recoberable_int = intr;
               var net = emi;
               pr = Math.round(pr - (emi - intr));
               var prr = 0;
               if (i == n)
               {

                 if (pr > 0) {
                  prr = emi - intr;
                  emi = emi + pr;
                  principal = emi - intr;
                  recoberable_int = intr;
                  net = emi;
                  pr = (pr + (prr - (emi - intr)));
                 }

               else{
                  if (pr < 0) {
                  prr = emi - intr;
                  emi = emi + pr;
                  principal = emi - intr;
                  recoberable_int = intr;
                  net = emi;
                  pr = (pr + (prr - (emi - intr)));
                 }
               }
               }
  // Add month into date
var CurrentDate = new Date(transaction_date);
km = km + 6;
CurrentDate.setMonth(CurrentDate.getMonth() + km);
var dd = CurrentDate.getDate();
var mm = CurrentDate.getMonth() + 1;
var yyyy = CurrentDate.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
}
if (mm < 10) {
  mm = '0' + mm;
}
CurrentDate = yyyy + '-' + mm + '-' + dd;

               var tr_str = "<tr>" +
                   "<td align='center'>" + id + "</td>" +
                   "<td align='center'>" + CurrentDate + "</td>" +
                   "<td align='center'>" + principal + "</td>" +
                   "<td align='center'>" + recoberable_int + "</td>" +
                   "<td align='center'>" + net + "</td>" +
                "</tr>";

var input_str = "<input type='hidden' name='loop_date[]' value='"+CurrentDate+"'> <input type='hidden' name='loop_principal[]' value='"+principal+"'> <input type='hidden' name='loop_recoberable_int[]' value='"+recoberable_int+"'> <input type='hidden' name='loop_net[]' value='"+net+"'>";
               $("#userTable").append(tr_str);
               $("#loop_input").append(input_str);
             }
}

// Half Yearly Society Calculation
      if (term == 'Half Yearly Society')
      {

          var p = amount;
          var r = ((parseFloat(interest) + parseFloat(additional_interest)) );
          var n = month / 6;
          var rn = (1 + r);
          var rnp = 1;
          var emi = 0;
          var pr = p;
          var plemi = Math.round(p / n);
          var intr = 0;
          km = 0;
          for(var i = 1; i <= n; i++){
              var id = i;
              var date = 0;
              var days = 0;
              intr = Math.round(pr * r);
              var principal = plemi;
              var recoberable_int = intr;
              var net = emi;
              pr = Math.round(pr - plemi);
              var prr = 0;
              if (i == n)
              {

                  if (pr > 0) {
                      prr = emi - intr;
                      emi = emi + pr;
                      principal = pr+plemi;
                      recoberable_int = intr;
                      net = emi;
                      pr = (pr + (prr - (emi - intr)));
                  }

                  else{

                      if (pr < 0) {

                          prr = emi - intr;
                          emi = emi + pr;
                          principal = plemi + pr;
                          recoberable_int = intr;
                          net = emi;
                          pr = (pr + (prr - (emi - intr)));
                      }
                  }
              }
              recoberable_int = principal * r;
              // Add month into date
              var CurrentDate = new Date(transaction_date);
              km = km + 6;
              CurrentDate.setMonth(CurrentDate.getMonth() + km);
              var dd = CurrentDate.getDate();
              var mm = CurrentDate.getMonth() + 1;
              var yyyy = CurrentDate.getFullYear();
              if (dd < 10) {
                  dd = '0' + dd;
              }
              if (mm < 10) {
                  mm = '0' + mm;
              }
              CurrentDate = yyyy + '-' + mm + '-' + dd;
              recoberable_int = Math.round(((pr + principal) * r * 183) / 36500);
              var tr_str = "<tr>" +
                  "<td align='center'>" + id + "</td>" +
                  "<td align='center'>" + CurrentDate + "</td>" +
                  "<td align='center'>" + principal + "</td>" +
                  "<td align='center'>" + recoberable_int + "</td>" +
                  "<td align='center'>" + pr + "</td>" +
                  "</tr>";

              var input_str = "<input type='hidden' name='loop_date[]' value='"+CurrentDate+"'> <input type='hidden' name='loop_principal[]' value='"+principal+"'> <input type='hidden' name='loop_recoberable_int[]' value='"+recoberable_int+"'> <input type='hidden' name='loop_net[]' value='"+net+"'>";
              $("#userTable").append(tr_str);
              $("#loop_input").append(input_str);
          }
      }
      // Half Yearly Calculation
      // Yearly Calculation
      if (term == 'Yearly')
      {
          var p = amount;
          var r = ((parseFloat(interest) + parseFloat(additional_interest))) / 100;
          var n = month / 12;
          var rn = (1 + r);
          var rnp = 1;
          var emi = 0;
          for (var i = 1; i <= n; i++) {
              rnp = (rnp * rn);
          }
          emi = Math.round((p * r * rnp) / (rnp - 1));
          var pr = p;
          var intr = 0;
          km = 0;
          for(var i = 1; i <= n; i++){
              var id = i;
              var date = 0;
              var days = 0;
              intr = Math.round(pr * r);
              var principal = emi - intr;
              var recoberable_int = intr;
              var net = emi;
              pr = Math.round(pr - (emi - intr));
              var prr = 0;
              if (i == n)
              {

                  if (pr > 0) {
                      prr = emi - intr;
                      emi = emi + pr;
                      principal = emi - intr;
                      recoberable_int = intr;
                      net = emi;
                      pr = (pr + (prr - (emi - intr)));
                  }

                  else{
                      if (pr < 0) {
                          prr = emi - intr;
                          emi = emi + pr;
                          principal = emi - intr;
                          recoberable_int = intr;
                          net = emi;
                          pr = (pr + (prr - (emi - intr)));
                      }
                  }
              }
              // Add month into date
              var CurrentDate = new Date(transaction_date);
              km = km + 12;
              CurrentDate.setMonth(CurrentDate.getMonth() + km);
              var dd = CurrentDate.getDate();
              var mm = CurrentDate.getMonth() + 1;
              var yyyy = CurrentDate.getFullYear();
              if (dd < 10) {
                  dd = '0' + dd;
              }
              if (mm < 10) {
                  mm = '0' + mm;
              }
              CurrentDate = yyyy + '-' + mm + '-' + dd;

              var tr_str = "<tr>" +
                  "<td align='center'>" + id + "</td>" +
                  "<td align='center'>" + CurrentDate + "</td>" +
                  "<td align='center'>" + principal + "</td>" +
                  "<td align='center'>" + recoberable_int + "</td>" +
                  "<td align='center'>" + net + "</td>" +
                  "</tr>";

              var input_str = "<input type='hidden' name='loop_date[]' value='"+CurrentDate+"'> <input type='hidden' name='loop_principal[]' value='"+principal+"'> <input type='hidden' name='loop_recoberable_int[]' value='"+recoberable_int+"'> <input type='hidden' name='loop_net[]' value='"+net+"'>";
              $("#userTable").append(tr_str);
              $("#loop_input").append(input_str);
          }
      }
    // Code for flat calculation
  }
// Code for flat calculation
else{
  var p = amount;
    var r = parseFloat(interest) + parseFloat(additional_interest);
    var n = (month / 12);
    var tintr = 0;

    tintr = Math.round((p * r * n) / 100);
    var emip = 0;
    var emiintr = 0;
    var pr = p;
    var prr = tintr;

// Monthly Calculation
if (term == 'Monthly')
{

  n = month;
  emip = Math.round(p / n);
  emiintr = Math.round(tintr / n);

if(((p / emip) - Math.round(p / emip)) > 0){
  n = Math.round(p / emip);
  n = n + 1;
}
else{
  n = Math.round(p / emip);
}

console.log(tintr);
    for(var i = 1; i <= n; i++){
               var id = i;
               var date = 0;
               var days = 0;

               var principal = emip;
               var recoberable_int = emiintr;
               var net = emip + emiintr;
               pr = pr - emip;
               prr = prr - emiintr;

               if (i == n)
               {
                 if (pr > 0) {
                  principal = emip - pr;
                  pr = pr - emip;
                 }

               else{
                  if (pr < 0) {
                  principal = emip + pr;
                  pr = pr - emip;
                 }
               }

               if (prr > 0) {
                  recoberable_int = emiintr + prr;
                  prr = prr - emiintr;
                 }

               else{
                  if (pr < 0) {
                  recoberable_int = emiintr + prr;
                  prr = prr - emiintr;
                 }
               }
               net = principal + emiintr;
               }

  // Add month into date
var CurrentDate = new Date(transaction_date);
CurrentDate.setMonth(CurrentDate.getMonth() + i);
var dd = CurrentDate.getDate();
var mm = CurrentDate.getMonth() + 1;
var yyyy = CurrentDate.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
}
if (mm < 10) {
  mm = '0' + mm;
}
CurrentDate = yyyy + '-' + mm + '-' + dd;

               var tr_str = "<tr>" +
                   "<td align='center'>" + id + "</td>" +
                   "<td align='center'>" + CurrentDate + "</td>" +
                   "<td align='center'>" + principal + "</td>" +
                   "<td align='center'>" + emiintr + "</td>" +
                   "<td align='center'>" + net + "</td>" +
                "</tr>";
                var input_str = "<input type='hidden' name='loop_date[]' value='"+CurrentDate+"'> <input type='hidden' name='loop_principal[]' value='"+principal+"'> <input type='hidden' name='loop_recoberable_int[]' value='"+recoberable_int+"'> <input type='hidden' name='loop_net[]' value='"+net+"'>";
               $("#userTable").append(tr_str);
               $("#loop_input").append(input_str);
             }
}
// Daily Calculation
if (term == 'Daily')
{
  var CurrentDate = new Date(transaction_date);
CurrentDate.setMonth(CurrentDate.getMonth() + parseInt(month));

var startDay = new Date(CurrentDate);
var endDay = new Date(transaction_date);
var millisecondsPerDay = 1000 * 60 * 60 * 24;

var millisBetween = startDay.getTime() - endDay.getTime();
var days = millisBetween / millisecondsPerDay;

// Round down.
n = Math.floor(days);
emip = Math.round(p / n);
console.log(p % emip);
if(((p / emip) - Math.round(p / emip)) > 0){
  n = Math.round(p / emip);
  n = n + 1;
}
else{
  n = Math.round(p / emip);
}


console.log(n);
  // emip = Math.round(p / n);
  emiintr = Math.round(tintr / n);

    for(var i = 1; i <= n; i++){
               var id = i;
               var date = 0;
               var days = 0;

               var principal = emip;
               var recoberable_int = emiintr;
               var net = emip + emiintr;
               pr = pr - emip;
               prr = prr - emiintr;

               if (i == n)
               {

                 if (pr > 0) {
                  principal = emip - pr;

                  pr = pr - emip;
                 }

               else{
                  if (pr < 0) {
                  principal = emip + pr;
                  pr = pr - emip;
                 }
               }
               if (prr > 0) {

                  recoberable_int = emiintr + prr;
                  prr = prr - emiintr;
                 }

               else{
                  if (pr < 0) {
                  recoberable_int = emiintr + prr;
                  prr = prr - emiintr;
                 }
               }
               net = principal + emiintr;
               }

  // Add month into date
var CurrentDate = new Date(transaction_date);
CurrentDate.setDate(CurrentDate.getDate() + i);
var dd = CurrentDate.getDate();
var mm = CurrentDate.getMonth() + 1;
var yyyy = CurrentDate.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
}
if (mm < 10) {
  mm = '0' + mm;
}
CurrentDate = yyyy + '-' + mm + '-' + dd;

               var tr_str = "<tr>" +
                   "<td align='center'>" + id + "</td>" +
                   "<td align='center'>" + CurrentDate + "</td>" +
                   "<td align='center'>" + principal + "</td>" +
                   "<td align='center'>" + emiintr + "</td>" +
                   "<td align='center'>" + net + "</td>" +
                "</tr>";
                var input_str = "<input type='hidden' name='loop_date[]' value='"+CurrentDate+"'> <input type='hidden' name='loop_principal[]' value='"+principal+"'> <input type='hidden' name='loop_recoberable_int[]' value='"+recoberable_int+"'> <input type='hidden' name='loop_net[]' value='"+net+"'>";
               $("#userTable").append(tr_str);
               $("#loop_input").append(input_str);
             }
}
// Quarterly Calculation
if (term == 'Quarterly')
{

// Round down.
n = (month / 12) * 4;

  emip = Math.round(p / n);
  emiintr = Math.round(tintr / n);

if(((p / emip) - Math.round(p / emip)) > 0){
  n = Math.round(p / emip);
  n = n + 1;
}
else{
  n = Math.round(p / emip);
}
// console.log(tintr);
km = 0;
    for(var i = 1; i <= n; i++){
               var id = i;
               var date = 0;
               var days = 0;

               var principal = emip;
               var recoberable_int = emiintr;
               var net = emip + emiintr;
               pr = pr - emip;
               prr = prr - emiintr;

               if (i == n)
               {
                 if (pr > 0) {
                  principal = emip - pr;
                  pr = pr - emip;
                 }

               else{
                  if (pr < 0) {
                  principal = emip + pr;
                  pr = pr - emip;
                 }
               }

               if (prr > 0) {
                  recoberable_int = emiintr + prr;
                  prr = prr - emiintr;
                 }

               else{
                  if (pr < 0) {
                  recoberable_int = emiintr + prr;
                  prr = prr - emiintr;
                 }
               }
               net = principal + recoberable_int;
               }

  // Add month into date
var CurrentDate = new Date(transaction_date);
km = km + 3;
CurrentDate.setMonth(CurrentDate.getMonth() + km);
var dd = CurrentDate.getDate();
var mm = CurrentDate.getMonth() + 1;
var yyyy = CurrentDate.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
}
if (mm < 10) {
  mm = '0' + mm;
}
CurrentDate = yyyy + '-' + mm + '-' + dd;

               var tr_str = "<tr>" +
                   "<td align='center'>" + id + "</td>" +
                   "<td align='center'>" + CurrentDate + "</td>" +
                   "<td align='center'>" + principal + "</td>" +
                   "<td align='center'>" + recoberable_int + "</td>" +
                   "<td align='center'>" + net + "</td>" +
                "</tr>";
                var input_str = "<input type='hidden' name='loop_date[]' value='"+CurrentDate+"'> <input type='hidden' name='loop_principal[]' value='"+principal+"'> <input type='hidden' name='loop_recoberable_int[]' value='"+recoberable_int+"'> <input type='hidden' name='loop_net[]' value='"+net+"'>";
               $("#userTable").append(tr_str);
               $("#loop_input").append(input_str);
             }
}
// Half Yearly Calculation
if (term == 'Half Yearly')
{

// Round down.
n = (month / 12) * 2;

  emip = Math.round(p / n);
  emiintr = Math.round(tintr / n);
if(((p / emip) - Math.round(p / emip)) > 0){
  n = Math.round(p / emip);
  n = n + 1;
}
else{
  n = Math.round(p / emip);
}

km = 0;
    for(var i = 1; i <= n; i++){
               var id = i;
               var date = 0;
               var days = 0;

               var principal = emip;
               var recoberable_int = emiintr;
               var net = emip + emiintr;
               pr = pr - emip;
               prr = prr - emiintr;

               if (i == n)
               {
                 if (pr > 0) {
                  principal = emip - pr;
                  pr = pr - emip;
                 }

               else{
                  if (pr < 0) {
                  principal = emip + pr;
                  pr = pr - emip;
                 }
               }

               if (prr > 0) {
                  recoberable_int = emiintr + prr;
                  prr = prr - emiintr;
                 }

               else{
                  if (pr < 0) {
                  recoberable_int = emiintr + prr;
                  prr = prr - emiintr;
                 }
               }
               net = principal + recoberable_int;
               }

  // Add month into date
var CurrentDate = new Date(transaction_date);
km = km + 6;
CurrentDate.setMonth(CurrentDate.getMonth() + km);
var dd = CurrentDate.getDate();
var mm = CurrentDate.getMonth() + 1;
var yyyy = CurrentDate.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
}
if (mm < 10) {
  mm = '0' + mm;
}
CurrentDate = yyyy + '-' + mm + '-' + dd;

               var tr_str = "<tr>" +
                   "<td align='center'>" + id + "</td>" +
                   "<td align='center'>" + CurrentDate + "</td>" +
                   "<td align='center'>" + principal + "</td>" +
                   "<td align='center'>" + recoberable_int + "</td>" +
                   "<td align='center'>" + net + "</td>" +
                "</tr>";
                var input_str = "<input type='hidden' name='loop_date[]' value='"+CurrentDate+"'> <input type='hidden' name='loop_principal[]' value='"+principal+"'> <input type='hidden' name='loop_recoberable_int[]' value='"+recoberable_int+"'> <input type='hidden' name='loop_net[]' value='"+net+"'>";
               $("#userTable").append(tr_str);
               $("#loop_input").append(input_str);
             }
}
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
