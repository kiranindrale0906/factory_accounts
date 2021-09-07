<?php
  $file_exist_main_path = @file_exists(APPPATH."modules/".CLIENT_NAME."/views/client_rate_cut_receipt_vouchers/form.php");
  if ($file_exist_main_path) 
    $this->load->view(CLIENT_NAME."/client_rate_cut_receipt_vouchers/form.php");
  else
    $this->load->view("ac_vouchers/ac_vouchers/form.php");
?>