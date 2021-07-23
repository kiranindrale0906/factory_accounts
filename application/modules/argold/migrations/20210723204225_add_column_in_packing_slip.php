<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_in_packing_slip extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `packing_slip_details` ADD `category_name` varchar(225) NULL DEFAULT NULL,ADD `site_name` varchar(225) NULL DEFAULT NULL");
  }


}

?>