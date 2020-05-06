<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_in_master_as_ac_subgroup extends CI_Model {

  public function up()
  {
    $this->db->query("CREATE TABLE `ac_sub_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `group_id` int(11) NOT NULL,
  `group_name` varchar(225) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_delete` int(11) NOT NULL DEFAULT '0'
)");

  }


}

?>