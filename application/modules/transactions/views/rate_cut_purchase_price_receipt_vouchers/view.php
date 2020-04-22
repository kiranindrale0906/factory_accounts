<?php
  $file_exist_main_path=@file_exists(APPPATH."modules/".CLIENT_NAME."/views/rate_cut_purchase_price_receipt_voucher_clients/view.php");
  if($file_exist_main_path) 
    $this->load->view(CLIENT_NAME."/rate_cut_purchase_price_receipt_voucher_clients/view.php");
  else
    $this->load->view("ac_vouchers/ac_vouchers/view.php");
?>