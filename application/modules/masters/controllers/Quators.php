<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Quators extends BaseController {

    public function __construct() {
        parent::__construct();

    }
    public function index() {
    	pd($_POST);
	    if(!empty($_POST['get_quators'])) {
	      $data=$this->model->get('name,name as id', array('name!='=>''));
	      echo json_encode(array('data'=>$data,'status'=>'success')); die;
	    }

	    parent::index();
	}

}