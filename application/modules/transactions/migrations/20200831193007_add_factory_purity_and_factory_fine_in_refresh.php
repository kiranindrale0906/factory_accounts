<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_factory_purity_and_factory_fine_in_refresh extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `refresh` ADD `factory_purity` DECIMAL(12,8) NOT NULL, ADD `factory_fine` DECIMAL(10,4) NOT NULL,ADD `metal_receipt_id` int(11) NOT NULL;");
    $this->db->query("ALTER TABLE `refresh_details` ADD `factory_purity` DECIMAL(12,8) NOT NULL,
    				 ADD `factory_fine` DECIMAL(10,4) NOT NULL;");
    $this->db->query("ALTER TABLE `refresh_details` ADD `factory_purity` DECIMAL(12,8) NOT NULL,
    				 ADD `factory_fine` DECIMAL(10,4) NOT NULL;");
  }


}

?>