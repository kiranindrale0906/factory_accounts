<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Loss_accounts extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('ac_vouchers/voucher_model'));
  }

  public function index() { 
    redirect(base_url().'reports/loss_accounts/create');
  }
  public function create() {
    $this->data['loss_categories']=array();
    $categories= $this->voucher_model->get('description', array('account_name'=>'Loss Account','parent_id'=>0,'date(created_at)<'=>'2021-03-17'),array(),array('group_by'=>'description'));
    $loss_details= $this->voucher_model->get('description,fine,id', array('account_name'=>'Loss Account','parent_id'=>0,'date(created_at)<'=>'2021-03-13'),array());
    if(!empty($loss_details)){
      foreach ($categories as $category_index => $category) {
        $total_fine=0;
        foreach ($loss_details as $index => $loss_detail) {
          if($loss_detail['description']==$category['description']){
          $receipt_data= $this->voucher_model->find('sum(fine) as fine', array('parent_id'=>$loss_detail['id']));
          $total_fine+=$loss_detail['fine']-$receipt_data['fine'];

          }
          $this->data['loss_categories'][$category['description']]['fine']=four_decimal($total_fine); 
        }
      }
    }
    parent::create();
  }
}

