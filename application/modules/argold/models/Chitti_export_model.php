<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 require_once APPPATH . "modules/argold/models/chitti_model.php";  
  class Chitti_export_model extends chitti_model {
  	public $router_class = "chitti_exports";
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }