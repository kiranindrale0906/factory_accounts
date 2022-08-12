<?php

/*************************************************************************
*
* ASCRA TECHNOLOGIES CONFIDENTIAL
* __________________
*
*  All Rights Reserved.
*
* NOTICE:  All information contained herein is, and remains
* the property of Ascra Technologies and its suppliers,
* if any.  The intellectual and technical concepts contained
* herein are proprietary to Ascra Technologies
* and its suppliers and may be covered by U.S. and Foreign Patents,
* patents in process, and are protected by trade secret or copyright law.
* Dissemination of this information or reproduction of this material
* is strictly forbidden unless prior written permission is obtained
* from Ascra Technologies.
* version = 1.4
*/

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "core/logic_traits/Validation_trait.php";
require_once APPPATH . "core/Listing_trait.php";

class BaseModel extends CI_Model {
  use validation_trait;
 
  use listing_trait;

  protected $audit_log = false;
  protected $log_columns = array();
  public $router_class = '';
  public $attributes = array();
  public $formdata = array();
  public $filedata = array();
  protected $load_trigger = false;

  public function __construct($data=array()) {
    parent::__construct();
    //$this->controller =  $this->router->fetch_class();
    //$this->module =  $this->router->fetch_module();
    if(!empty($data)) $this->set_formdata_and_attributes($data);
  }

  public function validate($validation_klass='') {
    $this->before_validate();
    $rules = $this->validation_rules($validation_klass);
    if(empty($rules)) return false;
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_data($this->formdata);
    return $this->form_validation->run();
  }

  public function save($after_save=true) { 
    if (empty($this->attributes['id']))
      $this->store($after_save);
    else
      $this->update($after_save);
  }

  public function store($after_save=true) {
    $this->attributes['created_at'] = date('Y-m-d H:i:s');
    $this->attributes['created_by'] = @$_SESSION['user_id'];
    $this->before_save('store');
    if ($this->db->insert($this->table_name, $this->attributes)) {
      $this->attributes['id'] = $this->db->insert_id();
      if ($this->audit_log) $this->audit_log_model->save_record($this, 'store');
      if ($after_save) $this->after_save('store');
      if($this->load_trigger == true)
        $this->call_triggers('store',$this->attributes,'','');
      return $this->attributes;
    } else
      return array('status' => 'failure');
  }

  public function update($after_save=true, $conditions=array(), $action='update') {
    $id = @$this->attributes['id'];
    if (empty($id) && empty($conditions)) return false;
    $this->attributes['updated_at'] = date('Y-m-d H:i:s');
    //$this->attributes['updated_by'] = @$_SESSION['user_id'];
    if ($action=='update') $this->before_save('update');

    if($this->audit_log) $this->audit_log_model->save_record($this,'update',$conditions);
   
    if (!empty($id)) {
      $existing_attributes = $this->find('', array('id' => $id));
      $changed_attributes = array_diff_assoc($this->attributes, $existing_attributes);
      $this->attributes = $changed_attributes;
    }
    unset($this->attributes['id']);

    $this->db->set($this->attributes);
    if (!empty($id)) $conditions['where']['id'] = $id;
    $this->db_conditions($conditions);
   
    if (empty($this->attributes) || ($this->db->update($this->table_name, $this->attributes))) {
      $this->attributes['id'] = $id;
     
      if (!empty($id)) {
        $missed_attributes = array_diff_key($existing_attributes, $this->attributes);
        $this->attributes = array_merge($this->attributes, $missed_attributes);
      }
     
      if($this->load_trigger == true)
        $this->call_triggers('update',$this->attributes,$changed_attributes,$existing_attributes);
      
      if ($after_save) $this->after_save('update');
  
      return $this->attributes;
    } else
      return array('status' => 'failure', 'id' => $id);
  }

  public function store_batch($after_save=true) {
    $this->before_save('store');
    if($this->truncate_table == true){
      $this->truncate();
    }
    $this->db->insert_batch($this->table_name, $this->formdata_batch);
    if ($after_save) $this->after_save('store');
    return $this->formdata_batch;
  }

  public function truncate() {
    $this->db->truncate($this->table_name);
  }


  public function find($select = '*', $conditions = array(), $joins = array(), $operations=array()) {
    $operations['row_array'] = true;
    return $this->get($select, $conditions, $joins, $operations);
  }

