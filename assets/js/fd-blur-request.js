//delete product and remove it from list
$("#membertype_id").on('change',function(){
	$(this).closest('form').find('.ac_no, .amount, .cheque_number').val('');
	$('#error_part').addClass('hide');
	$('#success_part').addClass('hide');
	$("#view_ac").attr('href','#');							
});
$(document).on('blur','#ac_no',function(){
	var product_id = $(this).val();
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

var len = 0;
           $('#userTable').empty(); // Empty <tbody>
           if(data['list'] != null){
             len = data['list'].length;
           }

           if(len > 0){
             for(var i=0; i<len; i++){
               var id = data['list'][i].id;
               var fd_no = data['list'][i].fd_no;
               var amount = data['list'][i].amount;
               var int_rate = data['list'][i].int_rate;
               var int_run_from = data['list'][i].int_run_from;
               var transaction_date = data['list'][i].transaction_date;
               var period_fd = data['list'][i].period_fd;
               var maturity_date = data['list'][i].maturity_date;
               var matured_on_date = data['list'][i].matured_on_date;
               var maturity_amount = data['list'][i].maturity_amount;
               var status = data['list'][i].status;
               var edit_url = data['success'].base_url+"/transaction/fixed-deposite/"+id+"/edit";
               if(status == 1)
               {
               	var fd_status = '<button type="button" class="btn btn-success btn-sm">Active</button>';
               }
               else
               {
               	var fd_status = '<button type="button" class="btn btn-danger btn-sm">Matured</button>';
               }
               var tr_str = "<tr>" +
                   "<td align='center'>" + (i+1) + "</td>" +
                   "<td align='center'>" + fd_no + "</td>" +
                   "<td align='center'>" + fd_status + "</td>" +
                   "<td align='center'><a href='"+edit_url+"' class='btn btn-primary btn-sm'><i class='fa fa-pencil'></i> Edit</a></td>" +
                   "<td align='center'>" + amount + "</td>" +
                   "<td align='center'>" + int_rate + "</td>" +
                   "<td align='center'>" + int_run_from + "</td>" +
                   "<td align='center'>" + transaction_date + "</td>" +
                   "<td align='center'>" + period_fd + "</td>" +
                   "<td align='center'>" + maturity_date + "</td>" +
                   "<td align='center'>" + matured_on_date + "</td>" +
                   "<td align='center'>" + maturity_amount + "</td>" +
                   "<td align='center'></td>"                   
                "</tr>";

               $("#userTable").append(tr_str);
             }
           }else{
              var tr_str = "<tr>" +
                  "<td colspan='13' class='text-center'>No record found.</td>" +
              "</tr>";

              $("#userTable").append(tr_str);
           }


							$(".branch").val('');
							if(data.error){
								$('#error_part').removeClass('hide');
								$('#success_part').addClass('hide');
								$("#error_result").html(data.error);
								$("#view_ac").attr('href','#');	
								$("#result_balance").html('&#8377;0');	
								$("#submit_btn").attr("disabled",true);

							}else if(data.success){
								$('#success_part').removeClass('hide');
								$('#error_part').addClass('hide');
								$("#open_ac_id").val(data['success'].open_ac_id);
                $("#result_full_name").html(data['success'].full_name);
								$("#result_father").html(data['success'].father_name);
								$("#result_address").html(data['success'].address);
								$("#result_branch").html(data['success'].branch);
								$("#preview").html('<img src="'+data['success'].priview+'" height="150" class="img-responsive" alt="">');
                $("#sign").html('<img src="'+data['success'].signature+'" height="150" class="img-responsive" alt="">');
								$("#view_ac").attr('href',data['success'].view_ac_url);
								$("#result_balance").html('&#8377;'+data['success'].paid_interest);
								$("#submit_btn").attr("disabled",false);
							}else{
								$('#error_part').removeClass('hide');
								$('#success_part').addClass('hide');
								$("#error_result").html(data.error);
								$("#view_ac").attr('href','#');		
								$("#result_balance").html('&#8377;0');
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
