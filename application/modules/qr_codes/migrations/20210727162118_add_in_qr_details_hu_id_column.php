<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_in_qr_details_hu_id_column extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `qr_code_details` ADD `hu_id` VARCHAR(15) NULL");
  }
}

?>