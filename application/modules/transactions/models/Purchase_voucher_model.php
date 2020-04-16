<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Purchase_voucher_client_model.php";
class Purchase_voucher_model extends Purchase_voucher_client_model {
  public $router_class = "purchase_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('transactions/sales_purchase_detail_model','masters/department_model'));

  }
  public function before_validate() {
    $this->attributes['department_id'] = $this->department_model->find('id',array('where'=>$this->attributes['department_name']))['id'];
  }

   public function validation_rules($klass='') {
    $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[rate]', 'label' => 'Rate','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[purity]', 'label' => 'Purity','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[cash_amount]', 'label' => 'Cash Amount','rules' => 'trim|required');
    return $rules;
  }

   public function after_save($action) {
    $purchase_data=$total_net_wt=$total_fine_wt=$total_gold_amount=$total_other_charge=0;
    $purchase_vouchers=array();
      if(!empty($this->formdata['purchase_voucher_details'])) {
        foreach ($this->formdata['purchase_voucher_details'] as $voucher_record) {
          $purchase_data = array();
          $purchase_data=$voucher_record;
          $total_net_wt+=$voucher_record['net_wt'];
          $total_gross_wt+=$voucher_record['gross_wt'];
          $total_other_charge+=$voucher_record['other_charges'];
          $total_fine_wt+=$voucher_record['net_wt']*$voucher_record['melting']/100;

          $purchase_data['company_id']  = $this->attributes['company_id'];
          $purchase_data['sales_purchase_voucher_id']  = $this->attributes['id'];
          $purchase_data['voucher_type'] =$this->attributes['voucher_type'];
          $purchase_data['transaction_type'] = 'account';
          $purchase_data['department_name'] = $this->attributes['department_name'];
          $purchase_data['department_id'] = $this->attributes['department_id'];

          $purchase_data['rate'] = $this->attributes['rate']/($this->attributes['purity']*100);
          $purchase_data['gold_amount'] = ($voucher_record['net_wt']*($voucher_record['melting']+$voucher_record['wastage'])/100)*$purchase_data['rate']/10;
          $total_gold_amount+=$purchase_data['gold_amount'];
          $purchase_data['fine_wt'] = $voucher_record['net_wt']*$voucher_record['melting']/100;
          $obj_purchase_voucher=new sales_purchase_detail_model($purchase_data);
          $obj_purchase_voucher->store(false);

        }
      }
      $purchase_vouchers['id']=$this->attributes['id'];
      $purchase_vouchers['total_net_weight']=$total_net_wt;
      $purchase_vouchers['total_gross_weight']=$total_gross_wt;
      $purchase_vouchers['total_fine_weight']=$total_fine_wt;
      $purchase_vouchers['debit_weight']=$total_fine_wt;
      $purchase_vouchers['debit_amount']=$total_gold_amount+$total_other_charge;
      $obj_purchase = new purchase_voucher_model($purchase_vouchers);
      $obj_purchase->update(false);
    }
}

//class