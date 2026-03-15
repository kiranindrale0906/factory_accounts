<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_in_refresh_table_refresh_hide extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `refresh` ADD `refresh_hide` INT(11) NULL DEFAULT '0'
");
  }


}

?>