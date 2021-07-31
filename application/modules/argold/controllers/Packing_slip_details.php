<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Packing_slip_details extends BaseController {
  public function __construct() {
    parent::__construct();
  }
  public function index() {
  	$packing_slip_id=!empty($_GET['packing_slip_id'])?$_GET['packing_slip_id']:0;
    $this->where = 'packing_slip_id ='.$packing_slip_id;
    parent::index();
  }
}