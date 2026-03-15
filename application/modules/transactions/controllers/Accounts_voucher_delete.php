<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts_voucher extends BaseController {
  protected $suffix = '';
  protected $voucher_type = '';
  protected $account_type = '';
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model',
                             'masters/period_model'));
  }

  public function _get_form_data() {
    $company_id=(!empty($this->session->userdata('company_id'))?$this->session->userdata('company_id'):1);
    $this->data['account_names'] = $this->account_model->get('ac_account.name as name,
                                                              ac_account.id as id',
                                                              array(array('ac_account.name!=""'=>'')),
                                                              array(array('ac_groups',
                                                                          'ac_account.group_code=ac_groups.name','')),
                                                              array('ac_account.name asc'));

    $this->data['bank_names'] = $this->account_model->get('ac_account.name as name,
                                                          ac_account.id as id',
                                                          array(
                                                            array('ac_account.name!=""'=>''),
                                                            array('ac_account.group_code'=>'bank')),
                                                          array(array('ac_groups',
                                                                      'ac_account.group_code=ac_groups.name','')),
                                                          array('ac_account.name asc'));

    $this->data['purities'] = $this->purity_model->get('purity as name,id',
                                                        array(array('company_id='=>$company_id)));

    $this->data['group_list'] = $this->group_model->get('name,id',
                                                        array(array('company_id='=>$company_id)));
  }

  public function store() {
    $this->set_period_id();
    // $_POST[$this->router->class]['voucher_serial_number'] = $this->create_voucher_serial_number(
    //                                                           $this->voucher_type,
    //                                                           $_POST[$this->router->class]['period_id']);
    // $_POST[$this->router->class]['voucher_number'] = $this->create_voucher_number(
    //                                                     $this->suffix,
    //                                                     $_POST[$this->router->class]['voucher_serial_number'],
    //                                                     $_POST[$this->router->class]['voucher_date']);
    $_POST[$this->router->class]['transaction_type'] = $this->account_type;
    $_POST[$this->router->class]['voucher_type'] = $this->voucher_type;
    $_POST[$this->router->class]['suffix'] = $this->suffix;

    if(!empty($_POST[$this->router->class]['purity'])) {
      $purity_id=$this->purity_model->get('id',
                                          array(
                                            array('purity'=>$_POST[$this->router->class]['purity']))
                                          );  
      $_POST[$this->router->class]['purity_id']=@$purity_id[0]['id'];

      if(!empty($_POST[$this->router->class]['credit_weight'])) {
        $pure_gold=($_POST[$this->router->class]['credit_weight']*$_POST[$this->router->class]['purity'])/100;
        $_POST[$this->router->class]['pure_gold_credit'] =$pure_gold;
      }

      if(!empty($_POST[$this->router->class]['debit_weight'])) {
        $pure_gold=($_POST[$this->router->class]['debit_weight']*$_POST[$this->router->class]['purity'])/100;
        $_POST[$this->router->class]['pure_gold_debit'] =$pure_gold;
      }
    }

    $class_names=array('journal_voucher','contra_voucher');
    if(in_array($this->router->class,$class_names)) {
      unset($_POST[$this->router->class]['from_group_name']);
      unset($_POST[$this->router->class]['to_group_name']);
    }

    $res = parent::store();
  }
  
  public function update($id) {
    //$this->set_account_name();
    if(!empty($_POST[$this->router->class]['purity'])) {
      $purity_id=$this->purity_model->get('id',
                                          array(
                                            array('purity'=>$_POST[$this->router->class]['purity']))
                                          );  
      $_POST[$this->router->class]['purity_id']=@$purity_id[0]['id'];

      if(!empty($_POST[$this->router->class]['credit_weight'])) {
        $pure_gold=($_POST[$this->router->class]['credit_weight']*$_POST[$this->router->class]['purity'])/100;
        $_POST[$this->router->class]['pure_gold_credit'] =$pure_gold;
      }

      if(!empty($_POST[$this->router->class]['debit_weight'])) {
        $pure_gold=($_POST[$this->router->class]['debit_weight']*$_POST[$this->router->class]['purity'])/100;
        $_POST[$this->router->class]['pure_gold_debit'] =$pure_gold;
      }
    }

    $class_names=array('journal_voucher','contra_voucher');
    if(in_array($this->router->class,$class_names)) {
      unset($_POST[$this->router->class]['from_group_name']);
      unset($_POST[$this->router->class]['to_group_name']);
    }
    parent::update($id);
  }

  private function set_period_id() {
    $set_voucher_date=date('Y-m-d',strtotime($this->input->post($this->router->class.'[voucher_date]')));  
    $period_id = $this->period_model->get('id',
                                          array(
                                            array('"'.$set_voucher_date.'" between date_from and date_to'=>NULL)));
    $_POST[$this->router->class]['period_id'] = @$period_id[0]['id'];
  }

  public function print_voucher($id) {
    $data = array();
    $company_id=(!empty($this->session->userdata('company_id'))?$this->session->userdata('company_id'):1);
    $data['company_data'] = $this->company_model->get('*',
                                                      array(
                                                              array('id'=>$company_id)));
    $_model=$this->router->class."_model";
    $_controller=$this->router->class;
    $data['data'] = $this->$_model->get('*',
                                      array(
                                        array('id'=>$id)));
    $this->load->view($_controller.'/view', $data);
  }
}