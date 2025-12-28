

// Product name by product type
$('select[name=product_party]').on('change', function(){
    var product_id = $(this).val();
    var getUrl = $("#getProduct").val();

    var postURL = getUrl+"/"+product_id;
    $.ajax({
        type: "GET",
        url: postURL,
        beforeSend: function() {
            $("#overlay").show();
        },
        success: function (data) {

            $('select[name=product_name]').html('<option value="">Select</option>');
            for(var i =0;i <= data.length-1;i++)
            {
                $('select[name=product_name]').append('<option value="'+data[i].id+'">'+data[i].name+' - '+data[i].id+'</option>');
            }
        },
        error: function(){},
        complete: function () {
            $("#overlay").hide();
        }
    });
});

$("#searchAccount").submit(function (element){
    element.preventDefault();

    var form = $(this);
    var url = form.attr("action");
    var data =new FormData(form[0]);
$.ajax({
    url: url,
    type: 'POST',
    data: data,
    cache: false,
    processData: false,
    contentType: false,
    beforeSend: function (){
    $("#overlay").show();
    },
    success: function (response){
        console.log(response.data);
        if (response.status == 200)
        {
            $("#searchResult").html('');
            var status = 'Block';
            for(var i =0;i <= response.data.length-1;i++)
            {
                if (response.data[i].status == 1)
                {
                    status = 'Active';
                }
                $("#searchResult").append('<tr><td>'+(i + 1)+'</td><td>'+response.data[i].account_no+'</td><td>'+response.data[i].full_name+'</td><td>'+response.data[i].father_name+'</td><td>'+response.data[i].village+'</td><td>'+response.data[i].contact_no+'</td></tr>');
            }
        }
        else {
            $("#searchResult").html('');
        }
    },
    complete: function (){
        $("#overlay").hide();
    }
});
})
$(".searchDailyCash").on('change', function (element){
    element.preventDefault();

    var form = $("#searchDailyCash");
    var url = form.attr("action");
    var data =new FormData(form[0]);

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function (){
            $("#overlay").show();
        },
        success: function (response){
            console.log(response.data);
            if (response.status == 200)
            {
                $('input[name=SelectedDate]').val(response.data.selectDate);
                $('#searchDate').text(response.data.searchDate);

               $('input[name=TwoThousand]').val(response.data.c1);
               $("#TwoThousand").text('= '+response.data.v1);

                $('input[name=FiveHundred]').val(response.data.c2);
                $("#FiveHundred").text('= '+response.data.v2);

                $('input[name=TwoHundred]').val(response.data.c3);
                $("#TwoHundred").text('= '+response.data.v3);

                $('input[name=OneHundred]').val(response.data.c4);
                $("#OneHundred").text('= '+response.data.v4);

                $('input[name=Fifty]').val(response.data.c5);
                $("#Fifty").text('= '+response.data.v5);

                $('input[name=Twenty]').val(response.data.c6);
                $("#Twenty").text('= '+response.data.v6);

                $('input[name=Ten]').val(response.data.c7);
                $("#Ten").text('= '+response.data.v7);

                $('input[name=Five]').val(response.data.c8);
                $("#Five").text('= '+response.data.v8);

                $('input[name=Two]').val(response.data.c9);
                $("#Two").text('= '+response.data.v9);

                $('input[name=One]').val(response.data.c10);
                $("#One").text('= '+response.data.v10);

                $('input[name=Paisa]').val(response.data.c11);
                $("#Paisa").text('= '+response.data.v11);
                var coinSubTotal = (parseFloat(response.data.v1) + parseFloat(response.data.v2) + parseFloat(response.data.v3) + parseFloat(response.data.v4) + parseFloat(response.data.v5) + parseFloat(response.data.v6) + parseFloat(response.data.v7) + parseFloat(response.data.v8) + parseFloat(response.data.v9) + parseFloat(response.data.v10) + parseFloat(response.data.v11));
                $("#subTotal").text(coinSubTotal);

                var different = ((+response.data.searchDate) - (+coinSubTotal)).toFixed(2);

                $("#different").html(different);

            }
        },
        complete: function (){
            $("#overlay").hide();
        }
    });
})

function calculateCoin(val,coin,postId)
{
    var systemCoin = val.value;
    var userCoin = coin;

    if (postId == 'Paisa')
    {
        var total = parseFloat(systemCoin / userCoin).toFixed(2);
    }
    else {
        var total = parseFloat(systemCoin * userCoin).toFixed(2);
    }

    $("#"+postId).text('= '+total);
    $("#subTotal").html(0);
}


