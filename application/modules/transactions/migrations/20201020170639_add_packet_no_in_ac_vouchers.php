<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_packet_no_in_ac_vouchers extends CI_Model {

  public function up()
  {
//    $this->db->query("ALTER TABLE `ac_vouchers` ADD `packet_no` INT(11) NOT NULL DEFAULT '0'");
    $this->db->query("ALTER TABLE `chitties` ADD `voucher_id` INT(11) NOT NULL DEFAULT '0'");
    $this->db->query("ALTER TABLE `chitties` ADD `packet_no` INT(11) NOT NULL DEFAULT '0'");
  }


}

?>
