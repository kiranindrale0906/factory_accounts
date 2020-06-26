<?php

class Chitti_model extends BaseModel {

  protected $table_name = "chitties";
  public $router_class = "chittis";
  protected $id = "id";
  public function __construct($data = array()){
		parent::__construct($data);
  }
  
  public function before_validate(){
    if (isset($this->formdata['chitti_details'])  || !empty($this->formdata['chitti_details'])){
      $credit_weight=$fine=$purity=0;
      foreach ($this->formdata['chitti_details'] as $index => $chitti_detail) {
        $voucher_data=$this->voucher_model->find('',array('id'=>$chitti_detail['chitti_id']));

        $credit_weight+=$voucher_data['credit_weight'];
        $fine+=$voucher_data['credit_weight']*$voucher_data['factory_purity']/100;
        // $purity+=($voucher_data['credit_weight']/$voucher_data['credit_weight']*$voucher_data['factory_purity']);
      }
        $this->attributes['weight']=$credit_weight;
        $this->attributes['fine']=$fine;
        $this->attributes['purity']=$voucher_data['factory_purity'];
        $this->attributes['account_name']=$voucher_data['account_name'];
    
    }
  }
  public function after_save($action){
  	$chitti_details=array();
	if (!isset($this->formdata['chitti_details'])  || empty($this->formdata['chitti_details'])) return;
	foreach ($this->formdata['chitti_details'] as $index => $chitti_detail) {
		if (isset($chitti_detail['chitti_id'])) {
			$chitti_details['chitti_id'] = $this->attributes['id'];
		  $chitti_details_model = new voucher_model($chitti_details);
   		$chitti_details_model->update(false,array('id'=>$chitti_detail['chitti_id']));
		}
    }
  
	}  

	public function validation_rules($klass='') {
    $rules= array(array('field' => 'chittis[date]', 'label' => 'Date',
									      'rules' => 'trim|required')
                  );
    return $rules;
  }
}

//class