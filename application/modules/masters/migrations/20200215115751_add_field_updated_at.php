<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_field_updated_at extends CI_Model {

  public function up()
  {
    $fields = array('ac_menu');

    foreach ($fields as $table_name) {
      $sql="alter table ".$table_name." add updated_at DATETIME";
      $this->db->query($sql);
    }
  }


}

?>