$("#searchDailyCashUpdate").submit(function (element){
    element.preventDefault();

    var form = $(this);
    var url = form.attr("action");
    var data =new FormData(form[0]);

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function (){
            $("#overlay").show();
        },
        success: function (response){
            console.log(response.data);
            if (response.status == 200)
            {
                alert(response.data);
            }
        },
        complete: function (){
            $("#overlay").hide();
        }
    });
})

$("#calculateTotalDeiff").on('click',function (){
    var cash = $("#searchDate").html();
    var TwoThousand = (parseFloat($("input[name=TwoThousand]").val()) * 2000).toFixed(2);
    var FiveHundred = (parseFloat($("input[name=FiveHundred]").val()) * 500).toFixed(2);
    var TwoHundred = (parseFloat($("input[name=TwoHundred]").val()) * 200).toFixed(2);
    var OneHundred = (parseFloat($("input[name=OneHundred]").val()) * 100).toFixed(2);
    var Fifty = (parseFloat($("input[name=Fifty]").val()) * 50).toFixed(2);
    var Twenty = (parseFloat($("input[name=Twenty]").val()) * 20).toFixed(2);
    var Ten = (parseFloat($("input[name=Ten]").val()) * 10).toFixed(2);
    var Five = (parseFloat($("input[name=Five]").val()) * 5).toFixed(2);
    var Two = (parseFloat($("input[name=Two]").val()) * 2).toFixed(2);
    var One = (parseFloat($("input[name=One]").val()) * 1).toFixed(2);
    var Paisa = (parseFloat($("input[name=Paisa]").val()) * 0.01).toFixed(2);
    var SubTotal = ((+TwoThousand) + (+FiveHundred) + (+TwoHundred) + (+OneHundred) + (+Fifty) + (+Twenty) + (+Ten) + (+Five) + (+Two) + (+One) + (+Paisa));
    var different = ((+cash) - (+SubTotal)).toFixed(2);
    $("#subTotal").html(SubTotal);
    $("#different").html(different);
});

$('input[name="matured_on_date"]').on('change', function (){
   let mod = $(this).val();
   let md = $('input[name="maturity_date"]').val();
   let days = dateDifference(mod,md);
    if (days < 0)
    {
        $("#submit_btn").html('<i class="fa fa-save" aria-hidden="true"></i> PreMature');
        $("#premature_interest").removeClass('hidden');
        $('input[name="premature_interest_rate"]').attr('disabled',false);
    }
    else {
        $("#submit_btn").html('<i class="fa fa-save" aria-hidden="true"></i> Mature');
        $("#premature_interest").addClass('hidden');
        $('input[name="premature_interest_rate"]').attr('disabled',true);
    }
});

$(document).ready(function (){
    let mod = $('input[name="matured_on_date"]').val();
    let md = $('input[name="maturity_date"]').val();
    let days = dateDifference(mod,md);
    if (days < 0)
    {
        $("#submit_btn").html('<i class="fa fa-save" aria-hidden="true"></i> PreMature');
        $("#premature_interest").removeClass('hidden');
        $('input[name="premature_interest_rate"]').attr('disabled',false);
    }
    else {
        $("#submit_btn").html('<i class="fa fa-save" aria-hidden="true"></i> Mature');
        $("#premature_interest").addClass('hidden');
        $('input[name="premature_interest_rate"]').attr('disabled',true);
    }
});

function dateDifference(date1,date2)
{
    date1 = new Date(date1);
    date2 = new Date(date2);
    var milli_secs = date1.getTime() - date2.getTime();
    // Convert the milli seconds to Days
    var days = milli_secs / (1000 * 3600 * 24);
    // var count_days = Math.round(Math.abs(days));
    return days;
}

$('input[name="maturity_amount"]').on('change', function (){
    let ma = $(this).val();
    let fa = $('input[name="fd_amount"]').val();
    let int = (ma - fa);
    $("#maturity_value").html("FD = " +fa+ ", Interest = " +int);
});

$('input[name="premature_interest_rate"]').on('change', function (){
    let interest_rate = $(this).val();
    let fa = parseFloat($('input[name="fd_amount"]').val());
    var start= $(".int_from_date").val();
    var end= $('input[name="matured_on_date"]').val();
    var days = dateDifference(end,start);

    var x = (fa + Math.round(fa * ((interest_rate * days) / 36500)));
    if (days < 0)
    {
        x = fa;
    }else {
        x = isNaN(x) ? '0' : x;
    }
    $('input[name="maturity_amount"]').val(x);

    let int = (x - fa);
    $("#maturity_value").html("FD = " +fa+ ", Interest = " +int);
});

