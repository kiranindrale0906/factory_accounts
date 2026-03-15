<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_table_ac_voucher_four_decimal_field extends CI_Model {

  public function up()
  {
  	$sql = "alter table ac_vouchers modify credit_amount float(10,4),modify debit_amount float(10,4),modify amount float(10,4),modify purity float(10,4),modify pure_gold_credit float(10,4),modify pure_gold_debit float(10,4),modify factory_purity float(10,4)";
    $this->db->query($sql);
  }


}

?>