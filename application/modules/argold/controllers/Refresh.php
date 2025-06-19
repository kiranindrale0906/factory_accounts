<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Refresh extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('masters/narration_model','argold/refresh_detail_model','masters/item_name_model','transactions/metal_receipt_voucher_model'));
  }

  public function _get_form_data() {
    $this->data['purity'] = $this->narration_model->get('distinct(chain_purity) as name,chain_purity as  id', array('chain_purity >'=>0) ,array(), array('order_by'=>'id asc'));
    $this->data['item_names'] = $this->item_name_model->get('distinct(name) as name,name as id');
  }
  public function _get_view_data() {
    $this->data['refresh_details'] = $this->refresh_detail_model->get('', array('refresh_id'=>$this->data['record']['id']));
    $this->data['refresh'] = $this->refresh_model->find('', array('id'=>$this->data['record']['id']));

    $this->data['metal_receipt_details'] = $this->metal_receipt_voucher_model->find('', array('id'=>$this->data['refresh']['metal_receipt_id']));

  }

}
