<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_ac_item extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE IF NOT EXISTS `ac_item` (
					  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
					  `company_id` int(11) DEFAULT NULL,
					  `name` varchar(45) DEFAULT NULL,
					  `item_code` varchar(45) DEFAULT NULL,
					  `avg_melting` bigint(20) NOT NULL,
					  `melting_from` varchar(45) DEFAULT NULL,
					  `melting_to` varchar(45) DEFAULT NULL,
					  `created_at` datetime DEFAULT NULL,
					  `updated_at` datetime DEFAULT NULL,
					  `is_delete` tinyint(1) DEFAULT '0',
					  `created_by` int(11) DEFAULT '0',
					  `updated_by` int(11) DEFAULT '0'
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $this->db->query($sql);
  }


}

?>