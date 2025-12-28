    // Image Upload
      var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('imgphoto');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
// Signature
  var loadFile2 = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('imgsignature');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
// Date Picker
  $("#dbirth,#nomineedob,#opening_date_ac").datepicker({
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      yearRange: "-100:+0",
    });
  $('#valid_passport_date').datepicker({
    dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      yearRange: "-0:+10",
  });
// only numeric value
function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;

   return true;
} 

// Show Gaurdian Detail window 
$(".type_of_account").on('change',function(e){
  var item = $(this).val();
    if(item == 1)
    {
      $("#gaurdian_account").removeClass('hide');
      $("#gaurdian_account").find("input").attr('disabled',false);
    }
    else{
     $("#gaurdian_account").addClass('hide'); 
     $("#gaurdian_account").find("input").attr('disabled',true);
    }
});
// =============== Same as permanent address

$("#same_permanent").on('change', function(){
  if (this.checked) {

    $("[name='permanent_address_line']").val($("[name='current_address_line']").val());
    $("[name='permanent_village_or_city']").val($("[name='current_village_or_city']").val());
    $("[name='permanent_state']").val($("[name='current_state']").val());
    $("[name='permanent_district']").val($("[name='current_district']").val());
    $("[name='permanent_tehsil']").val($("[name='current_tehsil']").val());
    $("[name='permanent_pin_code']").val($("[name='current_pin_code']").val());
    
  }
  else
  {
    $("[name='permanent_address_line']").val('');
    $("[name='permanent_village_or_city']").val('');
    $("[name='permanent_state']").val('');
    $("[name='permanent_district']").val('');
    $("[name='permanent_tehsil']").val('');
    $("[name='permanent_pin_code']").val('');
    
  }
});
