<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (file_exists(APPPATH . "modules/".CLIENT_NAME."/controllers/Client_chittis.php")) {

  require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Client_chittis.php";
  class Chittis extends Client_chittis {
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }

}
?>