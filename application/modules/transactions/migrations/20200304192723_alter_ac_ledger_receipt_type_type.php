<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_ac_ledger_receipt_type_type extends CI_Model {

  public function up()
  {
  	$sql = "alter table ac_ledger add receipt_type varchar(255),add type varchar(255)";
    $this->db->query($sql);
  }


}

?>