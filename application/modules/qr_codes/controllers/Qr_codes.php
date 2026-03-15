<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qr_codes extends BaseController { 
  public function __construct(){
    $this->_model='qr_code_model';
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->data['validation_klass'] = 'record';
    $this->load->model(array('qr_codes/qr_code_detail_model'));
    $this->data['file_data'] = array(array('file_field_name'=>'import_files',
                                           'file_controller'=>'qr_code_details'));
  } 
  public function store() {
    if(!empty($_FILES['qr_codes']))
      $this->data['validation_klass'] = 'import_file';
      $this->data['message']='File Uploaded Successfully';
      $this->data['redirect_url']=base_url($this->router->module.'/'.$this->router->class);
    parent::store();
  }

  public function _get_form_data() {                              
    if($this->router->method == 'edit' || $this->router->method == 'update' || $this->router->method == 'store'){
      if(!empty($this->data['record']['id'])){
        $this->data['qr_code_details']=$this->qr_code_detail_model->get(
                                    'FORMAT(net_weight,2) net_weight,
                                      percentage,FORMAT(gross_weight,2) gross_weight,less,
                                      FORMAT(length,2) length,hu_id,
                                      total_stone,
                                      stone_count,',
                                    array('qr_code_id'=>$this->data['record']['id']));
        $this->data['qr_code_details']=!empty($this->data['qr_code_details'])?$this->data['qr_code_details']:array(array());
      }
      if($this->router->method == 'update' || $this->router->method == 'store')
        $this->data['qr_code_details'] = (isset($_POST['qr_code_details'])?
                                                $_POST['qr_code_details']:array(array()));
    }else{
      $this->data['qr_code_details'] = array(array());
    }
  }

  public function _get_view_data() {
    $this->data['type'] = 'multiple';
    $this->data['qr_code_details'] = 
      $this->qr_code_detail_model->get('', array('qr_code_id' => $this->data['record']['id']));
  }

  public function view($id) {
    if (isset($_GET['type']) && $_GET['type'] == 'single') {
      parent::view($id);
    } else {
      $this->data['record'] = $this->model->find('', array('id' => $id));
      $this->_get_view_data();
      $this->load->view('qr_codes/qr_codes/qr_code', $this->data);
    }
    
  }
  public function delete($id) {
    $details = $this->qr_code_detail_model->get('',array('qr_code_id' => $id));
    if (!empty($details)) {
      foreach ($details as $index => $value) {
       $this->qr_code_detail_model->delete($value['id']);
      }
    }
    parent::delete($id);
    redirect('/qr_codes/qr_codes');
  }
  public function _after_save($formdata, $action){
    $this->data['redirect_url']= ADMIN_PATH.'qr_codes/qr_codes';
    return $formdata;
  }
}
