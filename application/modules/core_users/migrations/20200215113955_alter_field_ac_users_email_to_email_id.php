<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_field_ac_users_email_to_email_id extends CI_Model {

  public function up()
  {
  	$sql="alter table ac_users change email email_id varchar(255)";
    //$this->db->query($sql);
  }


}

?>