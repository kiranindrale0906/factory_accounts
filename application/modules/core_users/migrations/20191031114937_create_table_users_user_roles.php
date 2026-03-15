<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_users_user_roles extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE IF NOT EXISTS `users_user_roles` (
  					`id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
					  `user_id` int(11) NOT NULL,
					  `user_role_id` int(11) NOT NULL,
					  `created_at` datetime NOT NULL,
					  `updated_at` datetime NOT NULL,
					  `is_delete` tinyint(4)  NULL DEFAULT 0,
					  `created_by` int(11) NULL,
					  `updated_by` int(11) NULL
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $this->db->query($sql);
  }


}

?>