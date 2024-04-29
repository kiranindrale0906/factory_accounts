<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Average_reports extends BaseController {  
  public function __construct(){
    parent::__construct();
    $this->load->model(array('reports/sales_register_model',
                             'ac_vouchers/voucher_model',
                             'argold/chitti_model'));
  } 

  public function index() { 
    $this->calculation_data();
    $this->load->render('reports/average_reports/index',$this->data); 
  } 

  private function calculation_data() {
    $this->data['sales_records']=array();
    $this->data['purchase_records']=array();
    $where['rate!=']=0;
    if(!empty($_GET['sale_type'])){
      $where['sale_type']=$_GET['sale_type'];
    }
    $sales_records = $this->chitti_model->get('',$where);
    $purchase_records = $this->voucher_model->get('', array('gold_rate !=' => 0), array(),array('order_by'=>'voucher_date'));
    foreach ($sales_records as $sale_index => $sale_value) {
      $wastage=$wastage_fine=$factory_fine=$rate_of_gst=$vadotar=$gold_sale=$vadotar_sale=0;
      $year=date("Y-m-d",strtotime($sale_value['created_at']));
      $this->data['sales_records'][$year][$index]['date_sale']=$sale_value['created_at'];
      $this->data['sales_records'][$year][$index]['customer_name']=$sale_value['account_name'];
      $this->data['sales_records'][$year][$index]['sale_type']=$sale_value['sale_type'];
      $this->data['sales_records'][$year][$index]['weight']=$sale_value['weight'];
      $this->data['sales_records'][$year][$index]['purity']=$sale_value['purity'];
      $this->data['sales_records'][$year][$index]['factory_fine']=$factory_fine=($sale_value['weight']*$sale_value['purity'])/100;
      $this->data['sales_records'][$year][$index]['wastage']=$wastage=($wastage_fine/$factory_fine)*100;
      $this->data['sales_records'][$year][$index]['wastage_fine']=$wastage_fine=($sale_value['factory_fine']);
      $this->data['sales_records'][$year][$index]['rate']=$sale_value['rate'];
      $this->data['sales_records'][$year][$index]['rate_of_gst']=$rate_of_gst=($sale_value['rate']+($sale_value['rate']*5)/100);
      $this->data['sales_records'][$year][$index]['vadotar']=$vadotar=($wastage_fine-$factory_fine);
      $this->data['sales_records'][$year][$index]['amount']=$amount=($rate_of_gst*$vadotar);
      $this->data['sales_records'][$year][$index]['gold_sale']=$gold_sale=($rate_of_gst*$factory_fine);
      $this->data['sales_records'][$year][$index]['vadotar_sale']=$vadotar_sale=($rate_of_gst*$vadotar);
      $this->data['sales_records'][$year][$index]['total_sale']=$total_sale=$vadotar_sale+$gold_sale;
      $this->data['sales_records'][$year][$index]['sub_total_sale']=(($total_sale/103)*100);
    }
    foreach ($purchase_records as $purchase_index => $purchase_value) {
      $wastage=$wastage_fine=$factory_fine=$rate_of_gst=$vadotar=0;
      $year=date("Y-m-d",strtotime($purchase_value['created_at']));
      $this->data['purchase_records'][$year][$index]['date_purchase']=date("Y-m-d",strtotime($purchase_value['created_at']));
      $this->data['purchase_records'][$year][$index]['customer_name']=$purchase_value['account_name'];
      $this->data['purchase_records'][$year][$index]['sale_type']=$purchase_value['sale_type'];
      $this->data['purchase_records'][$year][$index]['weight']=$purchase_value['weight'];
      $this->data['purchase_records'][$year][$index]['purity']=$purchase_value['purity'];
      $this->data['purchase_records'][$year][$index]['factory_fine']=$factory_fine=$purchase_value['factory_fine'];
      $this->data['purchase_records'][$year][$index]['wastage']=$wastage=$purchase_value['factory_fine']-$purchase_value['factory_fine'];
      $this->data['purchase_records'][$year][$index]['wastage_fine']=$wastage_fine=($wastage*$purchase_value['purity']/100);
      $this->data['purchase_records'][$year][$index]['rate']=$purchase_value['rate'];
      $this->data['purchase_records'][$year][$index]['rate_of_gst']=$rate_of_gst=($purchase_value['rate']+($purchase_value['rate']*5)/100);
      $this->data['purchase_records'][$year][$index]['vadotar']=$vadotar=($wastage_fine-$factory_fine);
      $this->data['purchase_records'][$year][$index]['amount']=($rate_of_gst*$vadotar);
  
    }
  
  }
}
