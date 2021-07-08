<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_usd_amount_in_ac_voucher extends CI_Model {

  public function up()
  {
    $this->db->query("alter table ac_vouchers add usd_amount decimal(16,4) NOT NULL DEFAULT 0");
    $this->db->query("alter table ac_vouchers add usd_rate decimal(16,4) NOT NULL DEFAULT 0");
  }


}

?>