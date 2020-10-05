<?php
defined('BASEPATH') OR exit('No direct script access allowed');

trait security_trait {

	private function check_securities(){
		if($this->xss_clean_form_data ==  true) $this->sanitize_data();
		$this->black_list();
		$this->white_list();
		//pr($_POST);
	}

	private function black_list(){
		$current_method = $this->router->method;
		if(function_exists('blacklist_columns')){
		 	$getBlacklistData = blacklist_columns($current_method);
		 	$getBlacklistData = array_merge($getBlacklistData,$this->system_blacklist_columns($current_method));
		 	$action = 'blacklisted';
		}else{
			$getBlacklistData = $this->system_blacklist_columns($current_method);
			$action = 'blacklisted';
		}
		if(!empty($getBlacklistData)) 
			$this->unset_blacklist_fields($getBlacklistData);
	}

	private function white_list(){
		$current_method = $this->router->method;
		if(function_exists('whitelist_columns')){
			$getWhiteData = whitelist_columns($current_method);
			if(!empty($getWhiteData))
				$this->set_whitelist_fields($getWhiteData);
		}
	}

	private function unset_blacklist_fields($column_array){
		foreach ($column_array as $column_key => $column_value) {
			foreach($_POST as $post_index => $post_value){
				if(is_array($post_value) && in_array($column_value,array_keys($_POST[$post_index])))
					unset($_POST[$post_index][$column_value]);
			}
		}
	}

	private function set_whitelist_fields($column_array){
		$post_data_set = array();
		foreach ($column_array as $column_key => $column_value) {
			$array_keys_post = 	array_keys($_POST);
			foreach($array_keys_post as $post_keys => $post_keys_values){
				if(is_array($_POST[$post_keys_values]))
					$get_keys_post_data = array_keys($_POST[$post_keys_values]);
				if(!empty($_POST[$post_keys_values]) && is_array($_POST[$post_keys_values]) && 
					in_array($column_value,$get_keys_post_data)){
						$post_data_set[$post_keys_values][$column_value] = 
																													$_POST[$post_keys_values][$column_value];
				}
				if(!is_array($_POST[$post_keys_values]))
					$post_data_set[$post_keys_values] = $_POST[$post_keys_values];	
			}
		}
		$_POST = $post_data_set;
	}


  private function sanitize_data(){
  	$sanitize_data = array();
  	foreach($_POST as $post_index => $post_value){
  		if(is_array($post_value)){
				foreach($post_value as $post_key => $values){
					if(!empty($this->non_sanitize_fields) && in_array($post_key,$this->non_sanitize_fields) ==  FALSE)
						$sanitize_data[$post_index][$post_key] = $values;
					else{
						$sanitize_data[$post_index][$post_key] = $this->security->xss_clean($values);
					}
				}
			}else $sanitize_data[$post_index] = $post_value;
		}
		
		$_POST = $sanitize_data;
  }

  private function system_blacklist_columns($action){
  	$blacklist['store'] = array('id','created_at','created_by','is_delete','updated_by','updated_at');
  	$blacklist['update'] = array('created_at','created_by','updated_at','updated_by','is_delete');
  	return $blacklist[$action];
  }

}