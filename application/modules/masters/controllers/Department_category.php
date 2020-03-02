<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Department_category extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model('masters/department_model');
  }

  public function _get_form_data() {
    $company_id=!empty($_SESSION['company_id'])?$_SESSION['company_id']:1;
    $this->data['department_name'] = $this->department_model->get('name as name,id as id',
                                                                  array('where'=>array(
                                                                    'company_id'=>$company_id)));
  }
}
