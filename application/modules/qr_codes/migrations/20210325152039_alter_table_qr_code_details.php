<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_table_qr_code_details extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `qr_code_details` CHANGE `total_stone` `total_stone` DECIMAL(10,4) NOT NULL;");
    $this->db->query("ALTER TABLE `qr_code_details` CHANGE `less` `less` DECIMAL(10,4) NOT NULL;");
    $this->db->query("ALTER TABLE `qr_code_details` CHANGE `percentage` `percentage` DECIMAL(10,4) NOT NULL;");
    $this->db->query("ALTER TABLE `qr_code_details` CHANGE `purity` `purity` DECIMAL(10,4) NOT NULL;");
  }
}

?>