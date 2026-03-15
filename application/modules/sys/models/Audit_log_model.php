<?php
class Audit_log_model extends BaseModel{
  protected $table_name = "audit_logs";
  protected $id = 'id';

  function __construct() {
    parent::__construct();
    $this->audit_log = false;
  }

  public function save_record($mode_obj, $action,$conditions = array()) {
    $model_name = get_class($mode_obj);
    $this->load->model($model_name);
    $model = $this->$model_name;

    $new_attributes = $mode_obj->attributes;

    $new_attributes["where_conditions"] = $conditions;

    if(!isset($new_attributes["where_conditions"])){
      $new_attributes["where_conditions"] = array();
    }

    if(!isset($new_attributes["id"])){
      $new_attributes["id"] = "";
    }


    if ($action == 'store')
      $old_attributes = array();
    elseif ($action == 'update')
      if((count($new_attributes["where_conditions"]) <= 0 
                && is_array($new_attributes["where_conditions"])) || 
          $new_attributes["where_conditions"] == "")
        $old_attributes = $model->find('*',array('id'=>$new_attributes['id']));
      else
        $old_attributes = $model->get('*',$new_attributes["where_conditions"]);
    elseif ($action == 'delete') {
      if((count($new_attributes["where_conditions"]) <= 0 
                && is_array($new_attributes["where_conditions"])) || 
          $new_attributes["where_conditions"] == "")
        $old_attributes = $model->find('*',array('id'=>$new_attributes['id']));
      else
        $old_attributes = $model->get('*',$new_attributes["where_conditions"]);
    }


    if(empty($model->update_columns))
      $model->update_columns = array();

    if(empty($model->log_columns))
      $model->log_columns = array();

    $save = true;
    $total_count = 0;
    $count = 0;


    if(count($model->update_columns) > 0 && count($new_attributes["where_conditions"]) <= 0 
   && $new_attributes["id"] != '' && count(array_intersect_key(array_flip($model->update_columns),$new_attributes)) >0){
        foreach ($model->update_columns as $key1 => $value1) {
            if(isset($old_attributes[$value1]) && isset($new_attributes[$value1])){
              $total_count++;
              if($old_attributes[$value1] == $new_attributes[$value1]){
                $count++;
              }
            }
        }
    }


    if($count == $total_count  && count($model->update_columns) > 0) {
      $save = false;
    }
    
    if($action != 'delete' && count($model->log_columns)>0 && count($new_attributes)>0)
      $new_attributes =  $this->filterArrayByKeys($new_attributes, $model->log_columns);                  

    if($action != 'delete' && count($model->log_columns)>0 && count($old_attributes)>0)
      $old_attributes = $this->filterArrayByKeys($old_attributes, $model->log_columns);


    if(is_array(@$old_attributes[0]))
      foreach ($old_attributes as $key => $value)
        $old_attributes[$key]["ip_address"] = get_client_ip();     
    else
        $old_attributes["ip_address"] = get_client_ip();     
    $new_attributes["ip_address"] = get_client_ip();


    if($save){
      if(is_array(@$old_attributes[0]))
        foreach ($old_attributes as $key_old => $value_old){
          $obj_log = new Audit_log_model();
          $obj_log->attributes["new_attributes"] = strval(json_encode($new_attributes,true));
          $obj_log->attributes["old_attributes"] = strval(json_encode($value_old,true));
          $obj_log->attributes["record_id"] = !empty($new_attributes['id'])?
                                        $new_attributes['id']:@$old_attributes['id'];
          $obj_log->attributes["action"] = $action;
          $obj_log->attributes["model_name"] = $model_name;     
          $response = $obj_log->save(false);
        }
      else{
        $obj_log = new Audit_log_model();
        $obj_log->attributes["new_attributes"] = strval(json_encode($new_attributes,true));
        $obj_log->attributes["old_attributes"] = strval(json_encode($old_attributes,true));
        $obj_log->attributes["record_id"] = !empty($new_attributes['id'])?
                                      $new_attributes['id']:@$old_attributes['id'];
        $obj_log->attributes["action"] = $action;
        $obj_log->attributes["model_name"] = $model_name;
        $response = $obj_log->save(false);
      }
    } else {
      return array();
    }
  }

 
  private function filterArrayByKeys($data, $selected_columns){
    $selected_columns = array_flip($selected_columns);
    return  array_intersect_key($data, $selected_columns);
  }

  public function before_save($action){

  }

}
