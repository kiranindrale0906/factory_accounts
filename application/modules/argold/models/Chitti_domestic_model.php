<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 require_once APPPATH . "modules/argold/models/Chitti_model.php";  
  class Chitti_domestic_model extends Chitti_model {
  	public $router_class = "chitti_domestics";
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }