<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chitti_hides extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->redirect_after_save = 'view';
  }
  public function update($id) {
    if(isset($_GET['from']) && $_GET['from']=='view') {
      $process = $this->model->find('id', array('id' => $id));
      $hide_obj = new $this->model($process);
      $hide_obj->before_validate();
      $hide_obj->save(true);
      redirect($_SERVER['HTTP_REFERER']);
    } else {
      parent::update($id);
    }
  }
  public function _after_save($formdata, $action){
    $this->data['redirect_url']= $_SERVER['HTTP_REFERER'];
    return $formdata;
  }
}