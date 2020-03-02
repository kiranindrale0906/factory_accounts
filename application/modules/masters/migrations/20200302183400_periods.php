<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_periods extends CI_Model {

  public function up()
  {
  	$sql="CREATE TABLE `periods` (
				  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
				  `name` varchar(255) DEFAULT NULL,
				  `date_from` date DEFAULT NULL,
				  `date_to` date DEFAULT NULL,
				  `created_at` datetime DEFAULT NULL,
				  `updated_at` datetime DEFAULT NULL,
				  `is_delete` tinyint(1) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $this->db->query($sql);
  }


}

?>