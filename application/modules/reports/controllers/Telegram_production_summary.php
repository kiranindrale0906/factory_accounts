<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram_production_summary extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('ac_vouchers/voucher_model'));

    $this->bot = new \TelegramBot\Api\BotApi('1387671982:AAGd_ke_dJoiZ_tkThtUlCrPUBTo2oNfjdc');
  }

  public function index() {
    $date = date('Y-m-d');
    $this->send_message($date);

    $this->send_issue_gpc_out_records($date);
    $this->send_metal_receipt_record($date);
    $this->send_refresh_records($date);
  }

  //get issue department records
  private function send_issue_gpc_out_records($date) {
    $url  = API_ARG_PATH."issue_departments/api_issue_departments/index?issue_at=".$date;
    $argold_records = json_decode(curl_post_request($url));
    $this->send_issue_gpc_out_message($argold_records->data);
    
    $url  = API_ARF_PATH."issue_departments/api_issue_departments/index?issue_at=".$date;
    $arf_records = json_decode(curl_post_request($url));
    $this->send_issue_gpc_out_message($arf_records->data);
    
    $url  = API_ARC_PATH."issue_departments/api_issue_departments/index?issue_at=".$date;
    $arc_records = json_decode(curl_post_request($url));
    $this->send_issue_gpc_out_message($arc_records->data);
  }

  //get refresh receipt records
  private function send_refresh_records($date) {
    $refresh_records = $this->voucher_model->get('receipt_type, sum(debit_weight) as weight',
                                           array('receipt_type' => array('AR Gold Refresh', 'ARF Refresh', 'ARC Refresh'),
                                                 'voucher_date' => $date), array(), array('group_by' => 'receipt_type'));
    $this->send_refresh_message($refresh_records);      
  }

  //get metal receipt record
  private function send_metal_receipt_record($date) {
    $metal_receipts = $this->voucher_model->find('sum(debit_weight) as weight', array('receipt_type' => 'Metal',
                                                                                      'voucher_date' => $date));
    $metal_weight = (isset($metal_receipts)) ? $metal_receipts['weight'] : 0;
    $this->send_message('Metal: '.$metal_weight);      
  }

  //send issue out message
  private function send_issue_gpc_out_message($records) {
    foreach($records as $record) {
      $message = $record->product_name.': '.four_decimal($record->issue_gpc_out);
      $this->send_message($message);
    }
  } 

  //send refresh message
  private function send_refresh_message($records) {
    foreach($records as $record) {
      $message = $record['receipt_type'].': '.four_decimal($record['weight']);
      $this->send_message($message);
    }
  } 

  //send telegram message
  private function send_message($message) {
    //Atul: 712491427
    //Bhaskar: 1316386536
    //Nikhil Ranawat: 1056863449
    //Bheru Sankhla: 1699299372

    $this->bot->sendMessage('712491427', $message);      
    $this->bot->sendMessage('1056863449', $message);
    $this->bot->sendMessage('1699299372', $message);
  }
}
