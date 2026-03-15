<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_remove_refresh_file extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `refresh_details` ADD `item_name` VARCHAR(225) NOT NULL");
  }


}

?>