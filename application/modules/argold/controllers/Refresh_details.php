<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Refresh_details extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/narration_model','argold/refresh_detail_model','masters/item_name_model','transactions/metal_receipt_voucher_model'));
 
  }
  public function _get_form_data() {
    $this->data['item_names'] = $this->item_name_model->get('distinct(name) as name,name as id');
    
  }
}
