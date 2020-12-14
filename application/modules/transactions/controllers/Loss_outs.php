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
  	$this->data['loss_out_details'] = $this->voucher_model->get('', array('account_name'=>'Loss Account'));
    parent::create();
  }

}