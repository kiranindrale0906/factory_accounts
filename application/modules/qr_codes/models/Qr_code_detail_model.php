<?php 
class Qr_code_detail_model extends BaseModel{
	public $router_class = 'qr_code_details';
	protected $table_name= 'qr_code_details';
	public function __construct($data = array()){
		parent::__construct($data);
	}

	public function validation_rules($klass='', $index=0) {
    $rules = array(
      array('field' => 'qr_code_details['.$index.'][net_weight]',
            'label' => 'Net Weight',
            'rules' => 'trim|numeric'),
      array('field' => 'qr_code_details['.$index.'][gross_weight]',
            'label' => 'Gross Weight',
            'rules' => 'trim|numeric|required'), 
      array('field' => 'qr_code_details['.$index.'][total_stone]',
            'label' => 'Total Stone',
            'rules' => 'trim'),
      array('field' => 'qr_code_details['.$index.'][less]',
            'label' => 'Less',
            'rules' => 'trim|numeric'),
      array('field' => 'qr_code_details['.$index.'][length]',
            'label' => 'Length',
            'rules' => 'trim|numeric')
    );
    return $rules;
  }
}