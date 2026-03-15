<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Sales_voucher_client_model.php";
class Sales_voucher_model extends Sales_voucher_client_model {
  public $router_class = "sales_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('transactions/sales_purchase_detail_model','masters/department_model'));
  }
  
   public function validation_rules($klass='') {
    $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[rate]', 'label' => 'Rate','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[purity]', 'label' => 'Purity','rules'  =>array('trim','required',
                    array('check_purity_error',array($this,'check_purity_exist'))),
        'errors' => array('check_purity_error'=>'Purity value not exist in Purity Master.'));
    return $rules;
  }

   public function after_save($action) {
    $sales_data=$total_net_wt=$total_fine_wt=$total_gross_wt=$total_other_charge=$total_gold_amount=$total_other_charge=0;
    $sales_vouchers=array();
      if(!empty($this->formdata['sales_voucher_details'])) {
        foreach ($this->formdata['sales_voucher_details'] as $voucher_record) {
          $sales_data = array();
          $sales_data=$voucher_record;
          $total_net_wt+=$voucher_record['net_wt'];
          $total_gross_wt+=$voucher_record['gross_wt'];
          $total_other_charge+=$voucher_record['other_charges'];
          $total_fine_wt+=$voucher_record['net_wt']*$voucher_record['melting']/100;

          $sales_data['company_id']  = $this->attributes['company_id'];
          $sales_data['sales_purchase_voucher_id']  = $this->attributes['id'];
          $sales_data['voucher_type'] =$this->attributes['voucher_type'];
          $sales_data['transaction_type'] = $this->attributes['transaction_type'];
          $sales_data['department_name'] = $this->attributes['department_name'];
          // $sales_data['department_id'] = $this->attributes['department_id'];
          $sales_data['rate'] = $this->attributes['rate']/($this->attributes['purity']*100);
          $sales_data['gold_amount'] = ($voucher_record['net_wt']*($voucher_record['melting']+$voucher_record['wastage'])/100)*$sales_data['rate']/10;
          $total_gold_amount+=$sales_data['gold_amount'];
          $sales_data['fine_wt'] = $voucher_record['net_wt']*$voucher_record['melting']/100;
          $obj_purchase_voucher=new sales_purchase_detail_model($sales_data);
          $obj_purchase_voucher->store(false);

        }
      }
      $sales_vouchers['id']=$this->attributes['id'];
      $sales_vouchers['total_net_weight']=$total_net_wt;
      $sales_vouchers['total_gross_weight']=$total_gross_wt;
      $sales_vouchers['total_fine_weight']=$total_fine_wt;
      $sales_vouchers['credit_weight']=$total_fine_wt;
      $sales_vouchers['credit_amount']=$total_gold_amount+$total_other_charge;
      $obj_purchase = new sales_voucher_model($sales_vouchers);
      $obj_purchase->update(false);
    }
}
//class