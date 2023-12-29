<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 require_once APPPATH . "modules/argold/models/Chitti_model.php";  
  class Chitti_erp_model extends Chitti_model {
    public $router_class = "chitti_erps";
    
    function __construct($data=array()) {
      parent::__construct($data);
      $this->load->model(array('ac_vouchers/voucher_model'));
    } 

    public function after_save($action) {
      $this->set_chitti_id_in_metal_issue_vouchers();
      $metal_issue_vouchers = $this->voucher_model->find('sum(rate * credit_weight) as amount', array('chitti_id' => $this->attributes['id']));
      $this->load->model(array('transactions/cash_issue_voucher_model'));
      $this->cash_issue_voucher_model->create_cash_vouchers_for_chitti($this->attributes['id'], $metal_issue_vouchers['amount']);
    }
    public function set_chitti_id_in_metal_issue_vouchers() {
    $chittis=array();

    if (!empty($this->formdata['chitti_details'])) {
      $chitti_ids=array_column($this->formdata['chitti_details'], 'chitti_id');
      $chitti_id_details=array();
      foreach ($chitti_ids as $index => $chitti_id) {
        $chittis=explode('_', $chitti_id);
        $chitti_id_details[$index]['packet_no']=$chittis[0];
        $chitti_id_details[$index]['erp_argold_id']=$chittis[1];
      }
      $packet_nos=array_column($chitti_id_details, 'packet_no');
      $argold_ids=array_column($chitti_id_details, 'erp_argold_id');

      $chitti_details = $this->voucher_model->get('', array('site_name' => $this->attributes['site_name'],
                                                            'packet_no' => $packet_nos,
                                                            'erp_argold_id' => $argold_ids,
                                                            'account_name' => $this->attributes['account_name'],
                                                            'purity' => $this->attributes['purity']));

    } else 
      $chitti_details = $this->voucher_model->get('', array('chitti_id' => $this->attributes['id']));
    pd($chitti_details);
    
    foreach ($chitti_details as $index => $chitti_detail) {
      if (isset($chitti_detail['id'])) {
        $voucher_obj = new voucher_model($chitti_detail);
        $voucher_obj->attributes['chitti_id'] = $this->attributes['id'];
        $voucher_obj->attributes['voucher_date'] = $this->attributes['date'];
        $voucher_obj->update(false);
      }
    }
  }

  }
