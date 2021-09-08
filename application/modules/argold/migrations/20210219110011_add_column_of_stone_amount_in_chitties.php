<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_of_stone_amount_in_chitties extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `chitties` ADD `stone_amount` DECIMAL(16,8) NOT NULL");
  }


}

?>