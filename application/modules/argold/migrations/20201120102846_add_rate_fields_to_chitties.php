<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_rate_fields_to_chitties extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `chitties` ADD `no_of_packets` int(11) NOT NULL DEFAULT 0");
    $this->db->query("ALTER TABLE `chitties` ADD `packet_gross_weight` decimal(16,8) NOT NULL DEFAULT 0");
    $this->db->query("ALTER TABLE `chitties` ADD `sale_type` varchar(20) NOT NULL DEFAULT ''");
    $this->db->query("ALTER TABLE `chitties` ADD `rate` decimal(16,8) NOT NULL DEFAULT 0");
    $this->db->query("ALTER TABLE `chitties` ADD `credit_weight` decimal(16,8) NOT NULL DEFAULT 0");
    $this->db->query("ALTER TABLE `chitties` ADD `debit_amount` decimal(16,8) NOT NULL DEFAULT 0");
    $this->db->query("ALTER TABLE `chitties` ADD `sgst_amount` decimal(16,8) NOT NULL DEFAULT 0");
    $this->db->query("ALTER TABLE `chitties` ADD `cgst_amount` decimal(16,8) NOT NULL DEFAULT 0");
  }
}

?>