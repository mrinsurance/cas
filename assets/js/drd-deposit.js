// Date picker calander
$( "#maturity_date_cal, #matured_on_date_cal").datepicker({
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true
    });
// Interest Run From
    $( "#drd_start_date" ).datepicker({
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

function isNumAndDecimalKey(evt)
{
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode == 8 || charCode == 37) {
    return true;
  } else if (charCode == 46 && $(this).val().indexOf('.') != -1) {
    return false;
  } else if (charCode > 31 && charCode != 46 && (charCode < 48 || charCode > 57)) {
    return false;
  }
  return true;
}

// Period of months

$(".amount,#month_of_period,.interest_rate").on('keyup',function(){
          var periods = parseFloat($("#month_of_period").val());
            var date2 = $('#drd_start_date').datepicker('getDate');
            date2.setDate(date2.getDate() + periods);
            $( "#maturity_date_cal, #matured_on_date_cal" ).datepicker("setDate", date2);

            var principal = $(".amount").val();
            var interest_rate = ($(".interest_rate").val() / 100);

            var matured_amount = 0;
for (var i = 1; i <= periods; i++) {
  var matured_amount = matured_amount + (principal * Math.pow(1+interest_rate/365, 365*i/periods));
}
            $('.maturity_amount').val(Math.round(matured_amount));
            
});
