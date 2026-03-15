<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_in_ac_vouchers_domestic_labour_chitti_id extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `domestic_labour_chitti_id` int(11) NULL DEFAULT '0',ADD `process_rate` decimal(16,8) NULL DEFAULT '0';");
    $this->db->query("CREATE TABLE `domestic_labour_chitties` (
						  `id` int(11) NOT NULL,
						  `voucher_id` int(11) NOT NULL,
						  `rate` decimal(10,4) NOT NULL DEFAULT 0,
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
						  `packet_no` int(11) NOT NULL DEFAULT 0,
						  `factory_purity` decimal(16,8) NOT NULL DEFAULT 0.00000000,
						  `credit_weight` decimal(16,8) NOT NULL DEFAULT 0.00000000,
						  `balance` decimal(16,4) DEFAULT 0.0000,
						  `total` decimal(16,4) DEFAULT 0.0000,
						  `factory_fine` decimal(16,4) NOT NULL
						)");
    $this->db->query("ALTER TABLE `domestic_labour_chitties`ADD PRIMARY KEY (`id`);");
    $this->db->query("ALTER TABLE `domestic_labour_chitties` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT");
  }


}

?>