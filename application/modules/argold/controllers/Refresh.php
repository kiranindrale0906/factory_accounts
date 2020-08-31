<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Refresh extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('masters/narration_model','argold/refresh_detail_model'));
  }

  public function _get_form_data() {
    $this->data['purity'] = $this->narration_model->get('distinct(chain_purity) as name,chain_purity as  id', array('chain_purity >'=>0) ,array(), array('order_by'=>'id asc'));
  }
  public function _get_view_data() {
    $this->data['refresh_details'] = $this->refresh_detail_model->get('', array('refresh_id'=>$this->data['record']['id']));
  }

}