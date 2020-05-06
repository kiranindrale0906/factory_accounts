<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Rate_cut_purchase_weight_receipt_voucher_clients.php";
class Rate_cut_purchase_weight_receipt_vouchers extends Rate_cut_purchase_weight_receipt_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('rte_cut_purchase_weight_receipt_vouchers', 'voucher_date'));
    $this->load->model(array('masters/cash_bill_model','masters/purity_model'));
   
  }

  
}
