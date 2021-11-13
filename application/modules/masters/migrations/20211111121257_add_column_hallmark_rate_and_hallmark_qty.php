<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_hallmark_rate_and_hallmark_qty extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `hallmark_rate` decimal(8,2) NOT NULL default 0,
                                                ADD `hallmark_qty` int(10) NOT NULL default 0");
  }


}

?>