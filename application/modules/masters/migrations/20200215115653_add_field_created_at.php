<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_field_created_at extends CI_Model {

  public function up()
  {
  	//'ac_menu',
    $fields = array('ac_menu');

    foreach ($fields as $table_name) {
      $sql="alter table ".$table_name." add created_at DATETIME";
      //$this->db->query($sql);
    }
  }


}

?>