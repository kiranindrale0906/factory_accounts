<?php 
class Qr_api_model extends BaseModel{
	public $router_class = 'qr_code_details';
	protected $table_name= 'qr_code_details';
	public function __construct($data = array()){
		parent::__construct($data);
	}

	public function validation_rules($klass='', $index=0) {
    $rules = array(
      array('field' => 'qr_code_details[id]',
            'label' => 'Id',
            'rules' => 'trim|numeric'),
    );
    return $rules;
  }

	public function after_save($action) {
    echo json_encode(array('status' => 'success',
										  		 'data' => $this->attributes)); 
    die();
  }
}