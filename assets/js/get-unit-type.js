//delete product and remove it from list
$("#product_name").on('change', function(){
  var product_id = $(this).val();
  var getUrl = $("#getUrl").val();

  var postURL = getUrl+"/"+product_id;
    $.ajax({
    type: "GET",
    url: postURL,
    beforeSend: function() {
      $("#overlay").show();
   },
    success: function (data) {
      $('#unit_text').html(data.unit);
      $('#tax_id').val(data.tax);
      $("input[name=productStock]").val(data.stock);
    },
    error: function(){},
    complete: function () {
      $("#overlay").hide();
      }
    });
  
});

// Purchase Calculation

 function CalculateRate()
{


  var totalAmount = 0;
  var quantity = 0;
  var productRate = 0;
  var gst = 0;
  var tax = 0;

  totalAmount = parseFloat($('#total_amount_id').val());
  quantity = parseFloat($('#quantity_id').val());
  tax = parseFloat($("#tax_id").val());
  var billType = $('select[name=billType]');
    var includingGst = $('input[name=includingGst]');

  if (includingGst.prop('checked') == true)
  {
      productRate = parseFloat(totalAmount / quantity);
      gst = parseFloat((totalAmount - (totalAmount * (100/(100+tax))))/2).toFixed(2);
  }
  else {
      gst = parseInt(((totalAmount * tax) / 100) / 2).toFixed(2);
      productRate = parseFloat((totalAmount + (gst * 2)) / quantity);
  }

    if (isNaN(productRate)) {
      $("#rate_id").val(0);
  }
  else
  {
    $("#rate_id").val(productRate);
  }
  if (isNaN(gst)) {
      $("#cgst_id").val(0);
      $("#sgst_id").val(0);
      $("#igst_id").val(0);
  }
  else{
      if (billType.val() == 2)
      {
          $("#cgst_id").val((+gst));
          $("#sgst_id").val((+gst));
        $("#igst_id").val((+gst) + (+gst));
      }
      else
      {
          $("#cgst_id").val(gst);
          $("#sgst_id").val(gst);
          $("#igst_id").val(0);
      }
    }
}
// Sale calculation
 function saleCalculateRate()
{
  var totalAmount = 0;
  var quantity = 0;
  var productRate = 0;
  var gst = 0;
  var tax = 0;
  var rate = 0;
  quantity = parseFloat($('#quantity_id').val());
  productRate = parseFloat($("#cost_id").val());
    var billType = $('select[name=billType]');
    var includingGst = $('input[name=includingGst]');
  totalAmount = parseFloat(quantity * productRate);
  tax = parseFloat($("#tax_id").val());

    if (includingGst.prop('checked') == true)
    {
        productRate = parseFloat(totalAmount / quantity);
        gst = parseFloat((totalAmount - (totalAmount * (100/(100+tax))))/2).toFixed(2);
    }
    else {
        gst = parseInt(((totalAmount * tax) / 100) / 2).toFixed(2);
        productRate = parseFloat((totalAmount + (gst * 2)) / quantity);
    }

  // gst = parseFloat(totalAmount - (totalAmount * (100/(100+tax))))/2;
  // gst = gst.toFixed(2);
    rate = (productRate - (gst * 2) / quantity).toFixed(2);

    if (isNaN(totalAmount)) {
      $("#total_amount_id").val(0);
        $("#rate_id").val(0);
  }
  else
  {
    $("#total_amount_id").val(totalAmount);
      $("#rate_id").val(rate);
  }
  if (isNaN(gst)) {
      $("#cgst_id").val(0);
      $("#sgst_id").val(0);
  }
  else{
      if (billType.val() == 2)
      {
          $("#cgst_id").val((+gst));
          $("#sgst_id").val((+gst));
          $("#igst_id").val((+gst) + (+gst));
      }
      else
      {
          $("#cgst_id").val(gst);
          $("#sgst_id").val(gst);
          $("#igst_id").val(0);
      }
    }
}

// gst=(totalamount-totalamount*(100/(100+tax)))/2;

// Total cost (Get product price by quantity)

function totalCost(total_cost)
{
    let qnt = $('input[name=quantity]').val();

    let cost = parseFloat(total_cost / qnt).toFixed(4);
    $('input[name=cost]').val(cost);
    // $('input[name=total_amount]').val(cost);

    var totalAmount = 0;
    var quantity = 0;
    var productRate = 0;
    var gst = 0;
    var tax = 0;
    var rate = 0;
    quantity = parseFloat($('#quantity_id').val());
    productRate = cost;
    var billType = $('select[name=billType]');
    var includingGst = $('input[name=includingGst]');
    totalAmount = parseFloat(quantity * productRate);
    tax = parseFloat($("#tax_id").val());

    if (includingGst.prop('checked') == true)
    {
        productRate = parseFloat(totalAmount / quantity);
        gst = parseFloat((totalAmount - (totalAmount * (100/(100+tax))))/2).toFixed(2);
    }
    else {
        gst = parseInt(((totalAmount * tax) / 100) / 2).toFixed(2);
        productRate = parseFloat((totalAmount + (gst * 2)) / quantity);
    }

    // gst = parseFloat(totalAmount - (totalAmount * (100/(100+tax))))/2;
    // gst = gst.toFixed(2);
    rate = (productRate - (gst * 2) / quantity).toFixed(2);

    if (isNaN(totalAmount)) {
        $("#total_amount_id").val(0);
        $("#rate_id").val(0);
    }
    else
    {
        $("#total_amount_id").val(totalAmount);
        $("#rate_id").val(rate);
    }
    if (isNaN(gst)) {
        $("#cgst_id").val(0);
        $("#sgst_id").val(0);
    }
    else{
        if (billType.val() == 2)
        {
            $("#cgst_id").val((+gst));
            $("#sgst_id").val((+gst));
            $("#igst_id").val((+gst) + (+gst));
        }
        else
        {
            $("#cgst_id").val(gst);
            $("#sgst_id").val(gst);
            $("#igst_id").val(0);
        }
    }
}
