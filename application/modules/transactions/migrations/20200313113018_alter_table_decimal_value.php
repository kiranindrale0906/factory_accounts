<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_table_decimal_value extends CI_Model {

  public function up()
  {
  	$sql = "alter table ac_vouchers modify credit_amount float(14,4),modify debit_amount float(14,4),modify amount float(14,4),modify purity float(14,4),modify pure_gold_credit float(14,4),modify pure_gold_debit float(14,4),modify factory_purity float(14,4),modify credit_weight float(14,4),modify debit_weight float(14,4),modify purity_margin float(14,4),modify fine float(14,4),modify factory_fine float(14,4)";
    $this->db->query($sql);
  }


}

?>