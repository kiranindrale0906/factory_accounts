<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_ac_ledger_purity_margin extends CI_Model {

  public function up()
  {
  	$sql = "alter table ac_ledger add purity_margin float(10,4)";
    $this->db->query($sql);
  }


}

?>