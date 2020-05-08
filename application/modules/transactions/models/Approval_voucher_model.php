<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Approval_voucher_client_model.php";
class Approval_voucher_model extends Approval_voucher_client_model {
  public $router_class = "approval_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('transactions/Sales_purchase_repair_detail_model','masters/department_model'));
  }
 
   public function validation_rules($klass='') {
    $rules[] = array('field' => $this->router_class.'[type]', 'label' => 'Type','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[rate]', 'label' => 'Rate','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[purity]',
                      'label' => 'Purity',
                      'rules'  =>array('trim','required','numeric','less_than_equal_to[100]',
                      array('purity_error_msg',array($this,'check_purity_exist'))),
                     'errors' => array('purity_error_msg'=>'Purity not exist in Purity master.'));
    $rules[] = array('field' => $this->router_class.'[group_name]',
                     'label' => 'Group Name',
                     'rules'  =>array('trim','required','numeric','less_than_equal_to[100]',
                      array('group_error_msg',array($this,'check_group_name_exist'))),
                     'errors' => array('group_error_msg'=>'Group Name not exist in Group master.'));
    $rules[] = array('field' => $this->router_class.'[gst_number]', 'label' => 'GST Number','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[cash_bill]', 'label' => 'Cash/bill','rules'  =>array('trim','required',
                    array('check_cash_bill_error',array($this,'check_cash_bill_exist'))),
        'errors' => array('check_cash_bill_error'=>'Cash / Bill value not exist.'));
    $rules[] = array('field' => $this->router_class.'[payment_term]', 'label' => 'Payment Term','rules' => 'trim|required');
   return $rules;
  }

  public function before_save($action) {
    $this->formdata[$this->router_class]['has_hallmark']=(!empty($this->attributes['has_hallmark'])?$this->attributes['has_hallmark']:0);
  }
  
   public function after_save($action) {
    $approval_data=$total_net_wt=$total_fine_wt=$total_gross_wt=$total_other_charge=$total_gold_amount=$total_other_charge=0;
    
    $approval_vouchers=array();
      if(!empty($this->formdata['approval_voucher_details'])) {
        foreach ($this->formdata['approval_voucher_details'] as $voucher_record) {
          $approval_data = array();
          $approval_data=$voucher_record;
          $total_net_wt+=$voucher_record['net_wt'];
          $total_gross_wt+=$voucher_record['gross_wt'];
          $total_other_charge+=$voucher_record['other_charges'];
          $total_fine_wt+=$voucher_record['net_wt']*$voucher_record['melting']/100;

          $approval_data['company_id']  = $this->attributes['company_id'];
          $approval_data['sales_purchase_repair_voucher_out_id']  = $this->attributes['id'];
          $approval_data['voucher_type'] =$this->attributes['voucher_type'];
          $approval_data['transaction_type'] = $this->attributes['transaction_type'];
           $approval_data['rate'] = $this->attributes['rate']/($this->attributes['purity']*100);
          $approval_data['gold_amount'] = ($voucher_record['net_wt']*($voucher_record['melting']+$voucher_record['wastage'])/100)*$approval_data['rate']/10;
          $total_gold_amount+=$approval_data['gold_amount'];
          $approval_data['fine_wt'] = $voucher_record['net_wt']*$voucher_record['melting']/100;
          $obj_purchase_voucher=new Sales_purchase_repair_detail_model($approval_data);
          $obj_purchase_voucher->store(false);

        }
      }
      // $approval_vouchers['id']=$this->attributes['id'];
      // $approval_vouchers['total_net_weight']=$total_net_wt;
      // $approval_vouchers['total_gross_weight']=$total_gross_wt;
      // $approval_vouchers['total_fine_weight']=$total_fine_wt;
      $approval_vouchers['credit_weight']=$total_fine_wt;
      $approval_vouchers['credit_amount']=$total_gold_amount+$total_other_charge;
      $obj_purchase = new approval_voucher_model($approval_vouchers);
      $obj_purchase->update(false);
    }

    public function check_cash_bill_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $accounts=$this->cash_bill_model->find('id as id',array('name'=>$name));
    return (empty($accounts)) ? false : true;
  }
}
//class