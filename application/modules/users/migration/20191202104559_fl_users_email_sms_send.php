<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_fl_users_email_sms_send extends CI_Model {

  public function up()
  {
  	$sql="alter table users add  email_sent_at DATETIME,add sms_sent_at DATETIME";
    $this->db->query($sql);
  }


}

?>