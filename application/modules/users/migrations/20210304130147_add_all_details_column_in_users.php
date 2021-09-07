<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_all_details_column_in_users extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_users` ADD `all_details` INT(11) NOT NULL DEFAULT '0'");
  }


}

?>