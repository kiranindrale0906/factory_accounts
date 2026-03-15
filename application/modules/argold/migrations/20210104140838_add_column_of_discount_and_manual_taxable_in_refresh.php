<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_of_discount_and_manual_taxable_in_refresh extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `refresh` ADD `discount` decimal(12,8) NOT NULL default 0");
    $this->db->query("ALTER TABLE `refresh` ADD `manual_taxable_amount` decimal(12,8) NOT NULL default 0");
  }


}

?>