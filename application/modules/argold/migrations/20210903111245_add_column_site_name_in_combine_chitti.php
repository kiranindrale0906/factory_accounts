<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_column_site_name_in_combine_chitti extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `combine_chitties` ADD `site_name` varchar(100) NULL DEFAULT ''");
  }


}

?>