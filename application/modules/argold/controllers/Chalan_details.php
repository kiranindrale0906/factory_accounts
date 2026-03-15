<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chalan_details extends BaseController {
  public function __construct() {
    parent::__construct();
  }
  public function index() {
  	$chalan_id=!empty($_GET['chalan_id'])?$_GET['chalan_id']:0;
    $this->where = 'chalan_id ='.$chalan_id;
    parent::index();
  }
}