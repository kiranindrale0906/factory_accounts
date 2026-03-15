<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/argold/controllers/Chittis.php";
class Chitti_exports extends Chittis {
  public function __construct() {
    parent::__construct();
    $this->_model = array('chitti_model' => 'chitti_export_model'); 
    $this->date_fields = array(array('chittis', 'date'));
    $this->redirect_after_save = 'view';
    $this->load->model(array('ac_vouchers/voucher_model','masters/account_model','argold/chitti_model','masters/narration_model'));
  }
  
}