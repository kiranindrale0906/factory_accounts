<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_ac_quartor_indb extends CI_Model {

  public function up()
  {
    $this->db->query("CREATE TABLE `ac_quators` (
								  `id` int(11) NOT NULL,
								  `name` varchar(225)  DEFAULT NULL,
								  `company_id` int(11) NOT NULL,
								  `from_date` datetime DEFAULT NULL,
								  `to_date` datetime DEFAULT NULL,
								  `created_at` datetime DEFAULT NULL,
								  `updated_at` datetime DEFAULT NULL,
								  `is_delete` tinyint(1) DEFAULT '0',
								  `created_by` int(11) DEFAULT '0',
								  `updated_by` int(11) DEFAULT '0'
								) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	$this->db->query("ALTER TABLE `ac_quators`
								  ADD PRIMARY KEY (`id`)");

	$this->db->query("ALTER TABLE `ac_quators`
								  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;");
  }


}

?>