<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_inr_and_usd_percentage_column_ac_vouchers extends CI_Model {

  public function up()
  {
    $this->db->query("alter table ac_vouchers add usd_wastage_percentage decimal(16,8) NOT NULL DEFAULT 0");
	$this->db->query("alter table ac_vouchers add inr_wastage_percentage decimal(16,8) NOT NULL DEFAULT 0");
	
  }


}

?>