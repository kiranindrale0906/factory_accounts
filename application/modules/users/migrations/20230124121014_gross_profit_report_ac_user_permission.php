<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_gross_profit_report_ac_user_permission extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_users` ADD `gross_profit_report` INT(11) NOT NULL DEFAULT '0' AFTER `vodator_report`;");
  }


}

?>