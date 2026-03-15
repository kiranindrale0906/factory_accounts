<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_chalans_in_argold extends CI_Model {

  public function up()
  {
    $this->db->query("CREATE TABLE `chalans` (
								  `id` int(11) NOT NULL,
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
								  `sgst_amount` decimal(16,8) NOT NULL DEFAULT 0.00000000,
								  `cgst_amount` decimal(16,8) NOT NULL DEFAULT 0.00000000,
								  `taxable_amount` decimal(16,8) NOT NULL DEFAULT 0.00000000,
								  `chalan_hide` int(11) DEFAULT 0
											  )");
	$this->db->query("ALTER TABLE `chalans`  ADD PRIMARY KEY (`id`)");
	$this->db->query("ALTER TABLE `chalans` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT");
	$this->db->query("ALTER TABLE `chitties` ADD `chalan_id` int(11) NULL DEFAULT 0");
  
  }


}

?>