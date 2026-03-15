<?php
class Change_log_model extends BaseModel{
  protected $table_name = "change_logs";
  protected $id = 'id';

  function __construct() {
    parent::__construct();
    $this->maintain_log = false;
  }

  public function save_record($new_attributes, $action, $model_name) {
    $this->load->model($model_name);
    $model = $this->$model_name;

    if ($action == 'store')
      $old_attributes = array();
    elseif ($action == 'update')
      $old_attributes = $model->find($new_attributes['id']);
    elseif ($action == 'delete') {
      if($new_attributes["id"] != '')
        $old_attributes = $model->find($new_attributes['id']);
      else
        $old_attributes = $model->get('*',$new_attributes["where"]);
    }
    
    if($action != 'delete' && count($model->log_columns)>0 && count($new_attributes)>0)
      $new_attributes =  $this->filterArrayByKeys($new_attributes, $model->log_columns);                  

    if($action != 'delete' && count($model->log_columns)>0 && count($old_attributes)>0)
      $old_attributes = $this->filterArrayByKeys($old_attributes, $model->log_columns); 

    $change_log_data = array('new_attributes' => json_encode($new_attributes),
                             'old_attributes' => json_encode($old_attributes),
                             'record_id' => @$new_attributes['id'],
                             'action' => $action,
                             'model_name' => $model_name);
    parent::store($change_log_data);
  }

  private function filterArrayByKeys($data, $selected_columns){
    $selected_columns = array_flip($selected_columns);
    return  array_intersect_key($data, $selected_columns);
  }
}
