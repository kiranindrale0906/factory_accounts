<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_rate_and_cash_amount_in_ac_voucher extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `rate` DECIMAL(10,4) NOT NULL , ADD `cash_amount` DECIMAL(10,4) NOT NULL ;
");
  }


}

?>