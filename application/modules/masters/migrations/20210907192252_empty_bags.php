<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_empty_bags extends CI_Model {

  public function up()
  {
    $this->db->query("");
  }


}

?>