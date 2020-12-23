<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram_production_summary extends BaseController {
  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $date = date('Y-m-d');
    //$url  = API_ARG_BASE_PATH."issue_departments/api_issue_departments/index?issue_at=".$date;
    $url  = "https://nov2020-argold.ascratech.com/issue_departments/api_issue_departments/index?issue_at=".$date;
    $argold_records = json_decode(curl_post_request($url));
    $bot = new \TelegramBot\Api\BotApi('1387671982:AAGd_ke_dJoiZ_tkThtUlCrPUBTo2oNfjdc');
    //$bot->sendMessage('1316386536', 'abcd');

    
    foreach($argold_records as $argold_record) {
      $bot->sendMessage('1316386536', $argold_record['product_name'].': '.$argold_record['issue_gpc_out']);      
    }
    $url  = API_ARF_BASE_PATH."issue_departments/api_issue_departments/index?issue_at=".$date;

    $url  = API_ARC_BASE_PATH."issue_departments/api_issue_departments/index?issue_at=".$date;
  }
}
