<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_ac_sales_purchase_details extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE IF NOT EXISTS `ac_sales_purchase_details` (
				  `id` int(11) NOT NULL,
				  `company_id` int(11) DEFAULT NULL,
				  `sales_purchase_voucher_id` int(11) NOT NULL,
				  `transaction_type` varchar(45) DEFAULT NULL,
				  `voucher_type` varchar(45) DEFAULT NULL,
				  `category` varchar(45) DEFAULT NULL,
				  `category_id` int(11) DEFAULT NULL,
				  `product` varchar(45) DEFAULT NULL,
				  `karigar_name` varchar(255) DEFAULT NULL,
				  `gross_wt` float(10,3) DEFAULT NULL,
				  `net_wt` float(10,3) DEFAULT NULL,
				  `moti_wt` float(10,3) DEFAULT NULL,
				  `fine_wt` float(10,3) DEFAULT NULL,
				  `pl_wt` float(10,3) DEFAULT NULL,
				  `gld_wt` float(10,3) DEFAULT NULL,
				  `melting` float(10,2) DEFAULT NULL,
				  `wastage` float(10,2) DEFAULT NULL,
				  `rate` decimal(10,2) DEFAULT NULL,
				  `pure` float(10,3) DEFAULT NULL,
				  `gold_amount` decimal(10,2) DEFAULT NULL,
				  `labour_rate` float(10,2) DEFAULT NULL,
				  `amount` float(10,2) DEFAULT NULL,
				  `other_charges` float(10,2) DEFAULT NULL,
				  `total_making` int(11) NOT NULL,
				  `description` varchar(45) DEFAULT NULL,
				  `created_at` datetime NOT NULL,
				  `updated_at` datetime NOT NULL,
				  `color_stone_wt` float(10,3) DEFAULT NULL,
				  `color_stone_amt` float(10,2) DEFAULT NULL,
				  `checker_wt` float(10,3) DEFAULT NULL,
				  `checker_rate` float(10,2) DEFAULT NULL,
				  `checker_amt` float(10,2) DEFAULT NULL,
				  `checker_pcs` int(11) DEFAULT NULL,
				  `kundan_wt` float(10,3) DEFAULT NULL,
				  `kundan_pcs` int(11) DEFAULT NULL,
				  `kundan_rate` float(10,2) DEFAULT NULL,
				  `kundan_amt` float(10,2) DEFAULT NULL,
				  `bead_wt` float(10,3) DEFAULT NULL,
				  `total_amount` float(10,2) DEFAULT NULL,
				  `item_code` varchar(255) NOT NULL,
				  `department_name` varchar(255) NOT NULL,
				  `department_id` int(8) NOT NULL,
				  `is_delete` tinyint(1) DEFAULT '0',
				  `created_by` int(11) DEFAULT '0',
				  `updated_by` int(11) DEFAULT '0'
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $this->db->query($sql);
  }


}

?>