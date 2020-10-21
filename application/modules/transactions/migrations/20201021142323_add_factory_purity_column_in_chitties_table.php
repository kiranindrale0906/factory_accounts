<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_factory_purity_column_in_chitties_table extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `chitties` ADD `factory_purity` decimal(16,8) NOT NULL DEFAULT '0'");
  }


}

?>