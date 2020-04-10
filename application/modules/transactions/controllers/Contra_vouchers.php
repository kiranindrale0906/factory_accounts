<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Contra_voucher_clients.php";
class Contra_vouchers extends Contra_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields=array(array('contra_vouchers','voucher_date'));
  }
}
