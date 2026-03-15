$(document).ready(function(){
	$(".send_email").click(function(){
		var url=$("#base_url").val();
		var send_url=url+'users/user_email_verify/update/0';
		formData = new FormData();
		formData.append('user_email_verify[verify_code]', '1');
		ajax_post_request(send_url,formData);
	});
});
