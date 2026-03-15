<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_table_create_receipt_not_sent_argold extends CI_Model {

  public function up()
  {
  	$sql="CREATE TABLE IF NOT EXISTS `receipt_not_sent_argold` (
				  `id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
				  `type` varchar(255),
				  `account` varchar(255),
				  `in_weight` float(10,2) DEFAULT 0,
				  `in_lot_purity` float(10,2) DEFAULT 0,
				  `hook_kdm_purity` float(10,2) DEFAULT 0,
				  `quantity` int(10),
				  `description` varchar(255),
				  `process_name` varchar(255),
				  `karigar` varchar(255),
				  `argold_account_id` int(11) DEFAULT 0,
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
