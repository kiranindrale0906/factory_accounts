<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_voucher_id_column_in_ac_ledgers extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_ledger` ADD `voucher_id` int(11) NOT NULL DEFAULT '0'");
  }


}

?>