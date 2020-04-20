<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Opening_stock_voucher_client_model.php";
class Opening_stock_voucher_model extends Opening_stock_voucher_client_model {
  public $router_class = "opening_stock_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('transactions/sales_purchase_detail_model','masters/department_model'));
  }
  

   public function validation_rules($klass='') {
    $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[rate]', 'label' => 'Rate','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[purity]', 'label' => 'Purity','rules' => 'trim|required');
    return $rules;
  }

   public function after_save($action) {
    $opening_stock_data=$total_net_wt=$total_fine_wt=$total_gross_wt=$total_other_charge=$total_gold_amount=$total_other_charge=0;
    
    $opening_stock_vouchers=array();
      if(!empty($this->formdata['opening_stock_voucher_details'])) {
        foreach ($this->formdata['opening_stock_voucher_details'] as $voucher_record) {
          $opening_stock_data = array();
          $opening_stock_data=$voucher_record;
          $total_net_wt+=$voucher_record['net_wt'];
          $total_gross_wt+=$voucher_record['gross_wt'];
          $total_other_charge+=$voucher_record['other_charges'];
          $total_fine_wt+=$voucher_record['net_wt']*$voucher_record['melting']/100;

          $opening_stock_data['company_id']  = $this->attributes['company_id'];
          $opening_stock_data['sales_purchase_voucher_id']  = $this->attributes['id'];
          $opening_stock_data['voucher_type'] =$this->attributes['voucher_type'];
          $opening_stock_data['transaction_type'] = 'account';
          $opening_stock_data['department_name'] = $this->attributes['department_name'];
          // $opening_stock_data['department_id'] = $this->attributes['department_id'];

          $opening_stock_data['rate'] = $this->attributes['rate']/($this->attributes['purity']*100);
          $opening_stock_data['gold_amount'] = ($voucher_record['net_wt']*($voucher_record['melting']+$voucher_record['wastage'])/100)*$opening_stock_data['rate']/10;
          $total_gold_amount+=$opening_stock_data['gold_amount'];
          $opening_stock_data['fine_wt'] = $voucher_record['net_wt']*$voucher_record['melting']/100;
          $obj_purchase_voucher=new sales_purchase_detail_model($opening_stock_data);
          $obj_purchase_voucher->store(false);

        }
      }
      $opening_stock_vouchers['id']=$this->attributes['id'];
      $opening_stock_vouchers['total_net_weight']=$total_net_wt;
      $opening_stock_vouchers['total_gross_weight']=$total_gross_wt;
      $opening_stock_vouchers['total_fine_weight']=$total_fine_wt;
      $opening_stock_vouchers['credit_weight']=$total_fine_wt;
      $opening_stock_vouchers['credit_amount']=$total_gold_amount+$total_other_charge;
      $obj_purchase = new opening_stock_voucher_model($opening_stock_vouchers);
      $obj_purchase->update(false);
    }
}
//class