<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_table_ac_vouchers_deparment_and_sales_voucher_fields extends CI_Model {

  public function up()
  {
  	$sql = "alter table ac_vouchers add department_name varchar(255),add department_id int(11),add total_gross_weight float(10,4) DEFAULT 0.0000,add total_net_weight float(10,4) DEFAULT 0.0000,add total_fine_weight float(10,4) DEFAULT 0.0000,add total_amount float(10,4) DEFAULT 0.0000";
    $this->db->query($sql);
  }


}

?>