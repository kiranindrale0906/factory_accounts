<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_lumpsum_amount_and_interest_column_in_voucher_table extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers` 
    				  ADD `lumpsum_amount` DECIMAL(10,4) NOT NULL ,
     				  ADD `interest_per_day` DECIMAL(10,4) NOT NULL ;");
  }


}

?>