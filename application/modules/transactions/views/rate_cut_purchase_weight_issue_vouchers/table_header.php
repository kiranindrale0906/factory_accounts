<?php
  $file_exist_main_path=@file_exists(APPPATH."modules/".CLIENT_NAME."/views/rate_cut_purchase_weight_issue_voucher_clients/table_header.php");
  if($file_exist_main_path) 
    $this->load->view(CLIENT_NAME."/rate_cut_purchase_weight_issue_voucher_clients/table_header.php");
  else
    $this->load->view("ac_vouchers/ac_vouchers/table_header.php");
?>