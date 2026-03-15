<?php 
  $this->load->view('reports/ledgers/report_header', array('header' => 'Gross Profit Report (Ledger)'));
  $this->load->view('ac_vouchers/ac_vouchers/company_error_message'); 

  $this->load->view('reports/ledgers/search'); 

  $this->load->view('reports/ledgers/date_wise_ledger'); 
  $this->load->view('reports/gross_profit_reports/company_gross_profits'); 
?>

