<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_new_column_in_ac_vouchers_tables extends CI_Model {

  public function up()
  {
    $this->db->query("alter table ac_vouchers add cgst_amount decimal(16,4) NOT NULL DEFAULT 0");
	$this->db->query("alter table ac_vouchers add sgst_amount decimal(16,4) NOT NULL DEFAULT 0");
	$this->db->query("alter table ac_vouchers add tcs_amount decimal(16,4) NOT NULL DEFAULT 0");
	$this->db->query("alter table ac_vouchers add taxable_amount decimal(16,4) NOT NULL DEFAULT 0");
  }


}

?>