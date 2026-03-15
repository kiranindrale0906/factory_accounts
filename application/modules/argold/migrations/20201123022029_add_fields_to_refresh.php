<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_fields_to_refresh extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `refresh` ADD `rate` decimal(16,8) NOT NULL DEFAULT 0");
    $this->db->query("alter table refresh add taxable_amount decimal(16, 8) NOT NULL DEFAULT 0");
    $this->db->query("ALTER TABLE `refresh` ADD `sgst_amount` decimal(16,8) NOT NULL DEFAULT 0");
    $this->db->query("ALTER TABLE `refresh` ADD `cgst_amount` decimal(16,8) NOT NULL DEFAULT 0");
    $this->db->query("ALTER TABLE `refresh` ADD `debit_weight` decimal(16,8) NOT NULL DEFAULT 0");
    $this->db->query("ALTER TABLE `refresh` ADD `credit_amount` decimal(16,8) NOT NULL DEFAULT 0");
  }


}

?>