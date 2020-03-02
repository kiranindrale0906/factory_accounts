<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Opening_balance extends BaseController {
  public $company_id=1;
  private $suffix = 'OB';
  private $_voucher_type = 'outstanding voucher';
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model','masters/group_model'));
    $this->date_fields=array(array('opening_balance','date'));
  }


    public function store()
    {
      $account_name=$this->account_model->get('name as name',
                                                      array(array('id'=>$this->input->post('opening_balance[account_name_id]')))
                                                    );
      $_POST['opening_balance']['account_name']=@$account_name[0]['name'];
      $_POST['opening_balance']['voucher_type'] = $this->_voucher_type;
      $_POST['opening_balance']['suffix'] = $this->suffix;
      $_POST['opening_balance']['voucher_number'] = $this->create_voucher_number($this->input->post('opening_balance'), $this->suffix, $this->_voucher_type);
      parent::store();
    }

    public function update($id)
    {
      $account_name=$this->account_model->get('name as name',
                                                      array(array('id'=>$this->input->post('opening_balance[account_name_id]')))
                                                    );
      $_POST['opening_balance']['account_name']=@$account_name[0]['name'];
      $_POST['opening_balance']['voucher_type'] = $this->_voucher_type;
      $_POST['opening_balance']['suffix'] = $this->suffix;
      $this->getAssocationData($this->company_id);
      parent::update($id);
    }

  public function _get_dependent_associations() {
    $company_id=1;
    $this->data['groups'] = $this->group_model->get('name as name,id as id',
                                                    array(
                                                      array('company_id'=>$company_id))
                                                    );
    $this->data['account_name'] = $this->account_model->get('name as name,id as id',
                                                            array(
                                                              array('company_id'=>$company_id))
                                                            );
    $cash_bill_types=array(
                        array('name'=>'Cash','id'=>'Cash'),
                        array('name'=>'Bill','id'=>'Bill')
                      );
    $this->data['cashbilltype']=$cash_bill_types;
  }
}
