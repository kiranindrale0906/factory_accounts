<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_audit_logs extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE IF NOT EXISTS `audit_logs` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `created_at` datetime NOT NULL,
			  `updated_at` datetime DEFAULT NULL,
			  `created_by` int(11) DEFAULT NULL,
			  `model_name` varchar(255) DEFAULT NULL,
			  `old_attributes` text NOT NULL,
			  `new_attributes` text NOT NULL,
			  `record_id` int(11) DEFAULT NULL,
			  `action` varchar(11) DEFAULT NULL,
			  `updated_by` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
    $this->db->query($sql);
  }


}

?>