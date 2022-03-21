<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_opening_loss_vouchers_in_db extends CI_Model {

  public function up()
  {
    $this->db->query("CREATE TABLE `opening_loss_vouchers` (
			  `id` int(11) NOT NULL,
			  `loss` decimal(16,8) DEFAULT 0,
			  `out_weight` decimal(16,8) DEFAULT 0,
			  `purity` decimal(16,8) DEFAULT 0,
			  `recovered_loss` decimal(16,8) DEFAULT 0,
			  `unrecovered_loss` decimal(16,8) DEFAULT 0,
			  `date` datetime DEFAULT NULL,
			  `created_at` datetime DEFAULT NULL,
			  `updated_at` datetime DEFAULT NULL,
			  `created_by` int(11) DEFAULT NULL,
			  `updated_by` int(11) DEFAULT NULL,
			  `is_delete` tinyint(4) NOT NULL DEFAULT 0
			);");
    $this->db->query("ALTER TABLE `opening_loss_vouchers`
  		ADD PRIMARY KEY (`id`);");
    $this->db->query("ALTER TABLE `opening_loss_vouchers`
		  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
		");
  }


}

?>