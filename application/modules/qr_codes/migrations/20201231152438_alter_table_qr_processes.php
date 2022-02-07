<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_table_qr_processes extends CI_Model {

  public function up()
  {
    //$this->db->query("ALTER TABLE `process_qr_codes` 
		// ADD `net_weight` DECIMAL(10,4) NOT NULL DEFAULT '0.0000' 
		// AFTER `capacity`, ADD `total_stone` BIGINT NOT NULL AFTER `net_weight`, ADD `less` BIGINT NOT NULL 
		// AFTER `total_stone`, ADD `percentage` DECIMAL(10,2) NOT NULL AFTER `less`, 
		// ADD `purity` DECIMAL(10,2) NOT NULL AFTER `percentage`,
		// ADD `design_code` VARCHAR(100) NOT NULL AFTER `purity`;");
  }


}

?>
