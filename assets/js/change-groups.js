//delete product and remove it from list
$(".groupchange").on('change', function(){
  var product_id = $(this).val();
  var subId = $(this).attr('id');  

  if(product_id == '')
  {
    $('.sub'+subId).html('<option value="">--- Select ---</option>');
  }
  else
  {
  var postURL = window.location.href+"/"+product_id;
    $.ajax({
    type: "GET",
    url: postURL,
    beforeSend: function() {
      $("#overlay").show();
   },
    success: function (data) {
      $('.sub'+subId).html('<option value="">--- Select ---</option>');
        for(var i =0;i <= data[0].length-1;i++)
        {
          $('.sub'+subId).append('<option value="'+data[0][i].id+'">'+data[0][i].name+'</option>');
        }       
    },
    error: function(){},
    complete: function () {
      $("#overlay").hide();
      }
    });
  }
});

$(".block").on('change', '.groupchange', function(){
  var product_id = $(this).val();
  var subId = $(this).attr('id');  

  if(product_id == '')
  {
    $('.sub'+subId).html('<option value="">--- Select ---</option>');
  }
  else
  {
  var postURL = window.location.href+"/"+product_id;
    $.ajax({
    type: "GET",
    url: postURL,
    beforeSend: function() {
      $("#overlay").show();
   },
    success: function (data) {
      $('.sub'+subId).html('<option value="">--- Select ---</option>');
        for(var i =0;i <= data[0].length-1;i++)
        {
          $('.sub'+subId).append('<option value="'+data[0][i].id+'">'+data[0][i].name+'</option>');
        }       
    },
    error: function(){},
    complete: function () {
      $("#overlay").hide();
      }
    });
  }
});



// Count sum of debit value
function calculateDrSum() {
var sum = 0;
$(".drAmount").each(function() {
//add only if the value is number
if(!isNaN(this.value) && this.value.length!=0) {
sum += parseFloat(this.value);
}
});
$("#sumDr").val(sum.toFixed(2));
}
$(document).ready(function(){       
    
    $('.drAmount').keyup(function() {
        calculateDrSum();
    });

    $('.block').keyup('.drAmount', function() {
        calculateDrSum();
    });         
});

// Count sum of credit value
function calculateCrSum() {
var sum = 0;
$(".crAmount").each(function() {
//add only if the value is number
if(!isNaN(this.value) && this.value.length!=0) {
sum += parseFloat(this.value);
}
});
$("#sumCr").val(sum.toFixed(2));
}
$(document).ready(function(){       
    
    $('.crAmount').keyup(function() {
        calculateCrSum();
    });

    $('.block').keyup('.crAmount', function() {
        calculateCrSum();
    });         
});
