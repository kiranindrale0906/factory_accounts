<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_packet_quantity__column extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `chitties` ADD `empty_packet_quantity` decimal(16,8) NULL DEFAULT 0");
  }


}

?>