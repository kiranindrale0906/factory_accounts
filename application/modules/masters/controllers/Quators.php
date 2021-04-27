<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Quators extends BaseController {

    public function __construct() {
        parent::__construct();

    }
    public function index() {
	    if(!empty($_POST)) {
	      $data=$this->model->get('name,name as id', array('name!='=>''));
	       echo json_encode(array('data'    => $data,
                           'status'      => 'success',
                           'open_modal'  => FALSE));die;
	    }

	    parent::index();
	}

}