<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_ac_voucher_fine_factory_fine extends CI_Model {

  public function up()
  {
  	$sql = "alter table ac_vouchers add fine float(10,4),add factory_fine float(10,4)";
    $this->db->query($sql);
  }
}

?>