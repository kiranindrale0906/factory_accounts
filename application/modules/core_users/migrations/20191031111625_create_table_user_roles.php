<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_user_roles extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE IF NOT EXISTS `user_roles` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `name` varchar(255) NOT NULL,
					  `created_at` datetime NOT NULL,
					  `updated_at` datetime NOT NULL,
					  `is_delete` tinyint(4)  NULL DEFAULT 0,
					  `created_by` int(11) NULL,
					  `updated_by` int(11) NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
    $this->db->query($sql);
  }


}

?>