<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 require_once APPPATH . "modules/argold/models/Chitti_model.php";  
  class Chitti_export_model extends Chitti_model {
  	public $router_class = "chitti_exports";
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }