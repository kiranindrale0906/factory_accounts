<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_narrations_filed_in_chitties extends CI_Model {

  public function up()
  {
    $this->db->query("ALTER TABLE `chitties` ADD narration varchar(500) NULL DEFAULT NULL;");
  }


}

?>