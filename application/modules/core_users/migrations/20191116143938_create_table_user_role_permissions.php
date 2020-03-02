<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_user_role_permissions extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE IF NOT EXISTS `user_role_permissions` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `user_role_id` int(11) NOT NULL,
				  `controller_name` varchar(255) NOT NULL,
				  `index` tinyint(1) NOT NULL DEFAULT '0',
				  `create` tinyint(1) NOT NULL DEFAULT '0',
				  `edit` tinyint(1) NOT NULL DEFAULT '0',
				  `view` tinyint(1) NOT NULL DEFAULT '0',
				  `delete` tinyint(1) NOT NULL DEFAULT '0',
				  `created_at` datetime NOT NULL,
				  `updated_at` datetime NOT NULL,
				  `is_delete` tinyint(4) NOT NULL,
				  `created_by` int(11) DEFAULT NULL,
				  `updated_by` int(11) DEFAULT NULL,
				  `module_name` VARCHAR( 255 ) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;";
    $this->db->query($sql);
  }


}

?>