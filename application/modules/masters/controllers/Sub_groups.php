<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_groups extends BaseController {

  public function __construct() {
      parent::__construct();
      $this->load->model('masters/group_model');
  }
}
