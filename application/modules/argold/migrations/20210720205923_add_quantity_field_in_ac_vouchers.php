<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_quantity_field_in_ac_vouchers extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `packing_slip_quantity` int(11) NULL DEFAULT '0'");
        
  }


}

?>