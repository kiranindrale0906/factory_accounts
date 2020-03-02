<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_ac_opening_balance extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE `ac_opening_balance` (
					  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
					  `company_id` int(11) DEFAULT NULL,
					  `voucher_number` varchar(255) DEFAULT NULL,
					  `date` date NOT NULL,
					  `suffix` varchar(45) NOT NULL,
					  `account_name` varchar(255) DEFAULT NULL,
					  `account_name_id` int(11) DEFAULT NULL,
					  `group_code` int(11) NOT NULL,
					  `narration` varchar(255) DEFAULT NULL,
					  `voucher_type` varchar(45) DEFAULT NULL,
					  `credit_amount` float NOT NULL,
					  `cah_bill_type` varchar(255) DEFAULT NULL,
					  `cash_bill_type` varchar(255) DEFAULT NULL,
					  `gst_number` varchar(255) DEFAULT NULL,
					  `created_at` datetime NOT NULL,
					  `debit_amount` float NOT NULL,
					  `credit_weight` float(10,3) NOT NULL,
					  `debit_weight` float(10,3) NOT NULL,
					  `updated_at` datetime NOT NULL,
					  `is_delete` tinyint(1) DEFAULT '0',
					  `created_by` int(11) DEFAULT '0',
					  `updated_by` int(11) DEFAULT '0'
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $this->db->query($sql);
  }


}

?>