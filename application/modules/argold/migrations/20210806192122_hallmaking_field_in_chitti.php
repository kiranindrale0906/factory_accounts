<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_hallmaking_field_in_chitti extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `chitties` ADD `hallmark_taxable_amount` decimal(16,8) NULL DEFAULT 0,
    							 ADD `hallmark_taxable_amount_gst` decimal(16,8) NULL DEFAULT 0;");
  }


}

?>