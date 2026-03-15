<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_unrecoverable_account_id extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_account` ADD `unrecoverable_account_id` int(11) NOT NULL default 0,ADD `unrecoverable_account_name` varchar(225) NOT NULL default ''");
  }


}

?>