<?php
  $file_exist_main_path=@file_exists(APPPATH."modules/".CLIENT_NAME."/views/journal_voucher_clients/tabs.php");
  if($file_exist_main_path) 
    $this->load->view(CLIENT_NAME."/journal_voucher_clients/tabs.php");
  else
    $this->load->view("ac_vouchers/ac_vouchers/tabs.php");
?>