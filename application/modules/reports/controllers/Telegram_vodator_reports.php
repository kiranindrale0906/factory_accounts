<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram_vodator_reports extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('ac_vouchers/voucher_model'));

    $this->bot = new \TelegramBot\Api\BotApi('7199566349:AAF-0evNjld0Jl6OhaGeuVamGY4g-yNDc6k');
  }

  public function index() {
    $date = date('Y-m-d');
    $this->send_message($date);
    $this->send_vadotar_records($date);
  }
  private function send_vadotar_records($date) {
    $vadotars = $this->voucher_model->get('date(voucher_date) voucher_date, sum(factory_fine - fine) as vadotar',array('date(voucher_date)' => $date));
    pd($vadotars); 
    $this->send_message($company_vadotars);      
  }
  //send telegram message
  private function send_message($message) {
    //Atul: 712491427
    //Bhaskar: 1316386536
    //Nikhil Ranawat: 1056863449
    //Bheru Sankhla: 1699299372

    $this->bot->sendMessage('1855495238', $message);  
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
