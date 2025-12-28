$("#edit_frm").submit(function(e){
    e.preventDefault();
    var form = $(this);
    var url = form.attr("action");
    var data = new FormData(form[0]);
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        cache: false,
        processData: false,
        contentType : false,
        beforeSend: function () { 
          $("#overlay").show();
            $('.print-warning-msg').css('display','block');
            $(".print-success-msg").css('display','none');
            $(".print-error-msg").css('display','none');
        },
        success: function (data) {
            
            // console.log(data);
            if(data.error_msg)
            {
               customErrorMsg(data.error_msg);
            }
            else if(data.error){
                printErrorMsg(data.error,data.sec_key);
            }
           else{
                var $seckey = [];
                 $.each( data.sec_key, function( key, value ) {
                    $seckey.push(key);
                 });
                for(var len = 0; len <= $seckey.length; len++)
                 {
                    $("#"+$seckey[len]).html('');
                    $("."+$seckey[len]).removeClass('has-error');   
                 }
                
                $(".print-success-msg").find("ul").html('');
                $(".print-success-msg").css('display','block');
                $(".print-error-msg").css('display','none');
                $(".print-success-msg").find("ul").append(data.success);
                setTimeout(
                    function(){
                        location.href=data.return_url;
                    },
                2000);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          $("#overlay").hide();
            console.log(jqXHR, textStatus, errorThrown);
        },
        complete: function () {
          $("#overlay").hide();
        $('.print-warning-msg').css('display','none');
        }
    });
});
function printErrorMsg (msg,seckey) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $(".print-success-msg").css('display','none');
    $(".print-error-msg").find("ul").append('<li>Please fill in required fields</li>');
    
    var $seckey = [];
         $.each( seckey, function( key, value ) {
            $seckey.push(key);
         });
         for(var len = 0; len <= $seckey.length; len++)
         {
            $("#"+$seckey[len]).html('');
            $("."+$seckey[len]).removeClass('has-error');   
         }
         $.each( msg, function( key, value ) {
             if(jQuery.inArray($seckey,key))
             {
                $("#"+key).append(value);
                $("."+key).addClass('has-error');
                //$("."+key).find('input').focus();
             }
         });
      }
      function customErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $(".print-success-msg").css('display','none');
    $(".print-error-msg").find("ul").append('<li>'+msg+'</li>');

      }