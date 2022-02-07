<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_qr_code_details extends CI_Model {

  public function up()
  {
    $this->db->query("CREATE TABLE `qr_code_details` (
										 `id` int NOT NULL AUTO_INCREMENT,
										 `qr_code_id` int NOT NULL,
										 `weight` decimal(12,4) NOT NULL,
										 `length` decimal(12,4) NOT NULL,
										 `created_by` int NOT NULL,
										 `created_at` datetime NOT NULL,
										 `updated_by` int NOT NULL,
										 `updated_at` datetime NOT NULL,
										 `is_delete` int NOT NULL DEFAULT '0',
										 `net_weight` decimal(10,4) NOT NULL DEFAULT '0.0000',
										 `total_stone` decimal(10,2) NOT NULL,
										 `less` decimal(10,2) NOT NULL,
										 `percentage` decimal(10,2) NOT NULL,
										 `purity` decimal(10,2) NOT NULL,
										 `design_code` varchar(100) NOT NULL,
										 `stone_count` int DEFAULT NULL,
										 PRIMARY KEY (`id`)
										) ENGINE=InnoDB DEFAULT CHARSET=latin1");
  }


}

?>