<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_credit_debit_weight extends CI_Model {

  public function up()
  {
  	$sql = "alter table ac_vouchers modify credit_weight float(10,4),modify debit_weight float(10,4)";
    $this->db->query($sql);
  }
}

?>