<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_column_of_account_groups_and_voucher extends CI_Model {

  public function up()
  {
 //    $this->db->query("ALTER TABLE `ac_vouchers` ADD `group_id` INT(11) NOT NULL,
	// 				  ADD `route_group` VARCHAR(255) NOT NULL;");
	// $this->db->query("ALTER TABLE `ac_account` ADD `sub_group_id` INT(11) NOT NULL,
	// 				  ADD `sub_group_code` VARCHAR(255) NOT NULL,
 //                      ADD `route_group` VARCHAR(255) NOT NULL;");
	// $this->db->query("ALTER TABLE `ac_account` CHANGE `group_code_id` `group_id` INT(11) NULL DEFAULT NULL;");
	// $this->db->query("ALTER TABLE `ac_account` CHANGE `group_code_name` `group_code` varchar(225) NULL DEFAULT NULL;");
  }


}

?>