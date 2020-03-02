<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_migrations extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE IF NOT EXISTS `migrations` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `version` bigint(20) DEFAULT NULL,
				  `module_name` varchar(50) DEFAULT NULL,
				  `file_name` varchar(255) DEFAULT NULL,
				  `created_at` datetime DEFAULT NULL,
				  `updated_at` datetime DEFAULT NULL,
				  `is_delete` tinyint(4) DEFAULT '0',
				  `created_by` int(11) ,
				  `updated_by` int(11),
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54";

    $this->db->query($sql);
  }


}

?>