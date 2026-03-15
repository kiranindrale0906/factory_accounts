<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_empty_packets extends CI_Model {

  public function up()
  {
    $this->db->query("CREATE TABLE `empty_packets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weight` int(11) DEFAULT NULL,
  `qty` varchar(45) NOT NULL,
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