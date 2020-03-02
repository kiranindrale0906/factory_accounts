<?php
defined('BASEPATH') OR exit('No direct script access allowed');

trait Bar_code_trait {
	public function get_bar_codes(){
		$get_table_settings = getTableSettings();
		
		$join = array();
    if (is_array($get_table_settings['table'])) {
      foreach ($get_table_settings['table'] as $key => $table) {
        if ($key != "0") {
          $join[] = array($table, $get_table_settings['join_conditions'][$key - 1], $get_table_settings['join_type']);
        }
      }
    }

		$field_name = $_GET['field'];
		$page = (isset($_GET['page_no'])?$_GET['page_no']:0);
		if(isset($_GET['show_all'])) $limit = '';
		else $limit = $get_table_settings['limit'];

		if(!empty($limit)) $start = $page * $limit;
		else $start = 0;

		$model_name = ucfirst(singular($this->router->class)).'_model';
		$model_obj = new $model_name;
		$data['field'] = $field_name;
		$data['bar_code_data'] = $model_obj->get($field_name,array(),$join,array('limit'=>array($start,$limit)));
		$data['layout'] = 'application';

		$this->load->render('sys/barcode/barcode',$data); exit;
	}
}
?>