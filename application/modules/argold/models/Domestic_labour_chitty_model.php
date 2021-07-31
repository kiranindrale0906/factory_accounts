<?php

class Domestic_labour_chitty_model extends BaseModel {

  protected $table_name = "domestic_labour_chitties";
  public $router_class = "domestic_labour_chitties";

  public function __construct($data = array()){
		parent::__construct($data);
    $this->load->model(array('transactions/ledger_model'));
  }
  
  public function validation_rules($klass='') {
    $rules= array(array('field' => 'domestic_labour_chitties[date]', 'label' => 'Date',
                        'rules' => 'trim|required'),
                  array('field' => 'domestic_labour_chitties[account_name]', 'label' => 'Account Name',
                            'rules' => array('trim','required',array('check_account_name_error_msg', array($this,'check_account_name_exist'))),
                              'errors' => array('check_account_name_error_msg' => 'Please select at least one detail',
                                       'required' => 'Account Name is required')));
    
    return $rules;
  }
  public function check_account_name_exist($name) {
    if(empty($this->formdata['domestic_labour_chitti_details'])){
      return false;
    }else{
      return true;
    }
    
  }

  public function before_validate(){
    if (!isset($this->formdata['domestic_labour_chitti_details']) || empty($this->formdata['domestic_labour_chitti_details'])) return;
     
    $domestic_labour_chitti_ids=array_column($this->formdata['domestic_labour_chitti_details'], 'domestic_labour_chitti_id');
    if (!isset($domestic_labour_chitti_ids) || empty($domestic_labour_chitti_ids)) return;
      $domestic_labour_chitti_id_details=array();
      $domestic_labour_chittis=array();
      foreach ($domestic_labour_chitti_ids as $index => $domestic_labour_chitti_id) {
        $chittis=explode('-', $domestic_labour_chitti_id);
        $domestic_labour_chitti_id_details[$index]['packet_no']=$chittis[0];
        $domestic_labour_chitti_id_details[$index]['argold_id']=$chittis[1];
      }
      $packet_nos=array_column($domestic_labour_chitti_id_details, 'packet_no');
      $argold_ids=array_column($domestic_labour_chitti_id_details, 'argold_id');


      $select = 'sum(credit_weight) as credit_weight,
                 (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                 (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,
                 "" as voucher_number, packet_no, voucher_date';
      $domestic_labour_chitti_details=$this->voucher_model->find($select, array('packet_no' => $packet_nos,
                                                                'argold_id' => $argold_ids,
                                                                'account_name' => $this->attributes['account_name']));
     $rate=0;
     foreach ($this->formdata['domestic_labour_chitti_details'] as $index => $value) {
       $rate+=$value['rate'];
     }
    if(!empty($domestic_labour_chitti_details)){
      $this->attributes['date']=date('Y-m-d',strtotime($this->attributes['date']));
      $this->attributes['weight']=$domestic_labour_chitti_details['credit_weight'];
      $this->attributes['rate']=$rate;
      $this->attributes['purity']=$domestic_labour_chitti_details['purity'];
      $this->attributes['factory_purity']=$domestic_labour_chitti_details['factory_purity'];
      $this->attributes['factory_fine']=$this->attributes['weight']*$domestic_labour_chitti_details['factory_purity']/100;
      $this->attributes['fine']=$this->attributes['weight']*$domestic_labour_chitti_details['purity']/100;
      $this->set_sales_amount_fields();
    }
  }
    private function set_sales_amount_fields() {
      $gst_rate = 2.5;
      $this->attributes['credit_weight'] = $this->attributes['factory_fine']; 
      $this->attributes['taxable_amount']=$this->attributes['credit_weight']*$this->attributes['rate'];
      $this->attributes['cgst_amount'] = $this->attributes['taxable_amount'] * $gst_rate / 100;
      $this->attributes['sgst_amount'] = $this->attributes['taxable_amount'] * $gst_rate / 100;
      $total_amount = $this->attributes['taxable_amount'] + $this->attributes['cgst_amount'] + $this->attributes['sgst_amount'];
      $this->attributes['debit_amount'] = round($total_amount);
    }

   public function after_save($action){
    $this->load->model(array('transactions/cash_issue_voucher_model'));
    $this->cash_issue_voucher_model->create_cash_vouchers_for_chitti($this->attributes['id']);
    if (!isset($this->formdata['domestic_labour_chitti_details']) || empty($this->formdata['domestic_labour_chitti_details'])) return;
    $this->set_domestic_labour_chitti_id_in_metal_issue_vouchers();
	}  

  private function set_domestic_labour_chitti_id_in_metal_issue_vouchers() {
    $domestic_labour_chittis=array();
    if (!empty($this->formdata['domestic_labour_chitti_details'])) {
    foreach ($this->formdata['domestic_labour_chitti_details'] as $index => $domestic_labour_chitti_detail) {
      if(!empty($domestic_labour_chitti_detail['domestic_labour_chitti_id'])){
      $domestic_labour_chittis=explode('-', $domestic_labour_chitti_detail['domestic_labour_chitti_id']);
      if(!empty($domestic_labour_chitti_detail['voucher_id'])){

      $domestic_labour_details = $this->voucher_model->find('', array('id' => $domestic_labour_chitti_detail['voucher_id']));
      }else{

          $domestic_labour_details = $this->voucher_model->find('sum(credit_weight) as credit_weight,
                   (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                   (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,id,site_name', array('packet_no' => $domestic_labour_chittis[0],
                                                              'argold_id' => $domestic_labour_chittis[1],
                                                              'account_name' => $this->attributes['account_name']
                                                              ));
      }
        $domestic_labour_details['domestic_labour_chitti_id'] = $this->attributes['id'];
        $domestic_labour_details['process_rate'] = $domestic_labour_chitti_detail['rate'];
        $domestic_labour_details['voucher_date'] = $this->attributes['date'];
        $voucher_obj = new voucher_model($domestic_labour_details);
        $voucher_obj->update(false);}
      }
    }
  }
  public function update_chitti_ids($voucher_details) {
    if(!empty($voucher_details)){
      foreach ($voucher_details as $index => $voucher_detail) {
        if (isset($voucher_detail['id'])) {
        $voucher_obj = new voucher_model($voucher_detail);
        $voucher_obj->attributes['domestic_labour_chitti_id'] = 0;
        $voucher_obj->update(false);
        $ledger_details=$this->ledger_model->find('',array('voucher_id'=>$voucher_detail['id']));
        // $ledger_obj = new ledger_model($ledger_details);
        // $ledger_obj->attributes['domestic_labour_chitti_id'] = 0;
        // $ledger_obj->update(false);
        }
      }
    }
  }
  public function chitti_detail_exist($name) {
    if(empty($this->formdata['domestic_labour_chitti_details'])){
      return false;
    }else{
      return true;
    }
    
  }
}