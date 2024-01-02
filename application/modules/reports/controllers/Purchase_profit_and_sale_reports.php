<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_profit_and_sale_reports extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('argold/chitti_model','masters/account_model','ac_vouchers/voucher_model'));
  }
  public function index() {
    $this->_get_form_data();
    $this->load->render($this->router->class."/index",$this->data);
  }
  public function _get_form_data() {
  	$this->data['is_export']=(!empty($_GET['is_export']) && $_GET['is_export']==1)?1:0;
    $this->data['from_date']=!empty($_GET['from_date'])?$_GET['from_date']:'';
    $this->data['to_date']=!empty($_GET['to_date'])?$_GET['to_date']:'';
    
    $purchase_sales_account_domestic_export_with_vadotar_select = "is_export,
      voucher_date,account_name,
      factory_purity,
      purity,
      voucher_number,
      gold_rate,
      sale_type,
      IFNULL(((ac_vouchers.debit_weight*ac_vouchers.factory_purity)/100), 0) as fine,
      IFNULL(((ac_vouchers.debit_weight*ac_vouchers.purity)/100), 0) as gold_fine,
      IFNULL(((ac_vouchers.purity-ac_vouchers.factory_purity)*ac_vouchers.debit_weight/100), 0) as vadotar,
      IFNULL((ac_vouchers.debit_weight), 0) debit_weight";
      $where=array('voucher_type'=>"metal receipt voucher",'gold_rate!='=>0,'receipt_type in ("Metal","Refresh")'=>NULL,'ac_account.sub_group_code in ("Domestic","Customer")'=>NULL);
    if(!empty($this->data['from_date'])){
      $where['date(voucher_date) >=']=date('Y-m-d', strtotime($this->data['from_date']));
    }

    if(!empty($this->data['to_date'])){
      $where['date(voucher_date) <=']=date('Y-m-d', strtotime($this->data['to_date']));
    }

    $profit_loss_with_vadotar_records = $this->model->get($purchase_sales_account_domestic_export_with_vadotar_select,$where,array(array('ac_account','ac_vouchers.account_name=ac_account.name')));
    $profit_loss_with_vadotar_domestic_sale_vadotar_fine=$profit_loss_with_vadotar_domestic_sale_vadotar_amount=$profit_loss_with_vadotar_domestic_rate=0;
    foreach ($profit_loss_with_vadotar_records as $profit_loss_with_vadotar_index => $profit_loss_with_vadotar_value) {
      $profit_loss_with_vadotar_records[$profit_loss_with_vadotar_index]['sale_type']=$profit_loss_with_vadotar_value['sale_type'];
      if($profit_loss_with_vadotar_records[$profit_loss_with_vadotar_index]['sale_type']=="Labour"){
        $profit_loss_with_vadotar_records[$profit_loss_with_vadotar_index]['gold_fine']=0;
      }
      $profit_loss_with_vadotar_records[$profit_loss_with_vadotar_index]['gold_amount']=$profit_loss_with_vadotar_value['gold_fine']*$profit_loss_with_vadotar_records[$profit_loss_with_vadotar_index]['gold_fine'];
      $profit_loss_with_vadotar_records[$profit_loss_with_vadotar_index]['gold_rate']=!empty($profit_loss_with_vadotar_records[$profit_loss_with_vadotar_index]['gold_rate'])?$profit_loss_with_vadotar_records[$profit_loss_with_vadotar_index]['gold_rate']:0;

      $profit_loss_with_vadotar_records[$profit_loss_with_vadotar_index]['vadotar_fine']=$profit_loss_with_vadotar_value['vadotar'];

      $profit_loss_with_vadotar_records[$profit_loss_with_vadotar_index]['vadotar_amount']=$profit_loss_with_vadotar_value['vadotar']*$profit_loss_with_vadotar_value['gold_rate'];

      $profit_loss_with_vadotar_records[$profit_loss_with_vadotar_index]['vadotar_rate']=($profit_loss_with_vadotar_value['gold_rate']>0)?($profit_loss_with_vadotar_value['gold_rate']):0;
    }
    $this->data['profit_and_sale_records']=$profit_loss_with_vadotar_records;
  }
}
