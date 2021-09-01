<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_in__credit_weight_in_combine_chitti extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `combine_chitties` ADD `credit_weight` decimal(16,8) NULL DEFAULT 0");
  }


}

?>