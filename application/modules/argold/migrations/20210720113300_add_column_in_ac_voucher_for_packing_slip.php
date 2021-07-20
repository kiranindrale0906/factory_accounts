<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_in_ac_voucher_for_packing_slip extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers` ADD `packing_slip_sr_no` int(11) NULL DEFAULT '0',
									  ADD packing_slip_stone decimal(16,4) NULL DEFAULT '0',
									  ADD packing_slip_net_weight decimal(16,4) NULL DEFAULT '0',
									  ADD packing_slip_making_charge decimal(16,4) NULL DEFAULT '0',
									  ADD packing_slip_pure decimal(16,4) NULL DEFAULT '0',
									  ADD packing_slip_total decimal(16,4) NULL DEFAULT '0',
									  ADD packing_slip_description varchar(500) NULL DEFAULT NULL,
									  ADD packing_slip_colour varchar(100) NULL DEFAULT NULL,
									  ADD packing_slip_code varchar(100) NULL DEFAULT NULL");
        
  }


}

?>