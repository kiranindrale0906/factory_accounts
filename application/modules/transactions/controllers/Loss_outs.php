<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Loss_outs extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('ac_vouchers/voucher_model'));
  }
  public function index() { 
    redirect(base_url().'transactions/loss_outs/create');
  }
  public function create() {
    $this->data['loss_out_details']=array();
    $loss_out_details= $this->voucher_model->get('', array('account_name'=>'Loss Account','parent_id'=>0));
    if(!empty($loss_out_details)){
      foreach ($loss_out_details as $index => $value) {
        $receipt_data= $this->voucher_model->find('sum(debit_weight) as debit_weight,purity', array('parent_id'=>$value['id']));
        $this->data['loss_out_details'][$index]=$value;
        $this->data['loss_out_details'][$index]['receipt_weight']=$receipt_data['debit_weight'];
        $this->data['loss_out_details'][$index]['receipt_purity']=$receipt_data['purity'];
      }
    }
    parent::create();
  }

}