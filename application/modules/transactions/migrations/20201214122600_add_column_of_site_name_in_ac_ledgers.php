<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_of_site_name_in_ac_ledgers extends CI_Model {

  public function up()
  {
       $this->db->query("ALTER TABLE `ac_ledger` ADD `site_name` varchar(225) NOT NULL DEFAULT ''");
 
  }


}

?>