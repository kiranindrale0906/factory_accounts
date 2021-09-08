<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_decimal_no_in_ac_company extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_company` ADD `decimal_no` INT(11) NOT NULL ");
  }


}

?>