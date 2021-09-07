<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (file_exists(APPPATH . "modules/".CLIENT_NAME."/controllers/Client_opening_stock_vouchers.php")) {

  require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Client_opening_stock_vouchers.php";
  class Opening_stock_vouchers extends Client_opening_stock_vouchers {
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }

} else {
  
  require_once APPPATH . "modules/ac_vouchers/controllers/Core_opening_stock_vouchers.php";
  class Opening_stock_vouchers extends Core_opening_stock_vouchers {
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }

}
?>