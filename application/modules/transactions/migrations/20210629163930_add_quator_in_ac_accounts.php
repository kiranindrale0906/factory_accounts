<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_quator_in_ac_accounts extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `quator` VARCHAR(225) NOT NULL");
  }


}

?>