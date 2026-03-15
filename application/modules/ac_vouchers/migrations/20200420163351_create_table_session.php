<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_session extends CI_Model {

  public function up()
  {
  	$sql ="CREATE TABLE IF NOT EXISTS `ci_sessions` (
		  `id` varchar(128) NOT NULL,
		  `user_id` int(11) DEFAULT NULL,
		  `ip_address` varchar(45) NOT NULL,
		  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
		  `data` blob NOT NULL,
		  `created_at` datetime NOT NULL,
		  `updated_at` datetime NOT NULL,
		  `is_delete` tinyint(4) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $this->db->query($sql);
  }
}

?>