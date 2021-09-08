<?php //$this->load->view('ac_vouchers/ac_vouchers/tabs'); ?> 
<?php
  $file_exist_main_path=@file_exists(APPPATH."modules/".CLIENT_NAME."/views/sales_return_vouchers/tabs.php");
  if($file_exist_main_path) 
    $this->load->view(CLIENT_NAME."/sales_return_vouchers/tabs.php");
  else
    $this->load->view("ac_vouchers/ac_vouchers/tabs.php");
?>
