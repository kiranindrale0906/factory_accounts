<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_table_user_email_verified extends CI_Model {

  public function up()
  {
  	$sql="alter table users add email_verified varchar(255)";
    //$this->db->query($sql);
  }


}

?>