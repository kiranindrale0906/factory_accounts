<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_field_calculate_tax_in_ac_vouchers extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers` ADD calculate_tax int(11) NULL DEFAULT 0;");
  }


}

?>