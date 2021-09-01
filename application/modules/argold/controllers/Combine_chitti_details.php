<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Combine_chitti_details extends BaseController {
  public function __construct() {
    parent::__construct();
  }
  public function index() {
  	$combine_chitti_id=!empty($_GET['combine_chitti_id'])?$_GET['combine_chitti_id']:0;
    $this->where = 'combine_chitti_id ='.$combine_chitti_id;
    parent::index();
  }
}