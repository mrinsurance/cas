// Date picker calander
// $( "#date_installment").datepicker({
//       dateFormat: "yy-mm-dd",
//       changeMonth: true,
//       changeYear: true,
//       yearRange: "-100:+15",
//     });

// only numeric value
function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;

   return true;
}
// Calculate no. of installments
$("#inst_amount").on('keyup',function(){
    var inst = "";
    var currentUrl = window.location.hostname;

          var inst_amount = parseInt($(this).val());
          var rd_monthly_amount = $("#rd_monthly_amount").val();  

          var installments = (inst_amount % rd_monthly_amount);
        if (currentUrl == "casbarin.himachalsociety.com")
        {
            var inst = (inst_amount / rd_monthly_amount).toFixed(2);
        }
        else {
            if(installments == 0)
            {
                var inst = (inst_amount / rd_monthly_amount)
            }
        }

          $("#installs_no").val(inst);
    });
