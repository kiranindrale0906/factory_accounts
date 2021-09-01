<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Combine_chitties extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('chittis', 'date'));
    $this->redirect_after_save = 'view';
    $this->load->model(array('ac_vouchers/voucher_model','masters/account_model','masters/narration_model','argold/chitti_model','argold/Combine_chitti_detail_model'));
  }
  
  public function view($id) {
    $this->data['layout'] = 'plain';
    parent::view($id);
  }

  public function _get_view_data() {
    $this->data['detail'] = isset($_GET['detail']) ? 1 : 0;
    $this->data['account_id']='';
    $this->data['chitti_details'] = $this->chitti_model->get('', array('combine_chitti_id' => $this->data['record']['id']));
    $this->data['total_of_chitti_details'] = $this->chitti_model->find('sum(taxable_amount) as taxable_amount,sum(weight) as weight,sum(debit_amount) as debit_amount,sum(credit_weight) as credit_weight,sum(cgst_amount) as cgst_amount,sum(sgst_amount) as sgst_amount,(rate) as rate', array('chalan_id' => $this->data['record']['id']));
  }

  public function _get_form_data() {
    $this->data['account_name']=$this->chitti_model->get('distinct(account_name) as name,account_name as id');
    $this->data['purity']=$this->chitti_model->get('distinct(purity) as name,purity as id');
    if (!empty($_GET['account_name']))
      $this->data['record']['account_name'] = $_GET['account_name'];
      $this->data['record']['purity'] = @$_GET['purity'];
    $where=array('chalan_id=' => 0);
    
    if(!empty($this->data['record']['account_name'])) { 
      $where['account_name']=$this->data['record']['account_name'];
      if(!empty($this->data['record']['purity'])){
        $where['purity']=$this->data['record']['purity'];
      }
      $where['date > '] = '2021-08-17';
      $this->data['chitti_details'] = $this->chitti_model->get('', $where);
    } else{
      $this->data['chitti_details'] = array();
      if ($this->router->method == 'store' || $this->router->method == 'update') {
        $this->data['record']['combine_chitties'] = $_POST['combine_chitties'];
        $this->data['combine_chitti_details'] = @$_POST['combine_chitti_details'];
      }
    }
  }

  public function store() {
    $this->data['redirect_url'] = '/argold/combine_chitties';
    parent::store();
  }
  public function delete($id) {
      $chitti_id=!empty($_GET['chitti_id'])?$_GET['chitti_id']:0;
    if(!empty($chitti_id) && $chitti_id!=0){
      $chitti_details=$this->chitti_model->get('',array('combine_chitti_id'=>$id,'id'=>$chitti_id));
      
      $this->combine_chitti_model->update_combine_chitti_ids($chitti_details);
      redirect(base_url().'argold/combine_chitties/view/'.$id);
    }else{
      $chitti_details=$this->chitti_model->get('',array('combine_chitti_id'=>$id));
      if(!empty($chitti_details)){
        $this->combine_chitti_model->update_combine_chitti_ids($combine_chitti_details);
      }
      parent::delete($id);
    }
  }
  public function _after_save($formdata, $action){
     $this->data['redirect_url']= ADMIN_PATH.'argold/combine_chitties';
    return $formdata;
  }
}
