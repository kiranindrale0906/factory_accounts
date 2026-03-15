<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Vouchers extends BaseController {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model', 'transactions/ledger_model', 'masters/group_model',
                             'masters/company_model','argold/refresh_model','masters/cash_bill_model','masters/narration_model',
                             'masters/narration_model', 'masters/purity_model','masters/payment_term_model', 'masters/department_category_model','masters/department_model'));
  }

  public function index() {
    $this->_get_form_data();
    parent::index();
  }

  public function store() {
    $this->data['open_modal'] = false;
    $this->data['redirect_url'] = ADMIN_PATH.'transactions/metal_receipt_vouchers';
    $this->data['ajax_success_function']= "location.reload()";
    parent::store(); 
  }

  public function _get_form_data() {
    $company_id=(!empty($this->session->userdata('company_id'))?$this->session->userdata('company_id'):0);
    $this->data['account_names'] = $this->account_model->get('ac_account.name as name,
                                                              ac_account.name as id',
                                                              array('where'=>array('ac_account.name!=""'=>'')),
                                                              array(array('ac_groups',
                                                                          'ac_account.group_code=ac_groups.name','')),
                                                              array('order_by'=>'ac_account.name asc'));

    $this->data['bank_names'] = $this->account_model->get('ac_account.name as name,
                                                          ac_account.id as id',
                                                          array('where'=>
                                                            array('ac_account.name!=""'=>''),
                                                            array('ac_account.group_code'=>'bank')),
                                                          array(array('ac_groups',
                                                                      'ac_account.group_code=ac_groups.name','')),
                                                          array('order_by'=>'ac_account.name asc'));
    // $this->data['daily_drawer_type'] = get_daily_drawer_receipt_type();
    // $this->data['purities'] = $this->purity_model->get('purity as name,id',
    //                                                    array('where'=>array('company_id='=>$company_id)),
    //                                                    array(), array('order_by'=>'purity asc'));

    $this->data['group_list'] = $this->group_model->get('name,id',
                                                        array('where'=>array('company_id='=>$company_id)),
                                                        array(), array('order_by'=>'name asc'));
    $this->data['department_name'] = $this->department_model->get('name,id', array() ,array(), array('order_by'=>'name asc'));
    $this->data['department_category']=$this->department_category_model->get('name as name',array(),array(), array('order_by'=>'name asc'));
    $this->data['purity_list'] = $this->purity_model->get('purity as name,purity id', array() ,array(), array('order_by'=>'purity asc'));
    $this->data['payment_term'] = $this->payment_term_model->get('terms as name,terms as  id', array() ,array(), array('order_by'=>'terms asc'));
    $this->data['narrations'] = $this->narration_model->get('name as name, name as  id, chain_purity, chain_margin', array() ,array(), array('order_by'=>'name asc'));
    $this->data['chain_purity'] = $this->narration_model->get('distinct(chain_purity) as name,chain_purity as  id', array() ,array(), array('order_by'=>'id asc'));

    $this->data['transaction_type'] = get_transaction_type();
    //$this->data['hook_kdm_purity'] = get_melting_purity();
    $this->data['has_hallmark'] = get_has_hallmark();
  }

  public function view($id) {
    $this->print_voucher($id);
  }

  private function print_voucher($id) {
    $this->data['layout']='application';
    $company_id=(!empty($this->session->userdata('company_id'))?$this->session->userdata('company_id'):0);
    $this->data['company_data'] = $this->company_model->get('*',
                                                      array('where'=>array('id'=>$company_id)));
    $model=(!empty($this->model_name))?$this->model_name:singular($this->router->class);
    $modelname=$model."_model";
    $this->data['data'] = $this->$modelname->get('*',array('where'=>array('id'=>$id)));
    $this->load->view($this->router->module."/".$this->router->class.'/view', $this->data);
  }

  // public function uplaod_print_document($id) {
  //     $this->upload_files();
  //     $postData = $this->input->post();
  //     $response_data = $this->model->update($postData[$this->class]);
  //     $response_data['redirect_url'] = base_url($this->class . '/print_voucher/' . $id . '?updated=true');
  //     $response_data['status'] = 'success';
  //     echo json_encode($response_data);
  // }
}
