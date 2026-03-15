function save_helptext(){
	$(".save_helptext").each(function(){  
		$(this).click(function(e){
			e.preventDefault();
			var saveUrl = $(this).attr('url');
			var data_id = $(this).attr('data-id');
			var value 	= $(".helptext_area"+data_id).val();
			var id 			= $(".help_text_id"+data_id).attr('value');
			var formdata = new FormData();
			formdata.append('help_texts[help_text]',$.trim(value)); 
			formdata.append('help_texts[id]',$.trim(id)); 
			ajax_post_request(saveUrl,formdata,0);
			$(".text-replace"+data_id).text(value);
		});
	});
}