<?php defined('BASEPATH') OR exit('No direct script access allowed.');

  function getTableSettings($table_setting_arg=array()) {
  }

  function get_field_attribute($table, $field) {
    $attributes = array();
    $attributes['production_summary'] = array(
      'product_name' => array('Product Name', '', TRUE, '', TRUE),
      'in_purity'    => array('Melting', '', TRUE, '', TRUE),
      'category_one' => array('Chain Name', '', TRUE, '', TRUE),
      'machine_size' => array('Size', '', TRUE, '', TRUE),
      'design_code'  => array('Design Name', '', TRUE, '', TRUE),
    );
    return $attributes[$table][$field];
  }

?>