<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_refresh_table extends CI_Model {

  public function up()
  {
  	$this->db->query("drop table refresh_details");
    $this->db->query("CREATE TABLE IF NOT EXISTS `refresh` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `weight` decimal(16,8) NOT NULL,
						  `factory_fine` decimal(16,8) NOT NULL,
						  `fine` decimal(16,8) NOT NULL,
						  `purity` decimal(16,8) NOT NULL,
						  `factory_purity` decimal(16,8) NOT NULL,
						  `created_by` int(11) NOT NULL,
						  `created_at` datetime NOT NULL,
						  `updated_by` int(11) NOT NULL,
						  `updated_at` datetime NOT NULL,
						  `is_delete` int(11) NOT NULL DEFAULT 0,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
    $this->db->query("CREATE TABLE IF NOT EXISTS `refresh_details` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `refresh_id` int(11) NOT NULL,
						  `weight` decimal(16,8) NOT NULL,
						  `fine` decimal(16,8) NOT NULL,
						  `factory_fine` decimal(16,8) NOT NULL,
						  `purity` decimal(16,8) NOT NULL,
						  `factory_purity` decimal(16,8) NOT NULL,
						  `created_by` int(11) NOT NULL,
						  `created_at` datetime NOT NULL,
						  `updated_by` int(11) NOT NULL,
						  `updated_at` datetime NOT NULL,
						  `is_delete` int(11) NOT NULL DEFAULT 0,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
  }


}

?>