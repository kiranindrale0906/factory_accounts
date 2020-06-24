<?php
  if(file_exists(APPPATH."modules/".CLIENT_NAME."/views/metal_receipt_voucher_clients/form.php")) 
    $this->load->view(CLIENT_NAME."/metal_receipt_voucher_clients/form.php");
  else
    $this->load->view("ac_vouchers/ac_vouchers/form.php");
?>
