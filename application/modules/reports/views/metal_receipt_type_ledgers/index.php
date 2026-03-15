<?php 
  $this->load->view('reports/ledgers/report_header', array('header' => 'Metal Receipt Type Report'));
  $this->load->view('ac_vouchers/ac_vouchers/company_error_message'); 
  $this->load->view('reports/ledgers/search'); 
  $this->load->view('reports/ledgers/date_wise_ledger', array('report' => 'metal receipt type report')); 
?>