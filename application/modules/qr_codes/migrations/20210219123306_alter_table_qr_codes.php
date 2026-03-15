<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_table_qr_codes extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `qr_codes` ADD `design_code` VARCHAR(255) NOT NULL, 
    																ADD `percentage` DECIMAL(10,2) NOT NULL DEFAULT '0.00';");
  }


}

?>