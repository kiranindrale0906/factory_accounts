<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_ac_company extends CI_Model {

  public function up()
  {
  	$sql ="CREATE TABLE `ac_company` (
				  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `address` text,
				  `logo` varchar(255) DEFAULT NULL,
				  `created_at` datetime NOT NULL,
				  `updated_at` datetime NOT NULL,
				  `address_line1` varchar(255) DEFAULT NULL,
				  `address_line2` varchar(255) DEFAULT NULL,
				  `city` varchar(255) DEFAULT NULL,
				  `state` varchar(255) DEFAULT NULL,
				  `pincode` varchar(255) DEFAULT NULL,
				  `is_delete` tinyint(1) DEFAULT '0',
				  `created_by` int(11) DEFAULT '0',
				  `updated_by` int(11) DEFAULT '0'
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $this->db->query($sql);
  }


}

?>