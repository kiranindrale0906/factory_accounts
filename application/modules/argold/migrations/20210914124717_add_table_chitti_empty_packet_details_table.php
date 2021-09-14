<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_chitti_empty_packet_details_table extends CI_Model {

  public function up()
  {
    $this->db->query("CREATE TABLE `chitti_empty_packet_details` (
											  `id` int(11) NOT NULL AUTO_INCREMENT,
											  `weight` int(11) DEFAULT NULL,
											  `quantity` varchar(45) NOT NULL,
											  `chitti_id` int(11) DEFAULT '0',
											  `created_at` datetime NOT NULL,
											  `updated_at` datetime NOT NULL,
											  `is_delete` tinyint(1) DEFAULT '0',
											  `created_by` int(11) DEFAULT '0',
											  `updated_by` int(11) DEFAULT '0',
											  PRIMARY KEY (`id`)
											) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }


}

?>