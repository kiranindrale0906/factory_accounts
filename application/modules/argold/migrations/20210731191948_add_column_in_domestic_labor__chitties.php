<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_in_domestic_labor__chitties extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `domestic_labour_chitties`
    							 ADD `cgst_amount` decimal(16,8) NULL DEFAULT 0,
    							 ADD `sgst_amount` decimal(16,8) NULL DEFAULT 0,
    							 ADD `debit_amount` decimal(16,8) NULL DEFAULT 0,
    							 ADD `taxable_amount` decimal(16,8) NULL DEFAULT 0;");
  }


}

?>