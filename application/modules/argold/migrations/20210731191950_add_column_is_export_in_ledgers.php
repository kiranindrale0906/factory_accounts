<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_is_export_in_ledgers extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_ledger`
                   ADD `is_export` int(11) NULL DEFAULT 0;");
  }


}

?>