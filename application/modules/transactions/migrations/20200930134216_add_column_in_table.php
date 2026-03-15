<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_in_table extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `bw_accounts` CHANGE `balance_gross` `arg_balance_gross` DECIMAL(16,8) NULL DEFAULT NULL;");
	$this->db->query("ALTER TABLE `bw_accounts` ADD `arf_balance_gross` DECIMAL(16,8) NOT NULL;");
	$this->db->query("ALTER TABLE `bw_accounts` ADD `arc_balance_gross` DECIMAL(16,8) NOT NULL;");
  }


}

?>