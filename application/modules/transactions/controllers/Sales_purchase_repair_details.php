<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_purchase_repair_details extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/cash_bill_model','masters/purity_model'));
   
   }
}
