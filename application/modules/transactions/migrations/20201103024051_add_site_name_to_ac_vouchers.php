<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_site_name_to_ac_vouchers extends CI_Model {

  public function up()
  {
    $this->db->query("alter table ac_vouchers add site_name varchar(10) NOT NULL DEFAULT ''");
  }


}

?>