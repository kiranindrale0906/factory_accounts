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
                                      array('id'=>'Sisma Accessories Making Chain','name'=>'Sisma Accessories Making Chain'),
                                      array('id'=>'Imp Italy Chain','name'=>'Imp Italy Chain'),
                                      array('id'=>'Indo Tally Chain','name'=>'Indo Tally Chain'),
                                      array('id'=>'Hollow Choco Chain','name'=>'Hollow Choco Chain'),
                                      array('id'=>'Lotus Chain','name'=>'Lotus Chain'),
                                      array('id'=>'Nawabi Chain','name'=>'Nawabi Chain'),
                                      array('id'=>'Refresh','name'=>'Refresh'),
                                      array('id'=>'Fancy Chain','name'=>'Fancy Chain'),
                                      array('id'=>'Fancy 75 Chain','name'=>'Fancy 75 Chain'),
                                      array('id'=>'KA Chain','name'=>'KA Chain'),
                                      array('id'=>'Ball Chain','name'=>'Ball Chain'),
                                      array('id'=>'Office Outside','name'=>'Office Outside'),
                                      array('id'=>'Nano Process','name'=>'Nano Process'),
                                      array('id'=>'I 10 Process','name'=>'I 10 Process'),
                                      array('id'=>'Internal','name'=>'Internal'),
                                      array('id'=>'Dhoom A','name'=>'Dhoom A'),
                                      array('id'=>'Dhoom B','name'=>'Dhoom B'),
                                      array('id'=>'Nano Process','name'=>'Nano Process'),
                                      array('id'=>'KA Chain Refresh','name'=>'KA Chain Refresh'),
                                      array('id'=>'Stone Ring 92','name'=>'Stone Ring 92'),
                                      array('id'=>'Ring','name'=>'Ring'),
                                      array('id'=>'Ring 75','name'=>'Ring 75'),
                                      array('id'=>'Roco Choco Chain','name'=>'Roco Choco Chain'),
                                      array('id'=>'Solid Rope Chain','name'=>'Solid Rope Chain'),
                                      array('id'=>'Solid Machine Chain','name'=>'Solid Machine Chain'),
                                      array('id'=>'Solder','name'=>'Solder'),
                                      array('id'=>'Stone Ring 75','name'=>'Stone Ring 75'),
                                      array('id'=>'Plain Ring','name'=>'Plain Ring'),
                                      array('id'=>'Pendent Set','name'=>'Pendent Set'),
                                      array('id'=>'Pendent Set 75','name'=>'Pendent Set 75'),
                                      array('id'=>'Pendent Set Plain','name'=>'Pendent Set Plain'),
                                      array('id'=>'Lock Process','name'=>'Lock Process'),
                                      array('id'=>'Daily Drawer','name'=>'Daily Drawer'),
                                    );//$this->narration_model->get('name as name, name as  id, chain_purity, chain_margin', array() ,array(), array('order_by'=>'name asc'));
    
  }
  public function _get_view_data() {
    $this->data['refresh_details'] = $this->refresh_detail_model->get('', array('refresh_id'=>$this->data['record']['id']));
    $this->data['refresh'] = $this->refresh_model->find('', array('id'=>$this->data['record']['id']));

    $this->data['metal_receipt_details'] = $this->metal_receipt_voucher_model->find('', array('id'=>$this->data['refresh']['metal_receipt_id']));

  }

}