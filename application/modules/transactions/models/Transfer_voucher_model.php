<?php

class Transfer_voucher_model extends BaseModel {

  protected $table_name = "ac_vouchers";
  public $router_class="transfer_vouchers";
  protected $id = "id";

  public function __construct($data = array()){
		parent::__construct($data);
  }
  public function validation_rules($klass='') {
    $rules = array(array('field' => 'transfer_vouchers[account_name]', 
                     'label' => 'Account Name',
                     'rules' => 'trim|required'),
               array('field' => 'transfer_vouchers[from_date]', 
                               'label' => 'From Date',
                               'rules' => 'trim|required'),
               array('field' => 'transfer_vouchers[to_date]', 
                     'label' => 'To Date',
                     'rules' => 'trim|required'));
    return $rules;
  }

  public function save($action=true) {
    $account_id=$this->account_model->find('id',array('name'=>$this->attributes['account_name']))['id'];
    $voucher_id=$this->voucher_model->get('id',array('account_id'=>$account_id,'date(created_at) >='=>date('Y-m-d',strtotime($this->attributes['from_date'])),'date(created_at) <='=>date('Y-m-d',strtotime($this->attributes['to_date']))));
    $voucher_ids=array_column($voucher_id, 'id');
    $voucher_ids=implode(',', $voucher_ids);

    

    $this->db->query("insert into ".NEW_DB_NAME.".ac_vouchers select * from ".OLD_DB_NAME.".ac_vouchers where account_id = ".$account_id." and date(created_at) >= '".date('Y-m-d',strtotime($this->attributes['from_date']))."' and date(created_at) <= '".date('Y-m-d',strtotime($this->attributes['to_date']))."'");

    $this->db->query("insert into ".NEW_DB_NAME.".ac_ledger select * from ".OLD_DB_NAME.".ac_ledger where voucher_id in (".$voucher_ids.") and account_id = ".$account_id." and date(created_at) >= '".date('Y-m-d',strtotime($this->attributes['from_date']))."' and date(created_at) <= '".date('Y-m-d',strtotime($this->attributes['to_date']))."'");

    $this->db->query("delete from ".OLD_DB_NAME.".ac_vouchers where account_id = ".$account_id." and date(created_at) >= '".date('Y-m-d',strtotime($this->attributes['from_date']))."' and date(created_at) <= '".date('Y-m-d',strtotime($this->attributes['to_date']))."';");

  }

}