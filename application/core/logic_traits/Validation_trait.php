<?php
defined('BASEPATH') OR exit('No direct script access allowed');

trait Validation_trait {

  public function check_unique($field_name) {
    if(is_array($field_name)){
      foreach ($field_name as $field){
        $where[$field] = $this->attributes[$field];
      }
    }else{
      $where = array($field_name => $this->attributes[$field_name]);
    }
    if(isset($this->attributes['id']))
      $where['id!='] = $this->attributes['id'];
    $result = $this->find('id', $where);
    return (empty($result)) ? true : false;
  }

  public function equal_to_zero($value) {
    return ($value==0);
  }

  public function check_file_is_attached($field_name) {
    return (!empty($_FILES[$this->router->class]['name'][$field_name]));
  }

  public function check_file_extension($field_name, $allowed_extensions) {
    $extension = strtoupper(pathinfo($_FILES[$this->router->class]['name'][$field_name], PATHINFO_EXTENSION));
    return in_array($extension, $allowed_extensions);
  } 

  public function check_excel_headers($field_name, $table_names) {
    $result = $this->excel_lib->validate_headers($this->filedata, $field_name, $table_names);
    if ($result['status'] == 'failure') {
      $error_message = implode(", ", array_values($result['errors']));
      $this->form_validation->set_message(array('validate_excel_headers' => 'Invalid headers found: '.$error_message));
      return false;
    } else
      return true;
  }

  public function add_prefix_to_validation_rules($field_prefix, $validation_klass='') {
    $rules = $this->validation_rules($validation_klass);
    $bulk_rules = array();
    foreach ($rules as $rule) {
      $rule['field'] = $field_prefix.$rule['field'];
      $bulk_rules[] = $rule;
    } 
    return $bulk_rules;
  }

  public function add_controller_to_validation_rules($controller_name, $validation_klass='', $rules = array()) {
    if (empty($rules))
      $rules = $this->validation_rules($validation_klass);
    $bulk_rules = array();
    foreach ($rules as $rule) {
      $rule['field'] = $controller_name.'['.$rule['field'].']';
      $bulk_rules[] = $rule;
    }
    return $bulk_rules;
  } 

}
