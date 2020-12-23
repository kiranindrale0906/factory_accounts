<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram_production_summary extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('ac_vouchers/voucher_model'));
  }

  public function index() {
    $bot = new \TelegramBot\Api\BotApi('1387671982:AAGd_ke_dJoiZ_tkThtUlCrPUBTo2oNfjdc');
    $date = date('Y-m-d');
    $bot->sendMessage('712491427', date('d-m-Y'));

    $url  = API_ARG_BASE_PATH."issue_departments/api_issue_departments/index?issue_at=".$date;
    $argold_records = json_decode(curl_post_request($url));
    $this->send_issue_gpc_out_message($bot, $argold_records->data);
    
    $url  = API_ARF_BASE_PATH."issue_departments/api_issue_departments/index?issue_at=".$date;
    $arf_records = json_decode(curl_post_request($url));
    $this->send_issue_gpc_out_message($bot, $arf_records->data);
    
    $url  = API_ARC_BASE_PATH."issue_departments/api_issue_departments/index?issue_at=".$date;
    $arc_records = json_decode(curl_post_request($url));
    $this->send_issue_gpc_out_message($bot, $arc_records->data);
    
    $metal_receipts = $this->voucher_model->find('sum(debit_weight) as weight', array('receipt_type' => 'Metal',
                                                                                      'voucher_date' => $date));
    $metal_weight = (isset($metal_receipts)) ? $metal_receipts['weight'] : 0;
    $this->send_message($bot, 'Metal: '.$metal_weight);      

    $refresh_records = $this->voucher_model->get('receipt_type, sum(debit_weight) as weight',
                                           array('receipt_type' => array('AR Gold Refresh', 'ARF Refersh', 'ARC Refresh'),
                                                 'voucher_date' => $date), array(), array('group_by' => 'receipt_type'));
    $this->send_refresh_message($bot, $refresh_records);      
  }

  private function send_issue_gpc_out_message($bot, $records) {
    foreach($records as $record) {
      $message = $record->product_name.': '.four_decimal($record->issue_gpc_out);
      $this->send_message($bot, $message);
    }
  } 

  private function send_refresh_message($bot, $records) {
    foreach($records as $record) {
      $message = $record['receipt_type'].': '.four_decimal($record['weight']);
      $this->send_message($bot, $message);
    }
  } 

  private function send_message($bot, $message) {
    //Atul: 712491427
    //Bhaskar: 1316386536
    //Nikhil Ranawat: 1056863449

    $bot->sendMessage('712491427', $message);      
    //$bot->sendMessage('1056863449', $message);
  }
}
