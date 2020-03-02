<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_field_sign_in_sign_ip extends CI_Model {

  public function up()
  {
  	$sql ="alter table ac_users add `last_sign_in_at` datetime,add `last_sign_in_ip` varchar(255)";
    $this->db->query($sql);
  }
}

?>