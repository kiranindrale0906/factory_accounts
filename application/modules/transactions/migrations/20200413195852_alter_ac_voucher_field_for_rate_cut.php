<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_ac_voucher_field_for_rate_cut extends CI_Model {

  public function up()
  {
  	$sql = "ALTER TABLE `ac_vouchers` ADD `gold_rate` DECIMAL(10,4) NOT NULL,ADD `gold_weight` DECIMAL(10,4) NOT NULL,ADD `gold_rate_purity` 
  					DECIMAL(10,4) NOT NULL ,ADD `gold_weight_purity` DECIMAL(10,4) NOT NULL;";
    $this->db->query($sql);
  }


}

?>



