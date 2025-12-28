//delete product and remove it from list
$(document).on('click','.delete-product',function(){
	var product_id = $(this).val();
	// var postURL = "{{asset('admin/mail-enquiry/apply-previlege-card')}}/"+product_id;   
	var postURL = window.location.href+""+product_id;
		
		bootbox.confirm("Are you sure want to delete?", function(result) {
			if(result){
				console.log('Delete');
				$.ajax({
					type: "DELETE",
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					data: {"_method": 'DELETE'},
					url: postURL,
						success: function (data) {
							if(data.error){
								printErrorMsg(data.error);
							}else if(data.success){
								$("#product" + product_id).remove();
								$(".print-success-msg").find("ul").html('');
								$(".print-success-msg").css('display','block');
								$(".print-error-msg").css('display','none');
								$(".print-success-msg").find("ul").append('<li>The record has been deleted successfully.</li>');
								
							}else{
								$(".print-error-msg").find("ul").html('');
								$(".print-error-msg").css('display','block');
								$(".print-success-msg").css('display','none');
								$(".print-error-msg").find("ul").append("<li>Opps! You can't delete this record right now</li>");						
							}
							setTimeout(
				                    function(){
				                        window.location.reload();
				                    },
				                100);
						}
				});
			}
			else
			{
				console.log('Cancel');
			}
		});
});
function printErrorMsg (msg) {
	$(".print-error-msg").find("ul").html('');
	$(".print-error-msg").css('display','block');
	$(".print-success-msg").css('display','none');
		$.each( msg, function( key, value ) {
			$(".print-error-msg").find("ul").append('<li>'+value+'</li>');
		});
}