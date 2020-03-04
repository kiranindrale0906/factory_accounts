<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_credit_weight_debit_amount_credit_amount_debit_weight_factory_purity_default extends CI_Model {

  public function up()
  {
  	$sql = "ALTER TABLE `ac_vouchers` CHANGE `credit_weight` `credit_weight` FLOAT(10,2) NOT NULL DEFAULT '0',CHANGE `debit_amount` `debit_amount` FLOAT(10,2) NULL DEFAULT '0', CHANGE `credit_amount` `credit_amount` FLOAT(10,2) NULL DEFAULT '0',CHANGE `debit_weight` `debit_weight` FLOAT(10,2) NOT NULL DEFAULT '0',CHANGE `factory_purity` `factory_purity` FLOAT(10,2) NULL DEFAULT '0';";
    $this->db->query($sql);
  }


}

?>