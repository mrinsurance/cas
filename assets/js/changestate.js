
$("#mailstate").on('change',function(){
  var product_id = $(this).val();

  if(product_id == '')
  {
    $('#ajax_mailing_dist').html('<option value="">--- Select ---</option>');
    $('.ajax_mailing_dist').html('<option value="">--- Select ---</option>');
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

      $('#ajax_mailing_dist').html('<option value="">--- Select ---</option>');
      $('.ajax_mailing_dist').html('<option value="">--- Select ---</option>');
        for(var i =0;i <= data[0].length-1;i++)
        {
          $('#ajax_mailing_dist').append('<option value="'+data[0][i].id+'">'+data[0][i].name+'</option>');
          $('.ajax_mailing_dist').append('<option value="'+data[0][i].id+'">'+data[0][i].name+'</option>');
        }
       
    },
    error: function(){},
    complete: function () {
      $("#overlay").hide();
      }
    });
  }
});

//delete product and remove it from list
$(".mailstate").on('change',function(){
  var product_id = $(this).val();

  if(product_id == '')
  {
    $('.ajax_mailing_dist').html('<option value="">--- Select ---</option>');
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

        $('.ajax_mailing_dist').html('<option value="">--- Select ---</option>');
         for(var i =0;i <= data[0].length-1;i++)
          {
            $('.ajax_mailing_dist').append('<option value="'+data[0][i].id+'">'+data[0][i].name+'</option>');
          }
      },
      error: function(){},
      complete: function () {
      $("#overlay").hide();
      }
    });
  }
});


