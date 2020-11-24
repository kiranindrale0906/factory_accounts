<?php

class Chitti_model extends BaseModel {

  protected $table_name = "chitties";
  public $router_class = "chittis";

  public function __construct($data = array()){
		parent::__construct($data);
    $this->load->model(array('transactions/rate_cut_issue_voucher_model'));
  }
  
  public function validation_rules($klass='') {
    $rules= array(array('field' => 'chittis[date]', 'label' => 'Date',
                        'rules' => 'trim|required'));
    return $rules;
  }

  public function before_validate(){
    if (!empty($this->formdata['chitti_details'])) {
      $chitti_ids=array_column($this->formdata['chitti_details'], 'chitti_id');
      $select = 'sum(credit_weight) as credit_weight,
                 (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                 (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,
                 "" as voucher_number, packet_no, voucher_date';
      $chitti_details=$this->voucher_model->find($select, array('site_name' => $this->attributes['site_name'],
                                                                'packet_no' => $chitti_ids,
                                                                'account_name' => $this->attributes['account_name'],
                                                                'purity' => $this->attributes['purity']));
      $this->attributes['weight'] = $chitti_details['credit_weight'];
      $this->attributes['factory_purity'] = $chitti_details['factory_purity'];
      $this->attributes['factory_fine']   = $chitti_details['credit_weight']*$chitti_details['factory_purity']/100;
      $this->attributes['purity'] = $this->attributes['purity'];
      $this->attributes['fine']   = $chitti_details['credit_weight']*$chitti_details['purity']/100;
      $this->attributes['date'] = $chitti_details['voucher_date'];
      $this->attributes['account_name'] = $this->attributes['account_name'];
      $this->attributes['packet_no'] = $chitti_details['packet_no'];
    }

    $this->set_sales_amount_fields();
  }

  private function set_sales_amount_fields() {
    if ($this->attributes['sale_type'] == 'Labour') {
      $this->attributes['credit_weight'] = $this->attributes['factory_fine'] - $this->attributes['fine']; 
      $gst_rate = 2.5;
    } else {
      $gst_rate = 1.5;
      $this->attributes['credit_weight'] = $this->attributes['factory_fine']; 
    }

    //$this->attributes['taxable_amount'] = $this->attributes['credit_weight'] * $this->attributes['rate'];
    $this->attributes['cgst_amount'] = $this->attributes['taxable_amount'] * $gst_rate / 100;
    $this->attributes['sgst_amount'] = $this->attributes['taxable_amount'] * $gst_rate / 100;
    $total_amount = $this->attributes['taxable_amount'] + $this->attributes['cgst_amount'] + $this->attributes['sgst_amount'];
    $this->attributes['debit_amount'] = $total_amount;

    if ($this->attributes['sale_type'] != 'Labour') 
      $this->attributes['debit_amount'] = round($total_amount + $total_amount * .075/100);
  }
  
  public function after_save($action){
    $this->rate_cut_issue_voucher_model->create_rate_cut_vouchers_for_chitti($this->attributes['id']);
    if (!isset($this->formdata['chitti_details']) || empty($this->formdata['chitti_details'])) return;
    $this->set_chitti_id_in_metal_issue_vouchers();
	}  

  private function set_chitti_id_in_metal_issue_vouchers() {
    $chittis=array();
    $chitti_ids=array_column($this->formdata['chitti_details'], 'chitti_id');
    $chitti_details = $this->voucher_model->get('', array('site_name' => $this->attributes['site_name'],
                                                         'packet_no' => $chitti_ids,
                                                         'account_name' => $this->attributes['account_name'],
                                                         'purity' => $this->attributes['purity']));
    foreach ($chitti_details as $index => $chitti_detail) {
      if (isset($chitti_detail['id'])) {
        $chittis['chitti_id'] = $this->attributes['id'];
        $chitti_details_model = new voucher_model($chittis);
        $chitti_details_model->update(false, array('id' => $chitti_detail['id']));
      }
    }
  }
}