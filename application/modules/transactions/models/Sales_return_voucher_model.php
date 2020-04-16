<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Sales_return_voucher_client_model.php";
class Sales_return_voucher_model extends Sales_return_voucher_client_model {
  public $router_class = "sales_return_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('transactions/sales_purchase_detail_model','masters/department_model'));
  }
  public function before_validate() {
    $this->attributes['department_name'] = $this->department_model->find('name')['name'];
  }

   public function validation_rules($klass='') {
    $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[rate]', 'label' => 'Rate','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[purity]', 'label' => 'Purity','rules' => 'trim|required');
    return $rules;
  }

   public function after_save($action) {
    $sales_return_data=$total_net_wt=0;
    $purchase_vouchers=array();
      if(!empty($this->formdata['sales_return_voucher_details'])) {
        foreach ($this->formdata['sales_return_voucher_details'] as $voucher_record) {
          $sales_return_data = array();
          $sales_return_data=$voucher_record;
          $total_net_wt+=$voucher_record['net_wt'];
          $total_gross_wt+=$voucher_record['gross_wt'];
          $sales_return_data['company_id']  = $this->attributes['company_id'];
          $sales_return_data['sales_purchase_voucher_id']  = $this->attributes['id'];
          $sales_return_data['voucher_type'] =$this->attributes['voucher_type'];
          $sales_return_data['transaction_type'] = 'account';
          $sales_return_data['department_name'] = $this->attributes['department_name'];
          $sales_return_data['department_id'] = $this->attributes['department_id'];
          $obj_purchase_voucher=new sales_purchase_detail_model($sales_return_data);
          $obj_purchase_voucher->store(false);

        }
      }
      $sales_return_vouchers['id']=$this->attributes['id'];
      $sales_return_vouchers['total_net_weight']=$total_net_wt;
      $sales_return_vouchers['total_gross_weight']=$total_gross_wt;
      $obj_purchase = new sales_return_voucher_model($sales_return_vouchers);
      $obj_purchase->update(false);
    }
}
//class