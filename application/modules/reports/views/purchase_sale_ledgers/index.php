<div class="col-md-12">
  <?= getHttpButton('Generate Ledger', base_url().'reports/account_ledgers/create', 'float-right btn-success ml-5'); ?>
</div>
<?php 
  $this->load->view('reports/ledgers/report_header', array('header' => 'Account Ledger'));
  $this->load->view('ac_vouchers/ac_vouchers/company_error_message'); 
  $this->load->view('reports/ledgers/account_name_search', array('url' => ADMIN_PATH."reports/account_ledgers/index"));
?>

<?php 
    $this->load->view('reports/ledgers/search'); 
    $this->load->view('reports/ledgers/date_wise_ledger', array('report' => 'account ledger')); 
?>
