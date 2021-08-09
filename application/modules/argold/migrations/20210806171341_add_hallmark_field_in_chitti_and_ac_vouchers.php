<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_hallmark_field_in_chitti_and_ac_vouchers extends CI_Model {

  public function up()
  {
        $this->db->query("ALTER TABLE `ac_vouchers`
    							 ADD `hallmark_amount` decimal(16,8) NULL DEFAULT 0,
    							 ADD `hallmark_rate` decimal(16,8) NULL DEFAULT 0,
    							 ADD `hallmark_quantity` int(16) NULL DEFAULT 0;");
        $this->db->query("ALTER TABLE `chitties`
    							 ADD `hallmark_amount` decimal(16,8) NULL DEFAULT 0,
    							 ADD `hallmark_rate` decimal(16,8) NULL DEFAULT 0,
    							 ADD `hallmark_quantity` int(16) NULL DEFAULT 0;");
  
  }


}

?>