// Date picker calander
$( "#maturity_date_cal, #matured_on_date_cal").datepicker({
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      yearRange: "-100:+15",
    });
// Interest Run From
    $( "#mis_start_date" ).datepicker({
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
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

$(".amount,#month_of_period,.interest_rate").on('keyup',function(){
          var periods = parseFloat($("#month_of_period").val());
            var date2 = $('#mis_start_date').datepicker('getDate');
            date2.setMonth(date2.getMonth() + periods);
            $( "#maturity_date_cal, #matured_on_date_cal" ).datepicker("setDate", date2);
            
            var principal = $(".amount").val();
            var interest_rate = $(".interest_rate").val();

            var total_intr = 0;
            var mis = 0;
            total_intr = (principal * interest_rate * periods / 12) / 100;
            mis = Math.round(total_intr / periods);
            total_intr = Math.round(isNaN(total_intr) ? '0' : total_intr);
            mis = Math.round(isNaN(mis) ? '0' : mis);

            $('.maturity_amount').val(Math.round(principal));
            $('.total_interest').val(total_intr);
            $('.monthly_installment').val(mis);
            
});

// Loan installment calculation monthly
$("#install_btn").on('click',function(){
  $("#userTable").html('');
  var n = $(".term").val();
  var transaction_date = $("#mis_start_date").val();
  var emi = $(".monthly_installment").val();


// For reduce condition code
    for(var i = 1; i <= n; i++){
        var id = i;
               
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
                   "<td align='center'>" + emi + "</td>" +
                   "<td align='center'> Unpaid </td>" +
                "</tr>";
                var input_str = "<input type='hidden' name='loop_date[]' value='"+CurrentDate+"'> <input type='hidden' name='loop_principal[]' value='"+emi+"'>";
               $("#userTable").append(tr_str);
               $("#loop_input").append(input_str);
             }
});
