<?php
class Metal_receipt_voucher_details extends BaseController {
  protected $suffix = '';
  protected $voucher_type = '';
  protected $account_type = '';
  
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model','masters/purity_model','masters/group_model',
                             'masters/period_model'));
  }
  
  public function _get_form_data() {
    $company_id= !empty($this->session->userdata('company_id')) ? $this->session->userdata('company_id') : 1;
    
    $this->data['account_names'] = $this->account_model->get('ac_account.name as name, ac_account.id as id',
                                                              array(array('ac_account.name!=""'=>'')),
                                                              array(array('ac_groups',
                                                                          'ac_account.group_code=ac_groups.name','')),
                                                              array('ac_account.name asc'));

    $this->data['bank_names'] = $this->account_model->get('ac_account.name as name, ac_account.id as id',
                                                          array(array('ac_account.name!=""'=>''),
                                                                array('ac_account.group_code'=>'bank')),
                                                          array(array('ac_groups',
                                                                      'ac_account.group_code=ac_groups.name','')),
                                                          array('ac_account.name asc'));

    $this->data['purities'] = $this->purity_model->get('purity as name,id', array(array('company_id='=>$company_id)));

    $this->data['group_list'] = $this->group_model->get('name,id', array(array('company_id='=>$company_id)));
  }
}