<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_ac_vouchers extends CI_Model {

  public function up()
  {
  	$sql="CREATE TABLE `ac_vouchers` (
				  `id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
				  `company_id` int(11) UNSIGNED DEFAULT NULL,
				  `period_id` int(11) UNSIGNED NOT NULL,
				  `voucher_serial_number` int(11) UNSIGNED NOT NULL,
				  `voucher_number` varchar(255) DEFAULT NULL,
				  `suffix` varchar(255) DEFAULT 'CI',
				  `account_name` varchar(255) DEFAULT NULL,
				  `bank_name` varchar(45) DEFAULT NULL,
				  `account_id` int(11) DEFAULT NULL,
				  `bank_id` int(11) DEFAULT NULL,
				  `from_account_name` varchar(255) NOT NULL,
				  `from_account_id` int(11) UNSIGNED NOT NULL,
				  `voucher_date` date DEFAULT NULL,
				  `narration` varchar(255) DEFAULT NULL,
				  `sales_type` varchar(255) DEFAULT NULL,
				  `voucher_type` varchar(255) DEFAULT NULL,
				  `transaction_type` varchar(255) DEFAULT 'account',
				  `amount` float(10,2) DEFAULT NULL,
				  `credit_amount` float(10,2) DEFAULT NULL,
				  `debit_amount` float(10,2) DEFAULT NULL,
				  `cheque_number` varchar(255) DEFAULT NULL,
				  `sales_voucher_id` int(11) UNSIGNED DEFAULT NULL,
				  `document` varchar(255) DEFAULT NULL,
				  `credit_weight` float(10,2) NOT NULL,
				  `debit_weight` float(10,2) NOT NULL,
				  `purity` float(10,2) NOT NULL,
				  `purity_id` float NOT NULL,
				  `pure_gold_credit` float(10,2) NOT NULL,
				  `pure_gold_debit` float(10,2) NOT NULL,
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