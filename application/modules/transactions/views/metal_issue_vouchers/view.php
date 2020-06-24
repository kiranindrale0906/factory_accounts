<?php //$this->load->view('ac_vouchers/ac_vouchers/view'); ?>
<?php
  $file_exist_main_path=@file_exists(APPPATH."modules/".CLIENT_NAME."/views/metal_issue_voucher_clients/view.php");
  if($file_exist_main_path) 
    $this->load->view(CLIENT_NAME."/metal_issue_voucher_clients/view.php");
  else
    $this->load->view("ac_vouchers/ac_vouchers/view.php");
?>
