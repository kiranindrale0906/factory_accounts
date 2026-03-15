<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_purchase_details extends BaseController {
  public function __construct() {
    parent::__construct();
     $this->load->model(array('masters/cash_bill_model','masters/department_category_model','masters/purity_model','masters/setting_model','masters/group_model'));
   
   }
}
