<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_table_users_email_mobile_verify_code extends CI_Model {

  public function up()
  {
  	$sql="alter table users add email_verify_code varchar(20), add mobile_verify_code int(6)";
    $this->db->query($sql);
  }


}

?>