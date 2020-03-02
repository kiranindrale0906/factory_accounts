<?php
defined('BASEPATH') OR exit('No direct script access allowed');
trait Sync_trait {

	function mapping_fields($method,$uniq_column='',$count_col){
		$new_data = $this->get_emkay_data->select_data_array($method,$count_col);
		if(!empty(api_modified_fields())) $old_data = $this->get(api_modified_fields()); else $old_data = '';

		unset($this->formdata_batch['created_at']);
		foreach($new_data as $script_key => $script_value){
	    foreach(api_non_modified_fields() as $get_api_key 		=> $get_api_value){
	    	$this->formdata_batch[$script_key][$get_api_key] = $script_value->$get_api_value;
	    }

	    if(!empty($old_data)){
		    foreach ($old_data as $old_key => $old_value) {
		      if($old_value[$uniq_column] == $script_value->Scrss_cd){
	    			foreach(api_modified_fields() as $get_custom_key => $get_custom_value){
			        $this->formdata_batch[$script_key][$get_custom_value] =  $old_data[$script_key][$get_custom_value]; 
		      	}
		    	}
		    }
		  }
		  $this->formdata_batch[$script_key]['created_at']    = datetime();
  	}
	}
}
?>