<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_period extends CI_Model {

  public function up()
  {
  	$sql ="alter table periods add updated_by int(11) default 0,add created_by int(11) default 0";
    $this->db->query($sql);
  }


}

?>