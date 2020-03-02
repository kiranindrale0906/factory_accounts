<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_set_status_column_in_users_ extends CI_Model {

  public function up()
  {

  	$sql ="ALTER TABLE  `users` CHANGE  `status`  `status` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT  'Enabled';";
    //$this->db->query($sql);


  }


}

?>