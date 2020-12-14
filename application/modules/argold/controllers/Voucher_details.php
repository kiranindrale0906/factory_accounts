<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher_details extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('ac_vouchers/voucher_model', 'masters/account_model',
                             'argold/refresh_model', 'argold/refresh_detail_model',
                             'masters/narration_model'));
  }

  public function _get_view_data() {
    $this->data['account_id']='';
    $this->data['metal_vouchers'] = $this->voucher_model->get('',array('id'=>$this->data['record']['id']));
    $this->data['metal_voucher_details'] = $this->voucher_model->get('',
                                            array('metal_receipt_voucher_reference_id' => $this->data['record']['id'],
                                                  'voucher_type not in ("rate cut receipt voucher", "rate cut issue voucher")' => NULL));

    $this->data['refresh'] = $this->refresh_model->find('',array('metal_receipt_id'=>$this->data['record']['id']));
    $this->data['refresh_details'] = $this->refresh_detail_model->get('',array('refresh_id'=>$this->data['refresh']['id']));
  }
  public function delete($id) {
    $voucher_details=$this->voucher_model->get('',array('metal_receipt_voucher_reference_id'=>$id));
    foreach ($voucher_details as $index => $voucher) {
      $this->voucher_model->delete($voucher['id']);
    }
    parent::delete($id);
  }
  public function _after_delete($id) {
    redirect(base_url().'transactions/metal_receipt_vouchers');
    return $formdata;
  }

}