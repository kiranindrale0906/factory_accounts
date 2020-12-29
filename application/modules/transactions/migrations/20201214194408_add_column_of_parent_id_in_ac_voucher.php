<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_of_parent_id_in_ac_voucher extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `parent_id` INT(11) NOT NULL DEFAULT '0'");
  }


}

?>