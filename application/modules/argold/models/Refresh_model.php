<?php

class Refresh_model extends BaseModel {

  protected $table_name = "refresh";
  public $router_class = "refresh";
  protected $id = "id";

  public function __construct($data = array()){
		parent::__construct($data);
  }
  
  public function before_validate() {
    if (!empty($this->formdata['refresh_details'])) {
      $total_weight=$total_fine=$total_factory_fine=0;
      foreach ($this->formdata['refresh_details'] as $refresh_detail) {
        $total_weight+=!empty($refresh_detail['weight'])?$refresh_detail['weight']:0;
        $total_fine+=!empty($refresh_detail['fine'])?$refresh_detail['fine']:0;
        $total_factory_fine+=!empty($refresh_detail['factory_fine'])?$refresh_detail['factory_fine']:0;
      }
      $this->attributes['weight']=!empty($total_weight)?$total_weight:0;
      $this->attributes['fine']=!empty($total_fine)?$total_fine:0;
      $this->attributes['factory_fine']=!empty($total_factory_fine)?$total_factory_fine:0;
      $this->attributes['purity']=!empty($total_weight)?($total_fine/$total_weight)*100:0;
      $this->attributes['factory_purity']=!empty($total_weight)?($total_factory_fine/$total_weight)*100:0;
    }

    $gst_rate = 1.5;
    $this->attributes['debit_weight'] = $this->attributes['fine'];
    $this->attributes['rate'] = !empty($this->attributes['rate'])?$this->attributes['rate']:0;
    $this->attributes['manual_taxable_amount'] = !empty($this->attributes['manual_taxable_amount'])?$this->attributes['manual_taxable_amount']:0;
    $taxable_amount = $this->attributes['debit_weight'] * $this->attributes['rate'];
    $this->attributes['discount']=$taxable_amount-$this->attributes['manual_taxable_amount'];
    if(!empty($this->attributes['manual_taxable_amount']) && $this->attributes['manual_taxable_amount']==0){
      $this->attributes['taxable_amount']=$this->attributes['manual_taxable_amount'];
    }else{
      $this->attributes['taxable_amount']=$taxable_amount;
    }
    $this->attributes['cgst_amount'] = $this->attributes['taxable_amount'] * $gst_rate / 100;
    $this->attributes['sgst_amount'] = $this->attributes['taxable_amount'] * $gst_rate / 100;
    $this->attributes['credit_amount'] = $this->attributes['taxable_amount'] + $this->attributes['cgst_amount'] + $this->attributes['sgst_amount'];
  }

  public function after_save($action) {
    parent::after_save($action);
    if (empty($this->formdata['refresh_details'])) return;
    $this->create_refresh_details();
  }

  private function create_refresh_details() {
    $this->load->model('argold/refresh_detail_model');
    if(empty($this->formdata['refresh_details'])) return true;

    foreach ($this->formdata['refresh_details'] as $refresh_detail) {
      $refresh_detail_data = array();
      $refresh_detail_data=$refresh_detail;
      $refresh_detail_data['refresh_id'] = $this->attributes['id'];
      $refresh_detail_data['site_name'] = $this->attributes['site_name'];
      $obj_refresh_detail=new refresh_detail_model($refresh_detail_data);
      $obj_refresh_detail->save();
    }
  }  
	public function validation_rules($klass='') {
    $rules[] = array('field' => 'refresh[weight]', 
                     'label' => 'Weight',
                     'rules' => 'trim|required|numeric|greater_than[0]');
    $rules[] = array('field' => 'refresh[purity]', 
                     'label' => 'Purity',
                     'rules' => 'trim|required|numeric|greater_than[0]');
    $rules[] = array('field' => 'refresh[site_name]', 
                     'label' => 'Site Name',
                     'rules' => 'trim|required');
    if(!empty($this->formdata['refresh_details'])){
      foreach($this->formdata['refresh_details'] as $index => $refresh_detail) {
       $rules[]= array('field' => 'refresh_details['.$index.'][item_name]', 'label' => 'item name','rules' => array('trim', 'required'));
      
      }
    }
    return $rules;
  }
}