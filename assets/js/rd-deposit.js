// Date picker calander
$( "#maturity_date_cal, #matured_on_date_cal").datepicker({
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      yearRange: "-100:+15",
    });
// Interest Run From
    $( "#rd_start_date" ).datepicker({
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
            var date2 = $('#rd_start_date').datepicker('getDate');
            date2.setMonth(date2.getMonth() + periods);
            $( "#maturity_date_cal, #matured_on_date_cal" ).datepicker("setDate", date2);

            var principal = $(".amount").val();
            var interest_rate = parseFloat($(".interest_rate").val() / 100);

            var matured_amount = 0;
            var n = periods / 4;
            for (var i = periods; i >=1 ; i--) {
              var matured_amount = matured_amount + (principal * Math.pow(1+interest_rate/n, n*i/12));
            }
            
            $('.maturity_amount').val(Math.round(matured_amount));
            
});
