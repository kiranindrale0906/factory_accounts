<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "modules/ac_vouchers/helpers/ac_vouchers_helper.php";
if (file_exists(APPPATH . "modules/".CLIENT_NAME."/helpers/client_opening_stock_vouchers_helper.php")) {

  require_once APPPATH . "modules/".CLIENT_NAME."/helpers/client_opening_stock_vouchers_helper.php";
} else {
  require_once APPPATH . "modules/ac_vouchers/helpers/core_opening_stock_vouchers_helper.php";
}
