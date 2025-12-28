//delete product and remove it from list
$(document).on('click','.delete-product',function(){
	var product_id = $("#prd_id").val();
	
	// var postURL = "{{asset('admin/mail-enquiry/apply-previlege-card')}}/"+product_id;   
	var postURL = $(this).val();
		
		bootbox.confirm("Are you sure want to delete?", function(result) {
			if(result){
				console.log('Delete');
				$.ajax({
					type: "DELETE",
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					data: {"_method": 'DELETE'},
					url: postURL,
					beforeSend: function () { 
            $("#overlay").show();
        },
						success: function (data) {
							if(data.success){
								$("#product" + product_id).remove();
								$(".print-success-msg").find("ul").html('');
								$(".print-success-msg").css('display','block');
								$(".print-error-msg").css('display','none');
								$(".print-success-msg").find("ul").append('<li>The record has been deleted successfully.</li>');
								location.reload();
							}else{
								$(".print-error-msg").find("ul").html('');
								$(".print-error-msg").css('display','block');
								$(".print-success-msg").css('display','none');
								$(".print-error-msg").find("ul").append("<li>Opps! You can't delete this record right now</li>");						
							}
						},
            error: function (jqXHR, textStatus, errorThrown) {
            $("#overlay").hide();
            printErrorMsg(data.error);
            },
            complete: function () {
              $("#overlay").hide();
            }
				});
			}
			else
			{
				console.log('Cancel');
			}
		});
});
