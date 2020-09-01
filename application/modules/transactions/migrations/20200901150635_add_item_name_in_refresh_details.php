<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_item_name_in_refresh_details extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `refresh_details` ADD `item_name` VARCHAR(225) NOT NULL");
  }


}

?>