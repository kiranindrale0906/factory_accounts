<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_ac_ledger extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE IF NOT EXISTS `ac_ledger` (
				  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
				  `gold_rate_purity` float(10,2) DEFAULT NULL,
				  `company_id` int(11) DEFAULT NULL,
				  `voucher_number` varchar(255) DEFAULT NULL,
				  `account_name` varchar(255) DEFAULT NULL,
				  `account_id` int(11) DEFAULT NULL,
				  `from_account_name` varchar(255) NOT NULL,
				  `from_account_id` int(11) UNSIGNED NOT NULL,
				  `voucher_date` date NOT NULL,
				  `overdue_date` date DEFAULT NULL,
				  `bank_name` varchar(255) DEFAULT NULL,
				  `bank_id` int(11) DEFAULT NULL,
				  `voucher_type` varchar(255) DEFAULT NULL,
				  `suffix` varchar(255) DEFAULT NULL,
				  `narration` varchar(255) DEFAULT NULL,
				  `kundan_category` varchar(255) DEFAULT NULL,
				  `cs_category` varchar(255) DEFAULT NULL,
				  `ch_category` varchar(255) DEFAULT NULL,
				  `beads_category` varchar(255) DEFAULT NULL,
				  `status` int(11) DEFAULT NULL,
				  `amount` varchar(255) NOT NULL,
				  `credit_amount` float NOT NULL DEFAULT '0',
				  `debit_amount` float NOT NULL DEFAULT '0',
				  `cheque_number` varchar(255) DEFAULT NULL,
				  `gold_weight` float(10,3) NOT NULL,
				  `gold_rate` float NOT NULL,
				  `purity` varchar(255) NOT NULL,
				  `purity_id` float(10,2) DEFAULT NULL,
				  `pure_gold` varchar(255) DEFAULT NULL,
				  `gold_purity` float NOT NULL,
				  `gold_purity_id` float(10,2) DEFAULT NULL,
				  `has_hallmark` int(11) NOT NULL DEFAULT '0',
				  `hallmark_number` varchar(255) DEFAULT NULL,
				  `rate_cut_weight` float NOT NULL,
				  `gold_weight_purity` float(10,2) DEFAULT NULL,
				  `rate_cut_value` float NOT NULL,
				  `credit_weight` float(10,3) NOT NULL,
				  `debit_weight` float(10,3) NOT NULL,
				  `gst_number` varchar(255) DEFAULT NULL,
				  `gross_wt` float(10,3) NOT NULL,
				  `net_wt` float(10,3) NOT NULL,
				  `fine_wt` float(10,3) NOT NULL,
				  `value` float NOT NULL,
				  `total_weight` float(10,3) DEFAULT NULL,
				  `transaction_type` varchar(255) DEFAULT NULL,
				  `table_name` varchar(255) NOT NULL,
				  `table_id` int(11) NOT NULL,
				  `sales_voucher_dispatch_id` int(11) DEFAULT NULL,
				  `approve_repaire_approve_id` int(11) NOT NULL,
				  `payment_terms` varchar(255) DEFAULT NULL,
				  `sales_voucher_id` int(11) DEFAULT NULL,
				  `document` varchar(255) DEFAULT NULL,
				  `angadia_slip` varchar(255) DEFAULT NULL,
				  `sign_chitti` varchar(255) DEFAULT NULL,
				  `department_name` varchar(255) DEFAULT NULL,
				  `department_name_id` int(11) DEFAULT NULL,
				  `created_at` datetime NOT NULL,
				  `updated_at` datetime NOT NULL,
				  `cash_bill_type` varchar(255) DEFAULT NULL,
				  `is_delete` tinyint(1) DEFAULT '0',
				  `created_by` int(11) DEFAULT '0',
				  `updated_by` int(11) DEFAULT '0'
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    $this->db->query($sql);
  }


}

?>