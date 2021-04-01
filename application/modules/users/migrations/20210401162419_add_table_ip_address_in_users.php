<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_ip_address_in_users extends CI_Model {

  public function up()
  {
     $this->db->query("CREATE TABLE IF NOT EXISTS `ip_addresses` (
						   `id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
						  `ip_address` varchar(100) NOT NULL,
						  `user_id` int(11) NOT NULL,
						  `created_by` int(11) DEFAULT NULL,
						  `updated_by` int(11) DEFAULT NULL,
						  `created_at` datetime NOT NULL,
						  `updated_at` datetime NOT NULL,
						  `is_delete` int(4) NOT NULL);");
  }


}

?>