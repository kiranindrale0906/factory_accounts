<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_usd_column_in_ac_ledgers extends CI_Model {

  public function up()
  {
    $this->db->query("alter table ac_ledger add usd_debit_amount decimal(16,4) NOT NULL DEFAULT 0");
    $this->db->query("alter table ac_ledger add usd_credit_amount decimal(16,4) NOT NULL DEFAULT 0");
    $this->db->query("alter table ac_ledger add usd_rate decimal(16,4) NOT NULL DEFAULT 0");
 }


}

?>