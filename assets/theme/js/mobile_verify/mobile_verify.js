$(document).ready(function(){
	$(".send_sms").click(function(){
		var url=$("#base_url").val();
		var send_url=url+'users/user_mobile_verify/update/0';
		formData = new FormData();
		formData.append('user_mobile_verify[verify_code]', '1');
		ajax_post_request(send_url,formData);
	});
});
