//delete product and remove it from list
$(".subgroupchange").on('change',function(){
  var product_id = $(this).val();

  if(product_id == '')
  {
    $('.groupchange').html('<option value="">--- Select ---</option>');
  }
  else
  {
  var postURL = window.location.href+"/subgroup/"+product_id;
    $.ajax({
    type: "GET",
    url: postURL,
    beforeSend: function() {
      $("#overlay").show();
   },
    success: function (data) {
      console.log(data);
      $('.groupchange').html('<option value="">--- Select ---</option>');
        for(var i =0;i <= data[0].length-1;i++)
        {
          $('.groupchange').append('<option value="'+data[0][i].id+'">'+data[0][i].name+'</option>');
        }
       
    },
    error: function(){},
    complete: function () {
      $("#overlay").hide();
      }
    });
  }
});
