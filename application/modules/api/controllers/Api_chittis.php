<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'modules/argold/controllers/Chittis.php';

class Api_chittis extends Chittis {
  public function __construct() {
    parent::__construct();
  }

  public function index() {
    if (   !empty($_POST['access_token']) 
        && $_POST['access_token']==API_ACCESS_TOKEN) {
      $chitti_details = []; 
      $chitti_details['chittis'] = $this->api_chitti_model->find('',array('id'=>$_POST['chitti_id']));
      $chitti_details['chitti_details'] = $this->voucher_model->get('sum(fine) as fine,sum(rate) as rate,sum(factory_fine) as factory_fine,sum(credit_weight) as credit_weight,group_concat(DISTINCT narration) as narration,purity,chitti_purity,factory_purity,customer_name,group_concat(item_code) as item_code',
							array('voucher_type'=>"metal issue voucher",'chitti_id'=>$_POST['chitti_id']), array(), array('group_by'=>'customer_name,chitti_purity,(factory_purity-chitti_purity),item_code','order_by' => 'item_code'));
      echo json_encode(array('data'    =>$chitti_details,
                             'status'      => 'success',
                             'open_modal'  => FALSE));
    } else {
      echo json_encode(array('status'      => 'error',
                             'open_modal'  => FALSE));
    }
    die;
  }
}
