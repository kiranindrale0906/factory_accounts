<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/argold/models/Chitti_model.php";
class Api_chitti_model extends Chitti_model {
  function __construct($data=array()) {
    parent::__construct($data);
  }
}