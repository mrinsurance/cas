function getDistictByState(id,route)
{
    var id = id.value;
    var url = route+'?id='+id;
    $.ajax({
        type:"GET",
        url:url,
        beforeSend: function (){
            $("#overlay").show();
        },
        success: function(response){
            $('.current_district').html('<option value="">--- Select ---</option>');
            for(var i =0;i <= response.length-1;i++)
            {
                console.log(response[i].id);
                $('.current_district').append('<option value="'+response[i].id+'">'+response[i].name+'</option>');
            }
        },
        error: function(){},
        complete: function () {
            $("#overlay").hide();
        }
    });
}

function getPatwarByDistrict(id,route)
{
    var id = id.value;
    var url = route+'?id='+id;
    $.ajax({
        type:"GET",
        url:url,
        beforeSend: function (){
            $("#overlay").show();
        },
        success: function(response){
            $('.patwar').html('<option value="">--- Select ---</option>');
            for(var i =0;i <= response.length-1;i++)
            {
                console.log(response[i].id);
                $('.patwar').append('<option value="'+response[i].id+'">'+response[i].name+'</option>');
            }
        },
        error: function(){},
        complete: function () {
            $("#overlay").hide();
        }
    });
}

function getPanchayatByPatwar(id,route)
{
    var id = id.value;
    var url = route+'?id='+id;
    $.ajax({
        type:"GET",
        url:url,
        beforeSend: function (){
            $("#overlay").show();
        },
        success: function(response){
            $('.panchayat').html('<option value="">--- Select ---</option>');
            for(var i =0;i <= response.length-1;i++)
            {
                console.log(response[i].id);
                $('.panchayat').append('<option value="'+response[i].id+'">'+response[i].name+'</option>');
            }
        },
        error: function(){},
        complete: function () {
            $("#overlay").hide();
        }
    });
}

function getVillageByPanchayat(id,route)
{
    var id = id.value;
    var url = route+'?id='+id;
    $.ajax({
        type:"GET",
        url:url,
        beforeSend: function (){
            $("#overlay").show();
        },
        success: function(response){
            $('.village').html('<option value="">--- Select ---</option>');
            for(var i =0;i <= response.length-1;i++)
            {
                console.log(response[i].id);
                $('.village').append('<option value="'+response[i].id+'">'+response[i].name+'</option>');
            }
        },
        error: function(){},
        complete: function () {
            $("#overlay").hide();
        }
    });
}
