<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_packing_slip_balance_in_ac_voucher extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `packing_slip_balance` decimal(16,4) NULL DEFAULT '0';");
    $this->db->query("update ac_vouchers set packing_slip_balance=credit_weight;");
  }


}

?>