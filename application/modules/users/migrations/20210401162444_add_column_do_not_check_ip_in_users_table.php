<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_do_not_check_ip_in_users_table extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_users` ADD `do_not_check_ip` INT(11) NOT NULL DEFAULT '0'");
 
  }


}

?>