<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends BaseController {

  public function __construct() {
      parent::__construct();
  }

  public function _get_form_data() {
    $this->data['route_group']=array(array('id'=>'Asset','name'=>'Asset'),
                                     array('id'=>'Liabilities','name'=>'Liabilities'),
                                     array('id'=>'Income','name'=>'Income'),
                                     array('id'=>'Expenses','name'=>'Expenses'));
    }
}
