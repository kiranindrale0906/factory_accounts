<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_ac_voucher_hook_kdm_quantity extends CI_Model {

  public function up()
  {
  	$sql="alter table ac_vouchers add hook_kdm_purity float(10,4),add quantity int(10)";
    $this->db->query($sql);
  }


}

?>