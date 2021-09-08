<?php
  $file_exist_main_path=@file_exists(APPPATH."modules/".CLIENT_NAME."/views/interest_issue_voucher_clients/form.php");
  if($file_exist_main_path) 
    $this->load->view(CLIENT_NAME."/interest_issue_voucher_clients/form.php");
  else
    $this->load->view("ac_vouchers/ac_vouchers/form.php");
?>