<?php

class Chitti_model extends BaseModel {

  protected $table_name = "chitties";
  public $router_class = "chittis";

  public function __construct($data = array()){
		parent::__construct($data);
    $this->load->model(array('transactions/rate_cut_issue_voucher_model','transactions/ledger_model'));
  }
  
  public function validation_rules($klass='') {
    $rules= array(array('field' => 'chittis[date]', 'label' => 'Date',
                        'rules' => 'trim|required'));
    return $rules;
  }

  public function before_validate(){
    if (   empty($this->formdata['chitti_details']) 
        && isset($this->attributes['id'])
        && !empty($this->attributes['id'])) {
      $select = 'sum(credit_weight) as credit_weight,
                 (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                 (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,
                 "" as voucher_number, packet_no, voucher_date';
      $chitti_details=$this->voucher_model->find($select, array('voucher_type' => 'metal issue voucher', 
                                                                'chitti_id' => $this->attributes['id']));
    }elseif (!empty($this->formdata['chitti_details'])) {
      $chitti_ids=array_column($this->formdata['chitti_details'], 'chitti_id');
      $select = 'sum(credit_weight) as credit_weight,
                 (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                 (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,
                 "" as voucher_number, packet_no, voucher_date';
      $chitti_details=$this->voucher_model->find($select, array('site_name' => $this->attributes['site_name'],
                                                                'packet_no' => $chitti_ids,
                                                                'account_name' => $this->attributes['account_name'],
                                                                'purity' => $this->attributes['purity']));
    }
    
    if (empty($this->attributes['date']))  $this->attributes['date'] = date('Y-m-d', strtotime($this->attributes['date']));
    
    if(!empty($chitti_details)){
      $this->attributes['weight'] = isset($chitti_details['credit_weight'])?$chitti_details['credit_weight']:0;
      $this->attributes['factory_purity'] =isset($chitti_details['factory_purity'])?$chitti_details['factory_purity']:0;
      $this->attributes['factory_fine']   = $chitti_details['credit_weight']*$chitti_details['factory_purity']/100;
      $this->attributes['purity'] = $this->attributes['purity'];
      $this->attributes['fine']   = $chitti_details['credit_weight']*$chitti_details['purity']/100;
      // $this->attributes['date'] = date('Y-m-d', strtotime($chitti_details['voucher_date']));
      $this->attributes['account_name'] = $this->attributes['account_name'];
      $this->attributes['packet_no'] = isset($chitti_details['packet_no'])?$chitti_details['packet_no']:0;

      $this->set_sales_amount_fields();
    }
  }

  private function set_sales_amount_fields() {
    if ($this->attributes['sale_type'] == 'Labour') {
      $this->attributes['credit_weight'] = $this->attributes['factory_fine'] - $this->attributes['fine']; 
      $gst_rate = 2.5;
    } else {
      $gst_rate = 1.5;
      $this->attributes['credit_weight'] = $this->attributes['factory_fine']; 
    }
    $this->attributes['rate']=!empty($this->attributes['rate'])?$this->attributes['rate']:0;
    $this->attributes['stone_amount']=!empty($this->attributes['stone_amount'])?$this->attributes['stone_amount']:0;
    $this->attributes['manual_taxable_amount']=!empty($this->attributes['manual_taxable_amount'])?$this->attributes['manual_taxable_amount']:0;
    $taxable_amount = $this->attributes['credit_weight'] * $this->attributes['rate'];

    $this->attributes['discount']=$taxable_amount-$this->attributes['manual_taxable_amount'];
    if(!empty($this->attributes['manual_taxable_amount']) && $this->attributes['manual_taxable_amount']==0){
      $this->attributes['taxable_amount']=$this->attributes['manual_taxable_amount']+$this->attributes['stone_amount'];
    }else{
      $this->attributes['taxable_amount']=$taxable_amount+$this->attributes['stone_amount'];
    }
    $this->attributes['cgst_amount'] = $this->attributes['taxable_amount'] * $gst_rate / 100;
    $this->attributes['sgst_amount'] = $this->attributes['taxable_amount'] * $gst_rate / 100;

    $ounce_gram_rate=$this->attributes['ounce_rate']/31.1034;

    $this->attributes['ounce_gram_rate']=four_decimal($ounce_gram_rate);
    $this->attributes['taxable_usd_amount']=$this->attributes['credit_weight'] * four_decimal($ounce_gram_rate);

    $inr_amount=$this->attributes['usd_rate']*($this->attributes['taxable_usd_amount']+$this->attributes['premium_usd_amount']+$this->attributes['labour_usd_amount']+$this->attributes['freight_usd_amount']);
   
    $total_amount = $this->attributes['taxable_amount'] + $this->attributes['cgst_amount'] + $this->attributes['sgst_amount']+$inr_amount;

    $tcs_rate=0;
    // pd(date('Y-m-d'));
    if((strtotime(date('Y-m-d'))>strtotime('2021-03-30'))){
      $tcs_rate=0.1;
    }elseif((strtotime(date('Y-m-d'))<=strtotime('2021-03-30'))){
      $tcs_rate=0.075;
    }
    if ($this->attributes['sale_type'] != 'Labour') 
      $this->attributes['debit_amount'] = (!empty($tcs_rate) || $tcs_rate!=0)?round($total_amount + $total_amount * $tcs_rate/100):0;
    else
      $this->attributes['debit_amount'] = round($total_amount);
  }
  
  public function after_save($action){
    $this->rate_cut_issue_voucher_model->create_rate_cut_vouchers_for_chitti($this->attributes['id']);
    $this->set_chitti_id_in_metal_issue_vouchers();
    if (!isset($this->formdata['chitti_details']) || empty($this->formdata['chitti_details'])) return;
    
	}  

  private function set_chitti_id_in_metal_issue_vouchers() {
    $chittis=array();

    if (!empty($this->formdata['chitti_details'])) {
      $chitti_ids = array_column($this->formdata['chitti_details'], 'chitti_id');
      $chitti_details = $this->voucher_model->get('', array('site_name' => $this->attributes['site_name'],
                                                            'packet_no' => $chitti_ids,
                                                            'account_name' => $this->attributes['account_name'],
                                                            'purity' => $this->attributes['purity']));
    } else 
      $chitti_details = $this->voucher_model->get('', array('chitti_id' => $this->attributes['id']));
    
    
    foreach ($chitti_details as $index => $chitti_detail) {
      if (isset($chitti_detail['id'])) {
        $voucher_obj = new voucher_model($chitti_detail);
        $voucher_obj->attributes['chitti_id'] = $this->attributes['id'];
        $voucher_obj->attributes['voucher_date'] = $this->attributes['date'];
        $voucher_obj->update(false);
      }
    }
  }
  public function update_chitti_ids($voucher_details) {
    if(!empty($voucher_details)){
      foreach ($voucher_details as $index => $voucher_detail) {
        if (isset($voucher_detail['id'])) {
        $voucher_obj = new voucher_model($voucher_detail);
        $voucher_obj->attributes['chitti_id'] = 0;
        $voucher_obj->update(false);
        $ledger_details=$this->ledger_model->find('',array('voucher_id'=>$voucher_detail['id']));
        $ledger_obj = new ledger_model($ledger_details);
        $ledger_obj->attributes['chitti_id'] = 0;
        $ledger_obj->update(false);
        }
      }
    }
  }
}