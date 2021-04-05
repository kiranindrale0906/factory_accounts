<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'modules/sys/controllers/Core_mysqldump.php');
class Mysqldump extends Core_mysqldump {
  public function __construct(){
    parent::__construct();
  }
}