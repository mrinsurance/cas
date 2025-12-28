
$(window).load(function(){
	var product_id = $('#ac_no').val();
	var member_id = $("#membertype_id").val();
	var postURL = $("#ajax_url").val();
	// var postURL = "{{asset('admin/mail-enquiry/apply-previlege-card')}}/"+product_id;   
		
				$.ajax({
					type: "POST",
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					data: {"_method": 'POST',"ac_no": product_id, "member_id": member_id},
					dataType: 'json',
					url: postURL,
          beforeSend: function () { 
            $("#overlay").show();
        },
						success: function (data) {
							// console.log(data['list'].length);

							$(".branch").val('');
							if(data.error){
								$('#error_part').removeClass('hide');
								$('#success_part').addClass('hide');
								$("#error_result").html(data.error);
								$("#view_ac").attr('href','#');	
								$("#result_balance").html('&#8377;0');	
								$("#result_share_balance").html('&#8377;0');
								$(".result_share_balance").val('');
								$("#submit_btn").attr("disabled",true);

							}else if(data.success){
								$('#success_part').removeClass('hide');
								$('#error_part').addClass('hide');
								$("#open_ac_id").val(data['success'].open_ac_id);
                				$("#result_full_name").html(data['success'].full_name);
								$("#result_father").html(data['success'].father_name);
								$("#result_address").html(data['success'].address);
								$("#lf_no").html(data['success'].lf_no);
								$("#result_branch").html(data['success'].branch);
								$("#preview").html('<img src="'+data['success'].priview+'" height="150" class="img-responsive" alt="">');
                				$("#sign").html('<img src="'+data['success'].signature+'" height="150" class="img-responsive" alt="">');
								$("#view_ac").attr('href',data['success'].view_ac_url);
								$("#result_balance").html('&#8377;'+data['success'].balance);
								$("#result_share_balance").html('&#8377;'+data['success'].share_balance);
								$(".result_share_balance").val(data['success'].share_balance);
								$("#submit_btn").attr("disabled",false);
							}else{
								$('#error_part').removeClass('hide');
								$('#success_part').addClass('hide');
								$("#error_result").html(data.error);
								$("#view_ac").attr('href','#');		
								$("#result_balance").html('&#8377;0');
								$("#result_share_balance").html('&#8377;0');
								$("#result_share_balance").val('');
								$("#submit_btn").attr("disabled",true);
							}
						},
            error: function (jqXHR, textStatus, errorThrown) {
            $("#overlay").hide();
            console.log(jqXHR, textStatus, errorThrown);
            },
            complete: function () {
              $("#overlay").hide();
            }
				});
		
});

function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;

   return true;
} 