  public function get($select = '*', $conditions = array(), $joins = array(), $operations=array()) {
    if(!empty($operations['table'])) $this->table_name = $operations['table'];
    $this->db->select($select);
    $this->db->from($this->table_name);
    if(!empty($joins))
      foreach ($joins as $index => $join)
        $join = $this->db->join($join[0], $join[1], (isset($join[2])) ? $join[2] :'inner');
    $this->db_conditions($conditions);

    if(isset($operations['order_by'])) $this->db->order_by($operations['order_by']);
    if(isset($operations['limit']) && !empty($operations['limit'][1])) $this->db->limit($operations['limit'][1],$operations['limit'][0]);
    if(isset($operations['group_by'])) $this->db->group_by($operations['group_by']);
    if(isset($operations['having'])) $this->db->having($operations['having']);
    $this->db->where($this->table_name.'.is_delete !=',1);
   
    $query = $this->db->get();
    if(isset($operations['row_array']) && $operations['row_array'])
      return $query->row_array();    
    else
      return $query->result_array();
  }

  public function delete($id, $conditions=array(), $permanent_delete=TRUE, $after_delete=TRUE) {
    if (empty($id) && empty($conditions)) return false;
    $this->before_delete($id);
    $this->attributes = array();
    if($permanent_delete == false):
      if ($id !='') $this->attributes['id'] = $id;
      $this->attributes['is_delete'] = 1;
      $this->update(false, $conditions, 'delete');
    else:
      if ($id !='')
        $this->db->where('id', $id);
      else
        $this->db_conditions($conditions);
      $this->db->delete($this->table_name);
    endif;
    if($this->audit_log) $this->audit_log_model->save_record($this,'delete',$conditions);
    if($after_delete == TRUE) $this->after_delete($id, $conditions);
  }

  public function before_validate(){}
  public function before_save($action){}
  public function after_save($action){}
  public function before_delete($id){}
  public function after_delete($id, $conditions){}
  public function get_ajax_success_data($action) {return $this->attributes;}
 
  public function set_formdata_and_attributes($data) {
    if(empty($this->router_class)) $this->router_class = $this->table_name;
    if(!isset($data[$this->router_class])) $data = array($this->router_class => $data);
    $this->formdata = $data;
    $this->attributes = &$this->formdata[$this->router_class];
   
    if (!empty($this->attributes['id'])) {
      $existing_attributes = $this->find('', array('id' => $this->attributes['id']));
      $missed_attributes = array_diff_key($existing_attributes, $this->attributes);
      $this->attributes = array_merge($this->attributes, $missed_attributes);
    }

    if (isset($_FILES[$this->router_class])) $this->filedata = $_FILES[$this->router_class];
  }

  private function db_conditions($conditions) {
    if(isset($conditions['where'])) $this->db->where($conditions['where']);
    if(isset($conditions['having'])) $this->db->having($conditions['having']);
    if(isset($conditions['or_where
      '])) $this->db->or_where($conditions['or_where']);
    if(isset($conditions['where_in'])) $this->db->where_in($conditions['where_in'],'',false);
    if(isset($conditions['where_not_in'])) $this->db->where_not_in($conditions['where_not_in'],'',false);
    if(isset($conditions['like']) && !is_array($conditions['like']))
      $this->db->like($conditions['like']);
    if(isset($conditions['like']) && is_array($conditions['like'])){
      foreach ($conditions['like'] as $like_key => $like_value) {
      $this->db->group_start();
        foreach ($like_value as $value_key => $like) {
          $this->db->or_like($like_key,$like);
        }
      $this->db->group_end();
      }
    }
   
    foreach($conditions as $field => $value){
      if (in_array($field, array('where', 'where_in', 'like','where_not_in','having',"or_where","or_having"))
           == false){
        if(!is_array($value))
          $this->db->where($field,$value);
        if(is_array($value)){
          $implode_array = implode(',',$value);
          if(strpos($field, 'NOT IN') !== false)
            $this->db->where_not_in(str_replace("NOT IN","",$field),$value);
          else
            $this->db->where_in(str_replace("IN","",$field),$value,true);
          if(strpos($field, 'IN') !== false)
            $this->db->where($field,$value);
        }
      }
    }
  }

  private function call_triggers($action, $attributes, $changed_attributes='', $previous_attributes=''){
    if(isset($this->trigger_model) AND !empty($this->trigger_model))
      $model_name = $this->trigger_model;
    else
      $model_name = singular($this->router_class).'_trigger_model';
    $this->load->model('triggers/'.$model_name);
    $this->$model_name->execute_event($action,$attributes,$changed_attributes,$previous_attributes);
  
  }
}

