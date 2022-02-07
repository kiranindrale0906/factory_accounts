<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_tag_no_and_factory_in_qr_code_ extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `qr_code_details` ADD `tag_no` INT(11) NOT NULL DEFAULT '0'");
    $this->db->query("ALTER TABLE `qr_codes` ADD `factory` varchar(225) NULL DEFAULT Null ");
    $this->db->query("ALTER TABLE `qr_code_details` CHANGE `weight` `gross_weight` DECIMAL(12,4) NOT NULL");
  }


}

?>