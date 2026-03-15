<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_qr_codes extends CI_Model {

  public function up()
  {
    $this->db->query("CREATE TABLE `qr_codes` (
										 `id` int NOT NULL AUTO_INCREMENT,
										 `purity` varchar(25) NOT NULL,
										 `created_at` datetime DEFAULT NULL,
										 `updated_at` datetime DEFAULT NULL,
										 `created_by` int NOT NULL,
										 `updated_by` int NOT NULL,
										 `is_delete` tinyint NOT NULL DEFAULT '0',
										 PRIMARY KEY (`id`)
										) ENGINE=InnoDB DEFAULT CHARSET=latin1");
  }


}

?>