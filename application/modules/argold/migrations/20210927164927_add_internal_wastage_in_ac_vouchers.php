<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_internal_wastage_in_ac_vouchers extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers` ADD internal_wastage varchar(225) NULL DEFAULT NULL;");
  }


}

?>