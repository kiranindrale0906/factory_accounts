<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_of_sale_type_in_ac_ledgers extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_ledger` ADD `sale_type` varchar(225) NOT NULL DEFAULT ''");
  }


}

?>