<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (file_exists(APPPATH . "modules/".CLIENT_NAME."/models/Client_chitti_model.php")) {

  require_once APPPATH . "modules/".CLIENT_NAME."/models/Client_chitti_model.php";  
  class Chitti_model extends Client_chitti_model {
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }

} 