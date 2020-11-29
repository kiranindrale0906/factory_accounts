<?php 
  $this->load->view('reports/ledgers/report_header', array('header' => 'Account Ledger'));
  $this->load->view('ac_vouchers/ac_vouchers/company_error_message'); 
  $this->load->view('reports/ledgers/account_name_search', array('url' => ADMIN_PATH."reports/account_ledgers/index"));
?>

<?php 
  if (!empty($record['account_id'])) {
    $this->load->view('reports/ledgers/search'); 
    $this->load->view('reports/ledgers/date_wise_ledger', array('report' => 'account ledger')); 
  }
?>