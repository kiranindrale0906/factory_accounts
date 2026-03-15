<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_ac_ledger_decimal_value extends CI_Model {

  public function up()
  {
  	$sql = "alter table ac_ledger modify credit_amount float(14,4),modify debit_amount float(14,4),modify gold_weight float(14,4),modify gold_rate float(14,4),modify purity float(14,4),modify pure_gold float(14,4),modify gold_purity float(14,4),modify rate_cut_weight float(14,4),modify gold_weight_purity float(14,4),modify rate_cut_value float(14,4),modify gross_wt float(14,4),modify net_wt float(14,4),modify fine_wt float(14,4),modify value float(14,4),modify total_weight float(14,4),modify factory_purity float(14,4)";
    $this->db->query($sql);
  }


}

?>