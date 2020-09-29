<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_new_table_bw_accounts extends CI_Model {

  public function up()
  {
    $this->db->query("CREATE TABLE `bw_accounts` (
												  `id` int(10) UNSIGNED NOT NULL,
												  `factory_name` varchar(225) DEFAULT NULL,
												  `balance_gross` decimal(16,8) DEFAULT NULL,
												  `b_gross` decimal(16,8) DEFAULT NULL,
												  `w_gross` decimal(16,8) DEFAULT NULL,
												  `created_at` datetime DEFAULT NULL,
												  `updated_at` datetime DEFAULT NULL,
												  `is_delete` tinyint(1) DEFAULT '0',
												  `created_by` int(11) DEFAULT '0',
												  `updated_by` int(11) DEFAULT '0'
												)");
    $this->db->query("ALTER TABLE `bw_accounts` ADD PRIMARY KEY (`id`);");

	$this->db->query("ALTER TABLE `bw_accounts`
		  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;");
  }
  }


}

?>