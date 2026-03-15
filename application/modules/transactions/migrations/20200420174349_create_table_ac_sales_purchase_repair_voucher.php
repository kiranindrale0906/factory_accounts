<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_ac_sales_purchase_repair_voucher extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE IF NOT EXISTS `ac_sales_purchase_repair_voucher` (
		  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
		  `company_id` int(11) DEFAULT NULL,
		  `voucher_number` varchar(45) DEFAULT NULL,
		  `suffix` varchar(255) DEFAULT NULL,
		  `date` date DEFAULT NULL,
		  `transaction_type` varchar(45) NOT NULL,
		  `voucher_type` varchar(45) DEFAULT NULL,
		  `account_name` varchar(45) NOT NULL,
		  `cash_bill_type` varchar(255) DEFAULT NULL,
		  `gst_number` varchar(255) DEFAULT NULL,
		  `gross_wt` float(10,2) DEFAULT NULL,
		  `net_wt` float(10,2) DEFAULT NULL,
		  `fine_wt` float(10,2) DEFAULT NULL,
		  `value` float(10,2) DEFAULT NULL,
		  `remaining_value` float(10,2) DEFAULT NULL,
		  `gold_rate` float NOT NULL,
		  `gold_purity` float NOT NULL,
		  `has_hallmark` int(11) NOT NULL DEFAULT '0',
		  `hallmark_number` varchar(255) DEFAULT NULL,
		  `sales_voucher_dispatch_id` int(11) DEFAULT NULL,
		  `payment_terms` varchar(255) DEFAULT NULL,
		  `angadia_slip` varchar(255) DEFAULT NULL,
		  `sign_chitti` varchar(255) DEFAULT NULL,
		  `sales_purchase_repair_voucher_out_id` int(11) DEFAULT NULL,
		  `created_at` datetime NOT NULL,
		  `updated_at` datetime NOT NULL,
		  `is_delete` tinyint(1) DEFAULT '0',
		  `created_by` int(11) DEFAULT '0',
		  `updated_by` int(11) DEFAULT '0'
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $this->db->query($sql);
  }


}

?>