ALTER TABLE `refresh_details` ADD `site_name` VARCHAR(50) NOT NULL<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_site_name_column_in__refresh_table extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `refresh_details` ADD `site_name` VARCHAR(50) NOT NULL");
    $this->db->query("ALTER TABLE `refresh` ADD `site_name` VARCHAR(50) NOT NULL");
  }


}

?>