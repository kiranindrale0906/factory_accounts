<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_company_api_url extends CI_Model {

  public function up()
  {
  	$sql = "alter table ac_company add api_url varchar(255)";
    $this->db->query($sql);
  }


}

?>