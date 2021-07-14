<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_new_table_packing_slips extends CI_Model {

  public function up()
  {
    $this->db->query("CREATE TABLE `packing_slips` (
  `id` int(11) NOT NULL,
  `chitti_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(225) NOT NULL,
  `created_by` varchar(225) NOT NULL,
  `is_delete` tinyint(4) NOT NULL,
  `weight` decimal(10,4) NOT NULL,
  `fine` decimal(10,4) NOT NULL,
  `purity` decimal(10,4) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `voucher_id` int(11) NOT NULL DEFAULT 0,
  `packet_no` int(11) NOT NULL DEFAULT 0,
  `factory_purity` decimal(16,8) NOT NULL DEFAULT 0.00000000,
  `site_name` varchar(10) NOT NULL DEFAULT '',
  `no_of_packets` int(11) NOT NULL DEFAULT 0,
  `packet_gross_weight` decimal(16,8) NOT NULL DEFAULT 0.00000000,
  `sale_type` varchar(20) NOT NULL DEFAULT '',
  `rate` decimal(16,8) NOT NULL DEFAULT 0.00000000,
  `credit_weight` decimal(16,8) NOT NULL DEFAULT 0.00000000,
  `debit_amount` decimal(16,8) NOT NULL DEFAULT 0.00000000,
  `sgst_amount` decimal(16,8) NOT NULL DEFAULT 0.00000000,
  `cgst_amount` decimal(16,8) NOT NULL DEFAULT 0.00000000,
  `factory_fine` decimal(16,8) NOT NULL DEFAULT 0.00000000,
  `taxable_amount` decimal(16,8) NOT NULL DEFAULT 0.00000000,
  `manual_taxable_amount` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `discount` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `stone_amount` decimal(16,8) NOT NULL,
  `chitti_hide` int(11) DEFAULT 0,
  `ounce_rate` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `usd_rate` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `premium_rate` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `premium_usd_amount` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `labour_rate` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `labour_usd_amount` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `freight_usd_amount` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `taxable_usd_amount` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `ounce_gram_rate` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `product_rate` decimal(16,8) NOT NULL DEFAULT 0.00000000"
);

  
$this->db->query("ALTER TABLE `packing_slips`
  ADD PRIMARY KEY (`id`)");
$this->db->query("ALTER TABLE `packing_slips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT");
  }


}

?>