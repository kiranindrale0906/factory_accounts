<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_is_delete_i_n_cash_bill_table extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_cash_bill` ADD `is_delete` int(11) NOT NULL");
  }


}

?>