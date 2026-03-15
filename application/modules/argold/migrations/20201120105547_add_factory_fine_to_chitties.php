<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_factory_fine_to_chitties extends CI_Model {

  public function up()
  {
    $this->db->query("alter table chitties add factory_fine decimal(16, 8) NOT NULL DEFAULT 0");
    $this->db->query("alter table chitties add taxable_amount decimal(16, 8) NOT NULL DEFAULT 0");
  }
}

?>