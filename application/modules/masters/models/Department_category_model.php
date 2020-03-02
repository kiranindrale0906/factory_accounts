<?php

class Department_category_model extends BaseModel {

  protected $table_name = "ac_department_category";
  protected $id = "id";
  public $router_class="department_category";

  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function before_save($action) {
    $department_name=$this->department_model->find('name as name',
                                                  array(
                                                  'id'=>$this->attributes['department_name_id']));
    $this->formdata[$this->router_class]['department_name']=@$department_name['name'];
  }

  public function validation_rules($klass='') {
    return array(
      array(
        'field' => 'department_category[name]', 
        'label' => 'Category Name', 
        'rules' => array('trim','required',
                        array('error_msg_department_category',array($this,'check_department_category'))),
        'errors'=>  array('error_msg_department_category'=>'Department category name already exists')),
      array(
        'field' => 'department_category[department_name_id]', 
        'label' => 'Department name', 
        'rules' => 'trim|required'),
  	  array(
        'field' => 'department_category[wastage]', 
        'label' => 'Wastage', 
        'rules' => 'trim'),
  	  array('field' => 'department_category[melting]', 
        'label' => 'Melting', 
        'rules' => 'trim|required|integer|is_natural|less_than_equal_to[100]')
    );
  }

  public function check_department_category($department_category_name) {
    return parent::check_unique('name');
  }

}
