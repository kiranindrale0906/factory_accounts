
<?php 
	if($this->input->is_ajax_request() == true)$is_ajax = true;
	else $is_ajax = 0;

?>
<a href="javascript:void(0);" onclick="searchpopup('<?=base_url()?>','<?=$k?>','<?=$headingFunction ?>' ,'<?=$search_url ?>','<?=$current_url?>','<?=$module?>','<?=$search_param?>','<?=$query_string?>','<?=$dashboard_id?>','<?=$is_ajax;?>')"><i class="fa fa-filter gray" aria-hidden="true"></i></a>

