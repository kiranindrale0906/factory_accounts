<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_credit_weight_in_chalan extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `chalans` ADD `credit_weight` decimal(16,8) NULL DEFAULT 0");
  
  }


}

?>