<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function get_field_data($data, $router, $record) {
  if (!isset($data['controller'])) $data['controller'] = $router->class;
  if (!isset($data['type'])) $data['type'] = 'text';
    if (!isset($data['index'])) {
    if (!isset($data['name'])) $data['name'] = $data['controller'] . '[' . $data['field'] . ']';
    if (!isset($data['value'])) $data['value'] = @$record[$data['field']];
  } else {
    if (!isset($data['name'])) $data['name'] = $data['controller'] . '[' . $data['index'] . ']' . '[' . $data['field'] . ']';
    if (!isset($data['value'])) $data['value'] = @$record[$data['index']][$data['field']];
  }
  if (!isset($data['col'])) $data['col'] = 'col-md-6';
  if (!isset($data['option'])) $data['option'] = array();
  if (!isset($data['error_message'])) $data['error_message'] = form_error($data['name']);
  $field_details = get_field_attribute($data['controller'], $data['field']);
  $data['label'] = $field_details[0];
  $data['readonly'] = ((isset($data['readonly']) && $data['readonly'] == true )) ? 'readonly' : '';
  $data['disabled'] = ((isset($data['disabled']) && $data['disabled'] == true )) ? 'disabled' : '';
  $data['multiple'] = ((isset($data['multiple']) && $data['multiple'] == true )) ? 'multiple' : '';
  $data['autofocus'] = ((isset($data['autofocus']) && $data['autofocus'] == true )) ? 'autofocus' : '';
  $data['onchange'] = (isset($data['onchange']) ? $data['onchange'] : '');

  $data['toggle'] = (isset($data['toggle']) ? $data['toggle'] : '');  
  $data['target'] = (isset($data['target']) ? $data['target'] : '');  
  
  $data['livesearch'] = (isset($data['livesearch']) ? $data['livesearch'] : '');
  $data['placeholder'] = (isset($field_details[1])) ? $field_details[1] : '';
  
  $data['mandatory'] = (isset($field_details[2]) && $field_details[2] === true);
  $data['error_message'] = (@$custom_error==1) ? $error_message : form_error($data['name']);
  $data['class'] = (isset($field_details[3]) && $field_details[3] != '') ? $field_details[3]: 'form-control '. (isset($data['class'])?$data['class']:'');
  $data['readonlyinput'] = (isset($field_details[5]) && $field_details[5] == TRUE);
  $data['input_icon_class'] = (!isset($input_icon_class)) ? '' : $input_icon_class;  
  $data['datastyle'] = (!isset($datastyle)) ? 'btn-default' : '';  
  $data['data_width'] = (!isset($data_width)) ? '100%' : '';    
  
  // $data['horizontal'] = (!isset($data['horizontal']) ? true : $data['horizontal']);
  if(isset($data['horizontal']) && $data['horizontal']!='') {
    $data['form_group_class'] = "row justify-content-between";
    $data['label_col'] = (!isset($label_col) ? "col-sm-3 col-form-label" : $label_col);
    $data['field_col'] = (!isset($field_col) ? "col-md-9" : $field_col);
  }
  if(isset($data['check_input_box']) && $data['check_input_box']!='') {
    $data['input_box_class'] = "control_box p-0";   
  } 
  if(isset($data['check_inline']) && $data['check_inline']!='') {
    $data['input_inline_class'] = "flex-fill custom-control-inline";   
  }
  if(isset($data['check_inline_box']) && $data['check_inline_box']!='') {
    $data['input_box_class'] = "control_box";  
    $data['input_inline_class'] = "flex-fill btn_blue radio-btn";  
  }   
  return $data; 
}

function get_records_by_id($records) {
  $result = array();
  foreach ($records as $index => $record) {
    $result[$record['id']] = $record;
  }
  return $result;
}



function load_field($field, $data, $button=false) {
  $ci =& get_instance();
  if (isset($data['data'])) $data = $data['data'];
  $layout = (isset($data['layout'])) ? $data['layout'] : $ci->load->_ci_cached_vars['layout'];
  $form_type = $button ? 'buttons' : 'fields';
  return load_view('layouts/'.$layout.'/forms/'.$form_type.'/'.$field, $data);
}

function load_buttons($field, $data) {
  load_field($field, $data, true);
}

function load_chart($field, $data) {
  load_view('layouts/application/forms/charts/'.$field, $data);
}

function load_card($data){
  $data['view']=!empty($data['view'])?$data['view']:'layouts/application/dashboard/card';
  $data['col']=!empty($data['col'])?$data['col']:'col-lg-3 col-md-6';
  return load_view('layouts/application/card',$data);  
}


function load_view($view, $data = array(), $return_as_string = FALSE) {
  $ci =& get_instance();
  return $ci->load->view($view, array('data' => $data), $return_as_string); 
}

function load_list($data = array()) {
  $ci =& get_instance();
  return $ci->load->view('sys/list/index', array('data' => $data)); 
}

function get_controller($controller_name, $router) {
  return (empty($controller_name)) ? $router->directory.$router->class : $controller_name;
}

function get_field_name_from_label($label) {
  $field_array = array();
  foreach (list_settings() as $setting_array) {
    $field_array[$setting_array[0]] = $setting_array[1];
  }
  if (array_key_exists($label, $field_array)) {
    return $field_array[$label];
  } else {
    return 'invalid_header';
  }
}

function get_import_file_validation_errors($field_prefix = 'import_data') {
  $ci =& get_instance();
  if (empty($ci->form_validation->error_array())) return array();
  $errors = array();
  foreach ($ci->form_validation->error_array() as $field_name => $error) {
    if (startsWith($field_name, $field_prefix)) {
      $index_start_pos = stripos($field_name, '[') + 1;
      $index_end_pos = stripos($field_name, ']');
      $index = substr($field_name, $index_start_pos, $index_end_pos-$index_start_pos);
      if(is_numeric($index))
        $errors[] = 'Row No '.$index.': '.$error;  
      else
        $errors[] = $error;  
    }
  } 
  return $errors;
}

function startsWith($string, $startString) { 
  $len = strlen($startString); 
  return (substr($string, 0, $len) === $startString); 
} 
