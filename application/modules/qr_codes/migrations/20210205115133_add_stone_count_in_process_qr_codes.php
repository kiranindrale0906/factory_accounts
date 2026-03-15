<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_stone_count_in_process_qr_codes extends CI_Model {

  public function up()
  {
    //$this->db->query("ALTER TABLE `process_qr_codes` ADD `stone_count` INT(11) NULL AFTER `design_code`;");
  }


}

?>