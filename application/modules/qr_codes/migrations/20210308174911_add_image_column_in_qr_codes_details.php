<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_image_column_in_qr_codes_details extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `qr_code_details` ADD `image` VARCHAR(255) NULL");
  }


}

?>