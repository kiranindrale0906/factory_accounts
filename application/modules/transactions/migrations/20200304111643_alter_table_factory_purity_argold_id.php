<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_table_factory_purity_argold_id extends CI_Model {

  public function up()
  {
  	$sql = "alter table ac_vouchers add factory_purity float(10,2),add argold_id int(11)";
    $this->db->query($sql);
  }
}

?>