<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_sale_type_to_ac_vouchers extends CI_Model {

  public function up()
  {
    $this->db->query("alter table ac_vouchers add sale_type varchar(20) NOT NULL DEFAULT ''");
  }


}

?>