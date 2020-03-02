<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_migration_add_field_ac_users extends CI_Model {

  public function up()
  {
  	$sql="alter table ac_users add mobile_no varchar(255)";
    //$this->db->query($sql);
  }


}

?>