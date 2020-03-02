<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_column_prefrences extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE `column_prefrences` (
					  `id` int(9) NOT NULL AUTO_INCREMENT,
					  `user_id` bigint(20) DEFAULT NULL,
					  `list_page` varchar(100) DEFAULT NULL,
					  `select_column_json` text,
					  `arrange_column_json` text,
					  `is_delete` tinyint(4) NOT NULL DEFAULT '0',
					  `created_at` datetime NOT NULL ,
					  `updated_at` datetime NOT NULL ,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8";

    $this->db->query($sql);
  }


}

?>