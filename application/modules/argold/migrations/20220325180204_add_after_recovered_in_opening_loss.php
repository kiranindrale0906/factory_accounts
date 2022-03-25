<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_after_recovered_in_opening_loss extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `opening_loss_vouchers` ADD `after_recovered` decimal(16,4)  DEFAULT 0");
  }


}

?>