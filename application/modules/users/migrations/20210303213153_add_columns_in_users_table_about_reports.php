<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_in_users_table_about_reports extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_users` ADD `arc_details` INT(11) NOT NULL DEFAULT '0' AFTER `mobile_no`, ADD `arf_details` INT(11) NOT NULL DEFAULT '0' , ADD `arg_details` INT(11) NOT NULL DEFAULT '0', ADD `vodator_report` INT(11) NOT NULL DEFAULT '0' , ADD `production_report` INT(11) NOT NULL DEFAULT '0' ;
");
  }


}

?>