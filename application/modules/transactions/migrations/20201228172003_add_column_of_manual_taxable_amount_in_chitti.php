<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_of_manual_taxable_amount_in_chitti extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `chitties` ADD `manual_taxable_amount` DECIMAL(10,4) NOT NULL DEFAULT '0', ADD `discount` DECIMAL(10,4) NOT NULL DEFAULT '0';");
  }


}

?>