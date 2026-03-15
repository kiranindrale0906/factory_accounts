<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Domestic_labour_chitties extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('chittis', 'date'));
    $this->redirect_after_save = 'view';
    $this->load->model(array('ac_vouchers/voucher_model','masters/account_model','masters/narration_model','argold/chitti_model','argold/packing_slip_detail_model'));
  }
  
  public function view($id) {
    $this->data['layout'] = 'plain';
    parent::view($id);
  }

  public function _get_view_data() {
    $this->data['detail'] = isset($_GET['detail']) ? 1 : 0;
    $this->data['account_id']='';
    $this->data['metal_voucher_details'] = $this->voucher_model->get('', array('domestic_labour_chitti_id' => $this->data['record']['id']));
  }

  public function _get_form_data() {

    $this->data['account_name']=$this->account_model->get('distinct(name) as name,name as id',array('sub_group_code'=>'Domestic Labour Account'));
    $this->data['purity'] = $this->voucher_model->get('purity as name, purity as id', 
                                                       array('where'=>array(
                                                               'voucher_type' => 'metal issue voucher',
                                                               'domestic_labour_chitti_id' => 0,
                                                               'receipt_type in ("Finish Good","GPC Out")'=>NULL
                                                             )) ,
                                                       array(), array('group_by' => 'purity'));
    
    if (!empty($_GET['account_name']))
      $this->data['record']['account_name'] = $_GET['account_name'];
    $where=array('voucher_type' => 'metal issue voucher','domestic_labour_chitti_id' => 0,);
    
    if(!empty($this->data['record']['account_name'])) { 
      $where['account_name']=$this->data['record']['account_name'];
    if (!empty($_GET['voucher_id'])){
      unset($where['domestic_labour_chitti_id']);
      $where['id']=$_GET['voucher_id'];
      $this->data['metal_vouchers'] = $this->voucher_model->get('',$where);
    
    }else{
      $where['voucher_date > '] = '2021-08-04';
      $this->data['metal_vouchers'] = $this->voucher_model->get('sum(credit_weight) as credit_weight,
                                                                sum(fine) as fine,
                                                                sum(factory_fine) as factory_fine,
                                                                (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                                                                (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,
                                                                "" as voucher_number,
                                                                packet_no,
                                                                voucher_date,
                                                                customer_name,
                                                                group_concat(narration) as narration,
                                                                argold_id as argold_id,site_name', 
                                                                $where, 
                                                                array(), 
                                                                array('group_by'=>'packet_no,
                                                                                   voucher_date, 
                                                                                   argold_id,customer_name,site_name'));}
    

    } else{
      $this->data['metal_vouchers'] = array();
      
      if ($this->router->method == 'store' || $this->router->method == 'update') {
        $this->data['record']['domestic_labour_chitties'] = $_POST['domestic_labour_chitties'];
        $this->data['domestic_labour_chitti_details'] = @$_POST['domestic_labour_chitti_details'];
      }
    }
  }

  public function store() {
    $this->data['redirect_url'] = '/argold/domestic_labour_chitties';
    parent::store();
  }
  public function delete($id) {
    $voucher_id=!empty($_GET['voucher_id'])?$_GET['voucher_id']:0;
    if(!empty($voucher_id) && $voucher_id!=0){
      $voucher_details=$this->voucher_model->get('',array('chitti_id'=>$id,'id'=>$voucher_id));
      $this->chitti_model->update_chitti_ids($voucher_details);
      redirect(base_url().'argold/domestic_labour_chitties/view/'.$id);
    }else{
      $voucher_details=$this->voucher_model->get('',array('chitti_id'=>$id));
      if(!empty($voucher_details)){
        $this->chitti_model->update_chitti_ids($voucher_details);
      }
      parent::delete($id);
    }
  }
  public function _after_save($formdata, $action){
     $this->data['redirect_url']= ADMIN_PATH.'argold/domestic_labour_chitties';
    return $formdata;
  }
}