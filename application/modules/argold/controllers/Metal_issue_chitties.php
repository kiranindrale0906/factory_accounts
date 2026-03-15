<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Metal_issue_chitties extends BaseController {
	public function __construct() {
		parent::__construct();
		$this->redirect_after_save = 'view';
		$this->load->model(array('transactions/metal_issue_voucher_model','ac_vouchers/voucher_model','argold/chitti_model'));
	}
	public function edit($id) {
		$this->data['record']['id']=$id;
		parent::edit($id);
	}
	public function _get_form_data() {
		// $this->data['record']['id']=isset($_GET['chitti_id'])?$_GET['chitti_id']:0;
		if(!empty($this->data['record']['id'])){
			$chitti_details=$this->chitti_model->find('',array('id'=>$this->data['record']['id']));
	   	$where=array('voucher_type' => 'metal issue voucher',
	                'chitti_id' => '',
	                'purity'=>$chitti_details['purity'],
	                'account_name'=>$chitti_details['account_name'],
	                 );
	    $this->data['metal_vouchers'] = $this->voucher_model->get('id,credit_weight as credit_weight,
	                         ((credit_weight*purity) / (credit_weight)) as purity,
	                         ((credit_weight*factory_purity) / (credit_weight)) as factory_purity,
	                         "" as voucher_number,packet_no,voucher_date,(narration) as narration, argold_id as argold_id,site_name', 
	                         $where);
		}
	}
	public function _after_save($formdata, $action) {
		redirect(base_url().'/argold/chittis/view/'.$formdata['metal_issue_chitties']['id']);
	}
}