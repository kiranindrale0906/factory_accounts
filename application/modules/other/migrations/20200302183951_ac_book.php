<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_ac_book extends CI_Model {

  public function up()
  {
  	$sql = "CREATE TABLE `ac_book` (
					  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
					  `company_id` int(11) DEFAULT NULL,
					  `name` varchar(45) NOT NULL,
					  `book_code` varchar(45) NOT NULL,
					  `pcs` int(11) NOT NULL,
					  `gross_wt` bigint(20) NOT NULL,
					  `melting` bigint(20) NOT NULL,
					  `wastage` bigint(20) NOT NULL,
					  `fine_wt` bigint(20) NOT NULL,
					  `amount` bigint(20) NOT NULL,
					  `created_at` datetime NOT NULL,
					  `updated_at` datetime NOT NULL,
					  `is_delete` tinyint(1) DEFAULT '0',
					  `created_by` int(11) DEFAULT '0',
					  `updated_by` int(11) DEFAULT '0'
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $this->db->query($sql);
  }


}

?>