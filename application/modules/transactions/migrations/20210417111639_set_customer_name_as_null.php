<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_set_customer_name_as_null extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers` CHANGE `customer_name` `customer_name` VARCHAR(225) NULL DEFAULT NULL;");
  }


}

?>