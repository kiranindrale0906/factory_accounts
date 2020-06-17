<?php
  $file_exist_main_path=@file_exists(APPPATH."modules/".CLIENT_NAME."/views/expense_voucher_clients/table_header.php");
  if($file_exist_main_path) 
    $this->load->view(CLIENT_NAME."/expense_voucher_clients/table_header.php");
  else
    $this->load->view("ac_vouchers/ac_vouchers/table_header.php");
?>