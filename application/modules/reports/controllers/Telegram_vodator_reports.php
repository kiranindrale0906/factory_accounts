<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram_vodator_reports extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('ac_vouchers/voucher_model','masters/account_model'));

//    $this->bot = new \TelegramBot\Api\BotApi('7199566349:AAF-0evNjld0Jl6OhaGeuVamGY4g-yNDc6k');
    $this->bot = new \TelegramBot\Api\BotApi('7065258347:AAF6w4PPJ452pZQC8m05X6yFglkWwARUnTY');
  }

  public function index() {
//    $date = date('2024-08-12');
    $date = date('Y-m-d');
//    $this->send_vadotar_records('AR Gold (Apr 2024)',$date);
    $this->send_vadotar_records('AR Gold ERP',$date);
    $this->send_vadotar_records('ARF ERP',$date);
    $this->send_vadotar_records('ARC ERP',$date);
    $this->send_vadotar_records('Domestic Internal ERP',$date);
    $this->send_vadotar_records('ARNA BANGLE ERP',$date);
    $this->send_vadotar_records('RND ERP',$date);
    $this->send_vadotar_records('ARF (Apr 2024)',$date);
    $this->send_vadotar_records('ARF (Aug 2024)',$date);
    $this->send_vadotar_records('ARC (Apr 2024)',$date);
    $this->send_vadotar_records('Export',$date);
    $this->send_vadotar_records('Domestic',$date);
  }
  private function send_vadotar_records($site_name,$date) {
   $export_accounts = $this->account_model->get('name', array('group_code in ("Export")' => NULL ));
   $export_account_names = array_column($export_accounts, 'name');
   $export_account_names[] = 'Tanishq';
   $export_account_names[] = 'Domestic Internal Software';
   $export_account_names = implode('", "',$export_account_names);
    $where['date(voucher_date)']=$date;
    $where['site_name']=$site_name;
     $where['(   purity != factory_purity 
                 or (    (receipt_type = "Domestic Internal" or receipt_type = "Export Internal")
                     and voucher_type = "metal receipt voucher")
		 or ( receipt_type="Refresh"
                     and voucher_type = "metal receipt voucher")
                 or (    account_name in ("'.$export_account_names.'") 
                     and voucher_type = "metal issue voucher")
              ) AND receipt_type != "Packing Slip"'] = NULL;

    $vadotars = $this->voucher_model->find('site_name,date(voucher_date) voucher_date, sum(factory_fine - fine) as vadotar,sum(credit_weight-debit_weight) as gross_weight',$where,array());
//pd($vadotars);
   if(!empty($vadotars)){
    $this->send_company_vadotar_message($vadotars);      
   }
 }
  private function send_company_vadotar_message($record) {
      $message ='date:'.$record['voucher_date'].',site_name:'.$record['site_name'].',vadotar:'.$record['vadotar'].',gw:'.$record['gross_weight'];
      $this->send_message($message);
  } 

  //send telegram message
  private function send_message($message) {
    //Atul: 712491427
    //Bhaskar: 1316386536
    //Nikhil Ranawat: 1056863449
    //Bheru Sankhla: 1699299372

    $this->bot->sendMessage('7022948019', $message);  
//   $this->bot->sendMessage('1855495238', $message);  
   /* pd($message);
    $text="Hello kiran";
    $chat_id="1855495238";
    $token="7199566349:AAF-0evNjld0Jl6OhaGeuVamGY4g-yNDc6k";
    $url="https://api.telegram.org/bot$token/sendMessage?text=$text&chat_id=$chat_id";
    $curl = curl_init();
      curl_setopt($curl,CURLOPT_URL,$url);
      curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
      $response = curl_exec($curl);
      curl_close($curl);
      $result=json_decode($response,true);
      pd($result);
    return $response;
  */}
}
