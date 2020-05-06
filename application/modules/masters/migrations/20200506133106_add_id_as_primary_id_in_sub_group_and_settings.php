<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_id_as_primary_id_in_sub_group_and_settings extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_settings` ADD PRIMARY KEY (`id`);");
    $this->db->query("ALTER TABLE `ac_settings` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;");
    $this->db->query("ALTER TABLE `ac_sub_groups` ADD PRIMARY KEY (`id`);");
    $this->db->query("ALTER TABLE `ac_sub_groups` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;");
  }


}

?>