<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chitti_empty_packet_details extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->redirect_after_save = 'view';
     $this->load->model(array('masters/empty_packet_model'));
 
  }
  public function _get_form_data() {
    $this->data['empty_packet_weights'] = $this->empty_packet_model->get('distinct(weight) as name,weight as  id', array('weight >'=>0) ,array(), array('order_by'=>'id asc'));
    $this->data['empty_packet_quantities'] = $this->empty_packet_model->get('distinct(qty) as name,qty as  id', array('qty >'=>0) ,array(), array('order_by'=>'id asc'));
    $this->data['chitti_id'] = !empty($_GET['chitti_id'])?$_GET['chitti_id']:0;
  }
}