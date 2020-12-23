<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram_production_summary extends BaseController {
  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $bot = new \TelegramBot\Api\BotApi('1387671982:AAGd_ke_dJoiZ_tkThtUlCrPUBTo2oNfjdc');

    $date = date('Y-m-d');
    $url  = API_ARG_BASE_PATH."issue_departments/api_issue_departments/index?issue_at=".$date;
    $argold_records = json_decode(curl_post_request($url));
    $this->send_issue_gpc_out_message($argold_records->data);
    
    $url  = API_ARF_BASE_PATH."issue_departments/api_issue_departments/index?issue_at=".$date;
    $arf_records = json_decode(curl_post_request($url));
    $this->send_issue_gpc_out_message($arf_records->data);
    
    $url  = API_ARC_BASE_PATH."issue_departments/api_issue_departments/index?issue_at=".$date;
    $arc_records = json_decode(curl_post_request($url));
    $this->send_issue_gpc_out_message($arc_records->data);
    
  }

  private function send_issue_gpc_out_message($records) {
    foreach($records->data as $record) {
      $message = $record->product_name.': '.four_decimal($record->issue_gpc_out);

      //Atul: 712491427
      //Bhaskar: 1316386536
      //Nikhil Ranawat: 1056863449
      $bot->sendMessage('712491427', $message);      
    }
  } 
}
