<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_ac_department extends CI_Model {

  public function up()
  {
  	$sql= "CREATE TABLE IF NOT EXISTS `ac_department` (
				  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
				  `company_id` int(11) DEFAULT NULL,
				  `name` varchar(255) DEFAULT NULL,
				  `taggable` int(11) NOT NULL,
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