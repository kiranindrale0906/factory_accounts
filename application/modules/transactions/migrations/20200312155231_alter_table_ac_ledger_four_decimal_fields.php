<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_table_ac_ledger_four_decimal_fields extends CI_Model {

  public function up()
  {
  	$sql = "alter table ac_ledger modify credit_amount float(10,4),modify debit_amount float(10,4),modify gold_weight float(10,4),modify gold_rate float(10,4),modify purity float(10,4),modify pure_gold float(10,4),modify gold_purity float(10,4),modify rate_cut_weight float(10,4),modify gold_weight_purity float(10,4),modify rate_cut_value float(10,4),modify gross_wt float(10,4),modify net_wt float(10,4),modify fine_wt float(10,4),modify value float(10,4),modify total_weight float(10,4),modify factory_purity float(10,4)";
    $this->db->query($sql);
  }
}

?>