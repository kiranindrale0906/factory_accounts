<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_gross_weight_packing_slip extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `packing_slip_details` ADD `gross_weight` decimal(16,4) NULL DEFAULT '0'");
    $this->db->query("ALTER TABLE `packing_slips` ADD `gross_weight` decimal(16,4) NULL DEFAULT '0'");
  }


}

?>