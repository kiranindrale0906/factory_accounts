<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_actual_weight_in_chitties extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `chitties` ADD `empty_packet_weight` decimal(16,8) NULL DEFAULT 0,
    										 ADD `expected_weight` decimal(16,8) NULL DEFAULT 0,
    										 ADD `actual_weight` decimal(16,8) NULL DEFAULT 0,
    										 ADD `diff_weight` decimal(16,8) NULL DEFAULT 0");
  }


}

?>