<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Metal_issue_packing_slips extends BaseController {
	public function __construct() {
		parent::__construct();
		$this->redirect_after_save = 'view';
		$this->load->model(array('transactions/metal_issue_voucher_model','ac_vouchers/voucher_model','argold/packing_slip_model'));
	}
	public function _after_save($formdata, $action) {
		redirect(base_url().'argold/packing_slips/view/'.$formdata['metal_issue_packing_slips']['packing_slip_id']);
	}
}