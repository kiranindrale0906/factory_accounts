<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Opening_quators extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/quator_model'));
  }
  public function _get_form_data() {
    $this->data['quators'] = $this->quator_model->get('distinct(name) as name,name as  id', array());
  }
}