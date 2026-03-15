<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_new_usd_and_inr__fields_in_ac_vouchers extends CI_Model {

  public function up()
  {
    $this->db->query("alter table chitties add ounce_rate decimal(16,4) NOT NULL DEFAULT 0");
	$this->db->query("alter table chitties add usd_rate decimal(16,4) NOT NULL DEFAULT 0");
	$this->db->query("alter table chitties add premium_rate decimal(16,4) NOT NULL DEFAULT 0");
	$this->db->query("alter table chitties add premium_usd_amount decimal(16,4) NOT NULL DEFAULT 0");
	$this->db->query("alter table chitties add labour_rate decimal(16,4) NOT NULL DEFAULT 0");
	$this->db->query("alter table chitties add labour_usd_amount decimal(16,4) NOT NULL DEFAULT 0");
	$this->db->query("alter table chitties add freight_usd_amount decimal(16,4) NOT NULL DEFAULT 0");
	$this->db->query("alter table chitties add taxable_usd_amount decimal(16,4) NOT NULL DEFAULT 0");
	$this->db->query("alter table chitties add ounce_gram_rate decimal(16,4) NOT NULL DEFAULT 0");


  }


}

?>