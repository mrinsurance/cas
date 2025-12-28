//delete product and remove it from list
$("#membertype_id").on('change',function(){
	$(this).closest('form').find('.ac_no, .amount').val('');
	$('#error_part').addClass('hide');
	$('#success_part').addClass('hide');
	$("#view_ac").attr('href','#');							
});

function getRdRecord(id){
	var product_id = id;
	var postURL = $("#ajax_url").val();

	$.ajax({
		type: "GET",
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: {"_method": 'GET',"rd_no": product_id},
		dataType: 'json',
		url: postURL,
		beforeSend: function () {
			$("#overlay").show();
		},
		success: function (data) {
			console.log(data);
			if (data.status == 200)
			{
				$("input[name=memberType]").val(data.memberType);
				$("input[name=accountNo]").val(data.accountNo);
				$("#branch").html(data.branch);
				$("#memberName").html(data.memberName);
				$("#fatherName").html(data.fatherName);
				$("#address").html(data.address);
				$("#lfNo").html(data.lfNo);
				$("#rdAmount").html(data.rdAmount);
				$("#interestRate").html(data.interestRate);
				$("#rdDate").html(moment(data.rdDate).format('DD-MM-YYYY'));
				$("#periodOfRd").html(data.periodOfRd);
				$("#maturityDate").html(moment(data.maturityDate).format('DD-MM-YYYY'));
				$("#maturedOnDate").html(moment(data.maturedOnDate).format('DD-MM-YYYY'));
				$("#maturityAmount").html(data.maturityAmount);
				if (data.maturity_status == false)
				{
					$(':input[type="submit"]').prop('disabled',true);
				}else
				{
					$(':input[type="submit"]').prop('disabled',false);
				}
				var res='';
				let bal = 0;
				$.each (data.transactionList, function (key, value) {
					bal = bal + value.amount;
					res +=
						'<tr>'+
						'<td>'+moment(value.installment_date).format('DD-MM-YYYY')+'</td>'+
						'<td>'+value.amount+'</td>'+
						'<td>'+bal+'</td>'+
						'</tr>';
				});
				$('.loadTableData').html(res);
			}
			else {
				alert('No record found!');
				$("input[name=memberType]").val('');
				$("input[name=accountNo]").val('');
				$("#branch").html('');
				$("#memberName").html('');
				$("#fatherName").html('');
				$("#address").html('');
				$("#lfNo").html('');
				$("#amount").html('');
				$("#interestRate").html('');
				$("#rdDate").html('');
				$("#periodOfRd").html('');
				$("#maturityDate").html('');
				$("#maturedOnDate").html('');
				$("#maturityAmount").html('');
				$('.loadTableData').html('');
			}
			// $(".branch").val('');
			/*if(data.error){
				$('#error_part').removeClass('hide');
				$('#success_part').addClass('hide');
				$("#error_result").html(data.error);
				$("#view_ac").attr({'href':'#','disabled':true});
				$("#result_balance").html('<i class="fa fa-fw fa-inr"></i>');
				$("#submit_btn").attr("disabled",true);

			}else if(data.success)
			{
				$('#success_part').removeClass('hide');
				$('#error_part').addClass('hide');
				$("#open_ac_id").val(data['success'].open_ac_id);
				$("#result_full_name").html(data['success'].full_name);
				$("#result_father").html(data['success'].father_name);
				$("#result_address").html(data['success'].address);
				$("#lf_no").html(data['success'].lf_no);
				$("#result_branch").html(data['success'].branch);
				$("#preview").html('<img src="'+data['success'].priview+'" width="150" class="img-responsive" alt="">');
				$("#sign").html('<img src="'+data['success'].signature+'" width="150" class="img-responsive" alt="">');
				$("#view_ac").attr({'href':data['success'].view_ac_url,'disabled':false});
				$("#ledger_id").attr({'href':data['success'].pl_url,'disabled':false});
				$("#result_balance").html('<i class="fa fa-fw fa-inr"></i>'+data['success'].balance);
				$("#result_balance").html('<i class="fa fa-fw fa-inr"></i>'+data['success'].balance);
				$("#submit_btn").attr("disabled",false);
				$("#loadTable").load(" #loadTableData");
			}else
			{
				$('#error_part').removeClass('hide');
				$('#success_part').addClass('hide');
				$("#error_result").html(data.error);
				$("#view_ac").attr({'href':'#','disabled':true});
				$("#ledger_id").attr({'href':'#','disabled':true});
				$("#result_balance").html('<i class="fa fa-fw fa-inr"></i>');
				$("#submit_btn").attr("disabled",true);
			}*/
		},
		error: function (jqXHR, textStatus, errorThrown) {
			$("#overlay").hide();
			console.log(jqXHR, textStatus, errorThrown);
		},
		complete: function () {
			$("#overlay").hide();
		}
	});

}


function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;

   return true;
} 
