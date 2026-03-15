<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_ac_payment_terms extends CI_Model {

  public function up()
  {
  	$sql= "CREATE TABLE IF NOT EXISTS `ac_payment_terms` (
				  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
				  `terms` int(11) NOT NULL,
				  `company_id` int(11) DEFAULT NULL,
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