// $("#from_date,#to_date").datepicker({
// 	dateFormat: "yy-mm-dd",
// 	changeMonth: true,
// 	changeYear: true,
// 	yearRange: "-100:+0",
// 	maxDate: "0d",
// });

// only numeric value
function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;

   return true;
}