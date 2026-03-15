<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_chitti_hide_column_chitties extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `chitties` ADD `chitti_hide` INT(11) NULL DEFAULT '0'");
  }


}

?>