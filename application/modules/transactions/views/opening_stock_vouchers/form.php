<?php
  if(file_exists(APPPATH."modules/".CLIENT_NAME."/views/client_opening_stock_vouchers/form.php")) 
    $this->load->view(CLIENT_NAME."/client_opening_stock_vouchers/form.php");
  else
    $this->load->view("ac_vouchers/ac_vouchers/form.php");
?>
