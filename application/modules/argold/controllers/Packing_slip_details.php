<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Packing_slip_details extends BaseController {
  public function __construct() {
    parent::__construct();
  }
  public function index() {
  	$packing_slip_id=!empty($_GET['packing_slip_id'])?$_GET['packing_slip_id']:0;
    $this->where = 'packing_slip_id ='.$packing_slip_id;
    parent::index();
  }
  public function delete($id) {

    $voucher_id=!empty($_GET['voucher_id'])?$_GET['voucher_id']:0;
    $packing_details=$this->packing_slip_detail_model->find('',array('id'=>$id));
    if(!empty($voucher_id) && $voucher_id!=0){
      $voucher_details=$this->voucher_model->get('',array('packing_slip_id'=>$packing_details['packing_slip_id'],'id'=>$voucher_id));
      $this->packing_slip_detail_model->update_packing_slip_ids($voucher_details,$packing_details);
      parent::delete($id);
    }else{
      $voucher_details=$this->voucher_model->get('',array('packing_slip_id'=>$id));
      if(!empty($voucher_details)){
        $this->packing_slip_detail_model->update_packing_slip_ids($voucher_details,$packing_details);
      }
      parent::delete($id);
    }
  }
  public function _after_delete($formdata){
    $this->data['redirect_url']= ADMIN_PATH.'argold/packing_slips';
    return $formdata;
  }
}