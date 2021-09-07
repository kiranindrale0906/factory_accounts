<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_factory_fine_in_ac_ledgers extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_ledger` ADD `factory_fine` DECIMAL(16,8) NOT NULL");
  }


}

?>