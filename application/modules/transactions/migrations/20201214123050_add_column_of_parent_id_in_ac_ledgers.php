<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_of_parent_id_in_ac_ledgers extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_ledger` ADD `parent_id` int(11) NOT NULL DEFAULT '0'");
  }


}

?>