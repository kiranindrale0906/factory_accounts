<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram_vadator_report extends BaseController {
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
    $company_vadotars = $this->model->get('date(voucher_date) voucher_date, sum(factory_fine - fine) as vadotar',array('date(voucher_date)' => $date), array(), array('group_by' => 'date(voucher_date)'));
    $this->send_vadotar_message($refresh_records);      
  }
  //send telegram message
  private function send_message($message) {
    //Atul: 712491427
    //Bhaskar: 1316386536
    //Nikhil Ranawat: 1056863449
    //Bheru Sankhla: 1699299372

    $this->bot->sendMessage('712491427', $message);  
  }
}
