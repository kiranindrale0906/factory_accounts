<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_ac_users extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE IF NOT EXISTS `ac_users` (
		  `id` int(11) NOT NULL,
		  `username` varchar(45) CHARACTER SET big5 DEFAULT NULL,
		  `email_id` varchar(255) DEFAULT NULL,
		  `password` varchar(255) DEFAULT NULL,
		  `encrypted_id` varchar(255) DEFAULT NULL,
		  `role` varchar(45) DEFAULT NULL,
		  `department_id` int(11) NOT NULL DEFAULT '0',
		  `created_at` datetime DEFAULT NULL,
		  `updated_at` datetime DEFAULT NULL,
		  `name` varchar(255) DEFAULT NULL,
		  `last_name` varchar(255) DEFAULT NULL,
		  `status` int(11) DEFAULT NULL,
		  `branch_id` int(11) NOT NULL,
		  `is_delete` tinyint(1) DEFAULT '0',
		  `created_by` int(11) DEFAULT '0',
		  `updated_by` int(11) DEFAULT '0',
		  `last_sign_in_at` datetime DEFAULT NULL,
		  `last_sign_in_ip` varchar(255) DEFAULT NULL,
		  `mobile_no` varchar(255) DEFAULT NULL
		) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;";
    $this->db->query($sql);
  }


}

?>