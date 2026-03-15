<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_category_2_in_packing_slip extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `packing_slip_details` ADD `category_2` varchar(225) NULL DEFAULT NULL;");
  }


}

?>