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
    if(!empty($_GET['type'])){
      $this->data['type']=$_GET['type'];
    }else{
      $this->data['type']='Sales';
    }
    if(!empty($_GET['sale_type'])){
      $where['sale_type']=$_GET['sale_type'];
      $this->data['sale_type']=$_GET['sale_type'];
    }else{
      $where['sale_type']='Labour';
      $this->data['sale_type']='Labour';
    }
    $sales_records = $this->chitti_model->get('',$where);
    $purchase_records = $this->voucher_model->get('', array('gold_rate !=' => 0), array(),array('order_by'=>'voucher_date'));
    foreach ($sales_records as $sale_index => $sale_value) {
      $wastage=$wastage_fine=$factory_fine=$rate_of_gst=$vadotar=$gold_sale=$vadotar_sale=0;
      $year=date("Y-m-d",strtotime($sale_value['created_at']));
      $this->data['sales_records'][$year][$sale_index]['date_sale']=$sale_value['created_at'];
      $this->data['sales_records'][$year][$sale_index]['customer_name']=$sale_value['account_name'];
      $this->data['sales_records'][$year][$sale_index]['sale_type']=$sale_value['sale_type'];
      $this->data['sales_records'][$year][$sale_index]['weight']=$sale_value['weight'];
      $this->data['sales_records'][$year][$sale_index]['purity']=$sale_value['purity'];
      $this->data['sales_records'][$year][$sale_index]['factory_fine']=$factory_fine=($sale_value['weight']*$sale_value['purity'])/100;
      $this->data['sales_records'][$year][$sale_index]['wastage']=$wastage=!empty($factory_fine)?(($wastage_fine/$factory_fine)*100):0;
      $this->data['sales_records'][$year][$sale_index]['wastage_fine']=$wastage_fine=($sale_value['factory_fine']);
      $this->data['sales_records'][$year][$sale_index]['rate']=$sale_value['rate'];
      $this->data['sales_records'][$year][$sale_index]['rate_of_gst']=$rate_of_gst=($sale_value['rate']+($sale_value['rate']*5)/100);
      $this->data['sales_records'][$year][$sale_index]['vadotar']=$vadotar=($wastage_fine-$factory_fine);
      $this->data['sales_records'][$year][$sale_index]['amount']=$amount=($rate_of_gst*$vadotar);
      $this->data['sales_records'][$year][$sale_index]['gold_sale']=$gold_sale=($rate_of_gst*$factory_fine);
      $this->data['sales_records'][$year][$sale_index]['vadotar_sale']=$vadotar_sale=($rate_of_gst*$vadotar);
      $this->data['sales_records'][$year][$sale_index]['total_sale']=$total_sale=$vadotar_sale+$gold_sale;
      $this->data['sales_records'][$year][$sale_index]['sub_total_sale']=(($total_sale/103)*100);
    }
    foreach ($purchase_records as $purchase_index => $purchase_value) {
      $wastage=$wastage_fine=$factory_fine=$rate_of_gst=$vadotar=0;
      $year=date("Y-m-d",strtotime($purchase_value['created_at']));
      $this->data['purchase_records'][$year][$purchase_index]['date_sale']=date("Y-m-d",strtotime($purchase_value['created_at']));
      $this->data['purchase_records'][$year][$purchase_index]['customer_name']=$purchase_value['account_name'];
      $this->data['purchase_records'][$year][$purchase_index]['sale_type']=$purchase_value['sale_type'];
      $this->data['purchase_records'][$year][$purchase_index]['weight']=$purchase_value['credit_weight'];
      $this->data['purchase_records'][$year][$purchase_index]['purity']=$purchase_value['purity'];
      $this->data['purchase_records'][$year][$purchase_index]['factory_fine']=$factory_fine=$purchase_value['factory_fine'];
      $this->data['purchase_records'][$year][$purchase_index]['wastage']=$wastage=$purchase_value['factory_fine']-$purchase_value['factory_fine'];
      $this->data['purchase_records'][$year][$purchase_index]['wastage_fine']=$wastage_fine=($wastage*$purchase_value['purity']/100);
      $this->data['purchase_records'][$year][$purchase_index]['rate']=$purchase_value['rate'];
      $this->data['purchase_records'][$year][$purchase_index]['rate_of_gst']=$rate_of_gst=($purchase_value['rate']+($purchase_value['rate']*5)/100);
      $this->data['purchase_records'][$year][$purchase_index]['vadotar']=$vadotar=($wastage_fine-$factory_fine);
      $this->data['purchase_records'][$year][$purchase_index]['amount']=($rate_of_gst*$vadotar);
      $this->data['purchase_records'][$year][$purchase_index]['gold_sale']=$gold_sale=($rate_of_gst*$factory_fine);
      $this->data['purchase_records'][$year][$purchase_index]['vadotar_sale']=$vadotar_sale=($rate_of_gst*$vadotar);
      $this->data['purchase_records'][$year][$purchase_index]['total_sale']=$total_sale=$vadotar_sale+$gold_sale;
      $this->data['purchase_records'][$year][$purchase_index]['sub_total_sale']=(($total_sale/103)*100);
   
  
    }
    if(!empty($_GET['type'])&&$_GET['type']=="Purchase"){
      $this->data['sales_records']=$this->data['purchase_records'];
    }
  
  }
}
