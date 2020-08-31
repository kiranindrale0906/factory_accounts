<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_refresh_table_in_transaction extends CI_Model {

  public function up()
  {
    $this->db->query("CREATE TABLE `refresh` (
											  `id` int(11) NOT NULL,
											  `weight` decimal(10,4) NOT NULL,
											  `fine` decimal(10,4) NOT NULL,
											  `purity` decimal(16,8) NOT NULL,
											  `created_at` datetime NOT NULL,
											  `updated_at` datetime NOT NULL,
											  `created_by` int(11) NOT NULL,
											  `updated_by` int(11) NOT NULL,
											  `is_delete` tinyint(4) NOT NULL
											) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $this->db->query("ALTER TABLE `refresh`
  ADD PRIMARY KEY (`id`);");
  }


}

?>