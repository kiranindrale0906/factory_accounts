<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_ac_voucher_receipt_type_type_description extends CI_Model {

  public function up()
  {
  	$sql = "alter table ac_vouchers add receipt_type varchar(255),add type varchar(255)";
    $this->db->query($sql);
  }


}

?>