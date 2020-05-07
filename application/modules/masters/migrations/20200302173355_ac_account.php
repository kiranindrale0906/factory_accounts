<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_ac_account extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE IF NOT EXISTS `ac_account` (
					  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
					  `company_id` int(11) DEFAULT NULL,
					  `name` varchar(45) NOT NULL,
					  `account_code` varchar(45) NOT NULL,
					  `group_code` varchar(255) NOT NULL,
					  `group_code_id` int(11) DEFAULT NULL,
					  `payment_terms` varchar(255) DEFAULT NULL,
					  `cont_person` varchar(45) NOT NULL,
					  `salesman_code` int(11) NOT NULL,
					  `address` text NOT NULL,
					  `city` varchar(45) NOT NULL,
					  `state` varchar(45) NOT NULL,
					  `pin` int(11) NOT NULL,
					  `area` varchar(45) NOT NULL,
					  `off_tel` bigint(20) DEFAULT NULL,
					  `res_tel` bigint(20) DEFAULT NULL,
					  `coll_days` int(11) NOT NULL,
					  `cr_days` int(11) NOT NULL,
					  `interest_rate` float NOT NULL,
					  `salary` float NOT NULL,
					  `email` varchar(45) NOT NULL,
					  `web_address` varchar(45) NOT NULL,
					  `cst_no` int(11) NOT NULL,
					  `mvat_lst_no` int(11) NOT NULL,
					  `pan_no` bigint(20) NOT NULL,
					  `srv_tax_no` bigint(20) NOT NULL,
					  `sms_mobile_no` bigint(20) NOT NULL,
					  `fine_wt_limit` int(11) NOT NULL,
					  `remark` varchar(45) NOT NULL,
					  `created_at` datetime DEFAULT NULL,
					  `updated_at` datetime NOT NULL,
					  `is_delete` tinyint(1) DEFAULT '0',
					  `created_by` int(11) DEFAULT '0',
					  `updated_by` int(11) DEFAULT '0'
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $this->db->query($sql);
  }


}

?>