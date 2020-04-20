<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_add_modified_username_to_name extends CI_Model {

  public function up()
 	{
  	$sql= "alter table ac_users change first_name name varchar(255)";
    //$this->db->query($sql);
  }
}

?>