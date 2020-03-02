<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_table_user_mobile_verified extends CI_Model {

  public function up()
  {
    $sql="alter table users add mobile_verified varchar(255)";
    $this->db->query($sql);
  }


}

?>