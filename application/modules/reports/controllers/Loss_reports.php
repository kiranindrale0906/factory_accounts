<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Loss_reports extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('ac_vouchers/voucher_model'));
  }

  public function index() {
    $this->data['report_type'] = 'Rojmel Report';
    $this->_get_form_data();
    $this->load->render($this->router->class."/index",$this->data);
  }
  public function _get_form_data() {
     $this->data['factory_name']=!empty($_GET['site_name'])?$_GET['site_name']:'';
    $this->data['site_name']            = (!empty($_GET['site_name'])) ? $_GET['site_name'] : 'All';
    $this->data['account_id']           = (!empty($_GET['account_id'])) ? $_GET['account_id'] : 0;
    
    $this->data['loss_categories']=array();
    $categories= $this->voucher_model->get('description', array('account_name'=>'Loss Account','parent_id'=>0),array(),array('group_by'=>'description'));
    $loss_details= $this->voucher_model->get('description,fine,id', array('account_name'=>'Loss Account','parent_id'=>0),array());
    if(!empty($loss_details)){
      foreach ($categories as $category_index => $category) {
        $total_fine=0;
        foreach ($loss_details as $index => $loss_detail) {
          if($loss_detail['description']==$category['description']){
          $receipt_data= $this->voucher_model->find('sum(fine) as fine', array('parent_id'=>$loss_detail['id']));
          $total_fine+=$loss_detail['fine']-$receipt_data['fine'];

          }
          $this->data['loss_categories'][$category['description']]['fine']=$total_fine; 
        }
      }
    }
    // parent::create();
  }
}

