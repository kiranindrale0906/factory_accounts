<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Periods extends BaseController {
  public function __construct() {
      parent::__construct();
      $this->date_fields=array(
                            array(
                              'periods','date_from'),
                            array(
                              'periods','date_to'));
      $this->load->model('master/Period_model');
  }
}
