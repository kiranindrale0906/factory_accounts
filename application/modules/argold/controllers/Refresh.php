<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Refresh extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('masters/narration_model','argold/refresh_detail_model','transactions/metal_receipt_voucher_model'));
  }

  public function _get_form_data() {
    $this->data['purity'] = $this->narration_model->get('distinct(chain_purity) as name,chain_purity as  id', array('chain_purity >'=>0) ,array(), array('order_by'=>'id asc'));
    $this->data['item_names'] = array(
                                      array('id'=>'Rope Chain','name'=>'Rope Chain'),
                                      array('id'=>'Machine Chain','name'=>'Machine Chain'),
                                      array('id'=>'Choco Chain','name'=>'Choco Chain'),
                                      array('id'=>'Round Box Chain','name'=>'Round Box Chain'),
                                      array('id'=>'Sisma Chain','name'=>'Sisma Chain'),
                                      array('id'=>'Imp Italy Chain','name'=>'Imp Italy Chain'),
                                      array('id'=>'Indo Tally Chain','name'=>'Indo Tally Chain'),
                                      array('id'=>'Hollow Choco Chain','name'=>'Hollow Choco Chain'),
                                      array('id'=>'Refresh','name'=>'Refresh'),
                                      array('id'=>'Fancy Chain','name'=>'Fancy Chain')
                                    );//$this->narration_model->get('name as name, name as  id, chain_purity, chain_margin', array() ,array(), array('order_by'=>'name asc'));
    
  }
  public function _get_view_data() {
    $this->data['refresh_details'] = $this->refresh_detail_model->get('', array('refresh_id'=>$this->data['record']['id']));
    $this->data['refresh'] = $this->refresh_model->find('', array('id'=>$this->data['record']['id']));

    $this->data['metal_receipt_details'] = $this->metal_receipt_voucher_model->find('', array('id'=>$this->data['refresh']['metal_receipt_id']));

  }

}