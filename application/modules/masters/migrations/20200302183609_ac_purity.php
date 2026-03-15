<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_ac_purity extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE IF NOT EXISTS `ac_purity` (
					  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
					  `purity` float(10,2) NOT NULL,
					  `company_id` int(11) NOT NULL,
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