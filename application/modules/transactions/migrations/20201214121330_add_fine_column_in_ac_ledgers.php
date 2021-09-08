<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_fine_column_in_ac_ledgers extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_ledger` ADD `fine` DECIMAL(16,8) NOT NULL");
  }


}

?>