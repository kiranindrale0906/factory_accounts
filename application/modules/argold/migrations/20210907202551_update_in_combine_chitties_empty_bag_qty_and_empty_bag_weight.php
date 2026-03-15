<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_update_in_combine_chitties_empty_bag_qty_and_empty_bag_weight extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `combine_chitties`
    CHANGE `empty_bag_weight` `empty_bag_weight` decimal(16,8) NOT NULL DEFAULT '0.00000000' AFTER `site_name`,
    CHANGE `empty_bag_qty` `empty_bag_qty` int(11) NOT NULL DEFAULT '0' AFTER `empty_bag_weight`;");
  }


}

?>