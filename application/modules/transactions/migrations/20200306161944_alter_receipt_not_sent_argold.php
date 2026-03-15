<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_receipt_not_sent_argold extends CI_Model {

  public function up()
  {
  	$sql= "alter table receipt_not_sent_argold add api_url varchar(255)";
    $this->db->query($sql);
  }
}

?>