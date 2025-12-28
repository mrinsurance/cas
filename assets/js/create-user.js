// Date Picker
  $("#dob").datepicker({
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      yearRange: "-100:+0",
    });
// Date Picker
  $("#miscdeductiondate").datepicker({
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      yearRange: "-0:+10",
    });  
// =============== Same as permanent address

$("#same_permanent").on('change', function(){
  if (this.checked) {

    $("[name='permanent_address']").val($("[name='mailing_address']").val());
    $("[name='permanent_country']").val($("[name='mailing_country']").val());
    $("[name='permanent_state']").val($("[name='mailing_state']").val());
    $("[name='permanent_district']").val($("[name='mailing_district']").val());
    $("[name='permanent_city']").val($("[name='mailing_city']").val());
    $("[name='permanent_pin']").val($("[name='mailing_pin']").val());
    
  }
  else
  {
    $("[name='permanent_address']").val('');
    $("[name='permanent_country']").val('');
    $("[name='permanent_state']").val('');
    $("[name='permanent_district']").val('');
    $("[name='permanent_city']").val('');
    $("[name='permanent_pin']").val('');
    
  }
});  