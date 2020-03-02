<?php 
  $layout = (isset($this->_ci_cached_vars['index_layout'])?$this->_ci_cached_vars['index_layout']:'application');
	$page_details =  getTableSettings();
	  $data['table_name'] = $page_details['primary_table'];
	  $data['checkbox_option'] = (isset($page_details['checkbox_in_listing']) 
	  && !empty($page_details['checkbox_in_listing']));
	if ($data['checkbox_option']) {
    $data['multiselect_controller'] = $page_details['checkbox_in_listing']['controller'];
    $data['multiselect_action'] = $page_details['checkbox_in_listing']['action'];
    $data['action_url'] = $GLOBALS['CFG']->base_url().$data['multiselect_controller'].'/'.$data['multiselect_action'];
  }


  if (!empty($type))
    $data['filter_details'] = '';
  else
    $data['filter_details'] = '';
    if ($filter_columns != '' && is_array($filter_columns)) {
      $data['tablehead']  = gettableheaders($filter_columns);
      $data['table_data'] = getTableData($html, $filter_columns);
    } else {
      $data['tablehead']  = gettableheaders('list_settings');
      $data['table_data'] = getTableData($html, 'list_settings');
    }

	$this->load->view('layouts/'.$layout.'/list/thead',$data);
  $this->load->view('layouts/'.$layout.'/list/tbody',$data);

?>