<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Repair_voucher_client_model.php";
class Repair_voucher_model extends Repair_voucher_client_model {
  public $router_class = "repair_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('transactions/Sales_purchase_repair_detail_model','masters/department_model'));
  }
 
   public function validation_rules($klass='') {
    $rules[] = array('field' => $this->router_class.'[type]', 'label' => 'Type','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[rate]', 'label' => 'Rate','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[purity]', 'label' => 'Purity','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[group_name]', 'label' => 'Group Name','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[gst_number]', 'label' => 'GST Number','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[cash_bill]', 'label' => 'Cash/bill','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[payment_term]', 'label' => 'Payment Term','rules' => 'trim|required');
    return $rules;
  }
  public function before_save($action) {
    $this->formdata[$this->router_class]['has_hallmark']=(!empty($this->attributes['has_hallmark'])?$this->attributes['has_hallmark']:0);
  }


   public function after_save($action) {
    $repair_data=$total_net_wt=$total_fine_wt=$total_gross_wt=$total_other_charge=$total_gold_amount=$total_other_charge=0;
    
    $repair_vouchers=array();
      if(!empty($this->formdata['repair_voucher_details'])) {
        foreach ($this->formdata['repair_voucher_details'] as $voucher_record) {
          $repair_data = array();
          $repair_data=$voucher_record;
          $total_net_wt+=$voucher_record['net_wt'];
          $total_gross_wt+=$voucher_record['gross_wt'];
          $total_other_charge+=$voucher_record['other_charges'];
          $total_fine_wt+=$voucher_record['net_wt']*$voucher_record['melting']/100;

          $repair_data['company_id']  = $this->attributes['company_id'];
          $repair_data['sales_purchase_repair_voucher_out_id']  = $this->attributes['id'];
          $repair_data['voucher_type'] =$this->attributes['voucher_type'];
          $repair_data['transaction_type'] = 'account';
          // $repair_data['department_name'] = $this->attributes['department_name'];
          // $repair_data['department_id'] = $this->attributes['department_id'];

          $repair_data['rate'] = $this->attributes['rate']/($this->attributes['purity']*100);
          $repair_data['gold_amount'] = $voucher_record['melting'];/*($voucher_record['net_wt']*($voucher_record['melting']+$voucher_record['wastage'])/100)*$repair_data['rate']/10;*/
          $total_gold_amount+=$repair_data['gold_amount'];
          $repair_data['fine_wt'] = $voucher_record['net_wt']*$voucher_record['melting']/100;
          $obj_purchase_voucher=new Sales_purchase_repair_detail_model($repair_data);
          $obj_purchase_voucher->store(false);

        }
      }
      $repair_vouchers['id']=$this->attributes['id'];
      $repair_vouchers['total_net_weight']=$total_net_wt;
      $repair_vouchers['total_gross_weight']=$total_gross_wt;
      $repair_vouchers['total_fine_weight']=$total_fine_wt;
      $repair_vouchers['credit_weight']=$total_fine_wt;
      $repair_vouchers['credit_amount']=$total_gold_amount+$total_other_charge;
      $obj_purchase = new repair_voucher_model($repair_vouchers);
      $obj_purchase->update(false);
    }
}
//class