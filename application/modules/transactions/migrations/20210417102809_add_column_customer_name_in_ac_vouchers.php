<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_customer_name_in_ac_vouchers extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `customer_name` VARCHAR(225) NOT NULL;");
  }


}

?>