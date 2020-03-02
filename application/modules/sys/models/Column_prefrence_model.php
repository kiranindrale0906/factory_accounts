<?php

class Column_prefrence_model extends BaseModel {
	protected $table_name = 'column_prefrences';
  protected $id = 'id';
  public function __construct($data=array()) {
    parent::__construct($data);
  }

	public function get_column_prefrences(){
    if(isset($_SESSION['user_id'])){
      $this->table_name = 'column_prefrences';
      $get_json_data = $this->column_prefrence_model->get('*',array('where'=>array('user_id'=>$_SESSION['user_id'],'list_page'=>ucwords($this->router->fetch_class()))),'',array('row_array'=>true));
      return $get_json_data;
    }
	}

  public function save_column_filters($column_jsons='',$id){
    $_SESSION['user_id'] = 9;
    $model_obj = new Column_prefrence_model();
    $model_obj->table_name = 'column_prefrences';
    $model_obj->attributes['id'] = $id;
    $model_obj->attributes['list_page'] = ucwords($this->router->fetch_class());
    $model_obj->attributes['user_id'] = $_SESSION['user_id'];
    if(!empty($column_jsons['select_column']) AND $column_jsons['select_column'] != 'null')
      $model_obj->attributes['select_column_json'] = $column_jsons['select_column'];
    if(!empty($column_jsons['arrange_column']) AND $column_jsons['arrange_column'] != 'null')
      $model_obj->attributes['arrange_column_json'] = $column_jsons['arrange_column'];
    $model_obj->save();
  }

}

?>