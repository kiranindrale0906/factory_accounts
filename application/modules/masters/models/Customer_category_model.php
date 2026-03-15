<?php

class Customer_category_model extends BaseModel {

  protected $table_name = "ac_customer_category";
  protected $id = "id";
  public $router_class="customer_category";
  function __construct($data=array()) {
    parent::__construct($data);
  }

  public function before_save($action) {
    $this->set_customer_category_data();
  }

  public function validation_rules($klass='') {
    return array(
      array(
        'field' => 'customer_category[category_name_id]', 
        'label' => 'Category Name', 
        'rules' => array('trim','required',
                      array('error_msg_customer_category',array($this,'check_duplicate_customer_category'))),
        'errors'=>  array('error_msg_customer_category'=>'Customer Category combination,department name 
                          ,account_name,melting already exists')),
      array(
        'field' => 'customer_category[department_name_id]', 
        'label' => 'Department name', 
        'rules' => 'trim|required'),
  	  array(
        'field' => 'customer_category[account_name]', 
        'label' => 'Account Name', 
        'rules' => array('trim','required',
                      array('error_msg_account_name',array($this,'check_account_name_exist'))),
        'errors'=>  array('error_msg_account_name'=>'Account name not exist in account master')),
  	  // array(
     //    'field' => 'customer_category[melting]', 
     //    'label' => 'Melting', 
     //    'rules' => 'trim|integer|is_natural|less_than_equal_to[100]')
    );
  }

  public function check_duplicate_customer_category($customer_category) {
    // pd($customer_category);
    return parent::check_unique(array('category_name_id','department_name_id','account_name'));
  }

  private function set_customer_category_data(){
    $category_name = $this->department_category_model->find('name as name',
                                                        array('id'=>$this->attributes['category_name_id']));
    $this->formdata[$this->router_class]['category_name'] = @$category_name['name'];    

    $department_name=$this->department_model->find('name as name',
                                                   array('id'=>$this->attributes['department_name_id']));
    $this->formdata[$this->router_class]['department_name']=@$department_name['name'];

    $account_name=$this->account_model->find('id as id',
                                            array('name'=>$this->attributes['account_name']));
    $this->formdata[$this->router_class]['account_name_id']=@$account_name['id'];
  }

  public function check_account_name_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $account=$this->account_model->find('id as id',array('name'=>$name));
    return (empty($account)) ? false : true;
  }
}
