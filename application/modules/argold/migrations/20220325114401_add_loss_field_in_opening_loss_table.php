<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_loss_field_in_opening_loss_table extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `opening_loss_vouchers` ADD `type_of_loss` VARCHAR(250) NULL DEFAULT NULL, ADD `factory_name` VARCHAR(225) NULL DEFAULT NULL, ADD `quator` VARCHAR(225) NULL DEFAULT NULL;
");
  }


}

?>