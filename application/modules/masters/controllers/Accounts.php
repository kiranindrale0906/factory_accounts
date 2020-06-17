<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends BaseController {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('others/city_model', 'others/state_model', 'masters/group_model', 'others/salesman_model','others/account_wise_detail_model', 'masters/sub_group_model',
                             'masters/payment_term_model'));
  }

  public function index() {
    if(!empty($_POST['account_name'])) {
      $data=$this->model->get('name',array('name like "%'.$_POST['account_name'].'%"'=>NULL));
      echo json_encode(array('data'=>$data,'status'=>'success')); die;
    }

    parent::index();
  }

  public function _get_form_data() {
    $company_id=!empty($_SESSION['company_id'])?$_SESSION['company_id']:1;
    // $this->data['cities'] = $this->city_model->get('name,
    //                                                 name as id',
    //                                                 array(array('company_id'=>$company_id)));
    // $this->data['groups'] = $this->group_model->get('name,
    //                                                  name as id',array(
    //                                                  array('company_id'=>$company_id)));
    // $this->data['states'] = $this->state_model->get('name,
    //                                                  name as id',
    //                                                  array(array('company_id'=>$company_id)));
    // $this->data['payment_terms'] = $this->payment_term_model->get('terms as name,
    //                                                               terms as id',
    //                                                               array(array('company_id'=>$company_id)));
  }
}
