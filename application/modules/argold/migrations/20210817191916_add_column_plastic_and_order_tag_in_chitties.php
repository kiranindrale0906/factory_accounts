<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_plastic_and_order_tag_in_chitties extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `chitties` ADD `order_tag` decimal(16,8) NULL DEFAULT 0,
    										 ADD `order_tag_quantity` decimal(16,8) NULL DEFAULT 0,
    										 ADD `plastic_tag` decimal(16,8) NULL DEFAULT 0,
    										 ADD `plastic_tag_quantity` decimal(16,8) NULL DEFAULT 0,
    										 ADD `other_item_gross` decimal(16,8) NULL DEFAULT 0");
  }


}

?>