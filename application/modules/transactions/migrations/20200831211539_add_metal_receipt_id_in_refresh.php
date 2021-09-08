<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_metal_receipt_id_in_refresh extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `refresh` ADD `metal_receipt_id` int(12) NOT NULL");
  }


}

?>