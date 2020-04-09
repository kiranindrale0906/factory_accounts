<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_ac_voucher_metal_receipt_voucher_reference_id extends CI_Model {

  public function up()
  {
  	$sql = "alter table ac_vouchers add metal_receipt_voucher_reference_id int(11) unsigned";
    $this->db->query($sql);
  }


}

?>