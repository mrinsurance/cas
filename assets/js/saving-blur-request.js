//delete product and remove it from list
$("#membertype_id").on('change',function(){
	$(this).closest('form').find('.ac_no, .amount').val('');
	$('#error_part').addClass('hide');
	$('#success_part').addClass('hide');
	$("#view_ac").attr('href','#');							
});

function getRdRecord(id){
	var product_id = id;
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
			success: function (response) {

				$(".branch").val('');
				if(response.status == 201){
					$('#error_part').removeClass('hide');
					$('#success_part').addClass('hide');
					$("#error_result").html(response.error);
					$("#view_ac").attr({'href':'#','disabled':true});		
					$("#result_balance").html('<i class="fa fa-fw fa-inr"></i>');	
					$('button[type="submit"]').attr("disabled",true);


				}else if(response.status == 200)
				{

					$('#success_part').removeClass('hide');
					$('#error_part').addClass('hide');
					$("#open_ac_id").val(response['success'].open_ac_id);
    				$("#result_full_name").html(response['success'].full_name);
					$("#result_father").html(response['success'].father_name);
					$("#result_address").html(response['success'].address);
					$("#lf_no").html(response['success'].lf_no);
					$("#result_branch").html(response['success'].branch);
					$("#preview").html('<img src="'+response['success'].priview+'" width="150" class="img-responsive" alt="">');
    				$("#sign").html('<img src="'+response['success'].signature+'" width="150" class="img-responsive" alt="">');
					$("#view_ac").attr({'href':response['success'].view_ac_url,'disabled':false});
					$("#ledger_id").attr({'href':response['success'].pl_url,'disabled':false});
					$("#result_balance").html('<i class="fa fa-fw fa-inr"></i>'+response['success'].balance);
					$("#result_balance").html('<i class="fa fa-fw fa-inr"></i>'+response['success'].balance);
					$('button[type="submit"]').attr("disabled",false);

					var res='';
					let bal = 0;
					$.each (response.success.items, function (key, value) {
						if (value.type_of_transaction == 'Deposit')
						{
							bal = bal + (+value.amount);
						}if (value.type_of_transaction == 'Withdrawal')
						{
							bal = bal - (+value.amount);
						}

						res +=
							'<tr>'+
							'<td>'+moment(value.date_of_transaction).format('DD-MM-YYYY')+'</td>'+
							'<td>'+ (value.type_of_transaction === "Deposit" ? value.amount : "") +'</td>'+
							'<td>'+ (value.type_of_transaction === "Withdrawal" ? value.amount : "") +'</td>'+
							'<td>'+bal+'</td>'+
							'</tr>';
					});
					$('.loadTableData').html(res);
				}else
				{
					$('#error_part').removeClass('hide');
					$('#success_part').addClass('hide');
					$("#error_result").html(response.error);
					$("#view_ac").attr({'href':'#','disabled':true});		
					$("#ledger_id").attr({'href':'#','disabled':true});		
					$("#result_balance").html('<i class="fa fa-fw fa-inr"></i>');	
					$('button[type="submit"]').attr("disabled",true);
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
		
};

// jQuery ".Class" SELECTOR.
$(document).ready(function() {
	$('.groupOfTexbox').keypress(function (event) {
		return isNumber(event, this)
	});
});
// THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
function isNumber(evt, element) {

	var charCode = (evt.which) ? evt.which : event.keyCode

	if (
		(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
		(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
		(charCode < 48 || charCode > 57))
		return false;

	return true;
}
