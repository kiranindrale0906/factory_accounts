<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/core_users/controllers/Core_logout.php";
class Logout extends Core_logout {

  public function __construct() {
    parent::__construct();
  }
  public function index() {
    $this->session->sess_destroy();
    redirect(base_url().'users/login/create');
  }
}