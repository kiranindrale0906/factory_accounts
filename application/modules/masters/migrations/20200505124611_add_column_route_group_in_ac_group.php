<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_route_group_in_ac_group extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_groups` ADD `route_group` VARCHAR(100) NOT NULL");
  }
}

?>