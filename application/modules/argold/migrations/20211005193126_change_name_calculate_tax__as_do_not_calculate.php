<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_change_name_calculate_tax__as_do_not_calculate extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `ac_vouchers`
    CHANGE `calculate_tax` `do_not_calculate_tax` int(11) NULL DEFAULT 0
    ");
      }


}

?>