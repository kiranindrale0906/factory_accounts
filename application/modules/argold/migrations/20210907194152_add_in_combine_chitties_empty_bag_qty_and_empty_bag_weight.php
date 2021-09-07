<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_in_combine_chitties_empty_bag_qty_and_empty_bag_weight extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `combine_chitties`
    ADD `empty_bag_weight` decimal(16,8) zerofill NOT NULL,
    ADD `empty_bag_qty` int(11) zerofill NOT NULL AFTER `empty_bag_weight`;");
  }


}

?>