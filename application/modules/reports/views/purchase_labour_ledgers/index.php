
<?php 
  $this->load->view('reports/ledgers/report_header', array('header' => 'Purchase Labour Ledger'));
  $this->load->view('ac_vouchers/ac_vouchers/company_error_message'); 
 /* $this->load->view('reports/ledgers/account_name_search', array('url' => ADMIN_PATH."reports/purchase_labour_ledgers/index"));*/
?>

<?php 
    $this->load->view('reports/ledgers/search'); 
    $this->load->view('reports/ledgers/date_wise_ledger', array('report' => 'purchase labour ledger')); 
?>