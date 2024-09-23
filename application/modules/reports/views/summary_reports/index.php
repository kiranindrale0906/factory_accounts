<?php 

  $this->load->view('reports/ledgers/report_header', array('header' => 'Summary Report (Ledger)'));
  if (isset($trial_balance))
    $this->load->view('summary_reports/trial_balance', array('trial_balance_records' => $trial_balance, 'loss_account' => 0));

  $this->load->view('ac_vouchers/ac_vouchers/company_error_message'); 

  $this->load->view('reports/ledgers/search'); 

  $this->load->view('reports/ledgers/date_wise_ledger'); 
  $this->load->view('reports/vadotar_reports/company_vadotars'); 
?>

