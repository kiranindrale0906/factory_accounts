<div class="col-md-12">
  <?php if(!empty($_GET['limit_date']) && $_GET['limit_date']==1)?>
  <?= getHttpButton('Generate Ledger (4 to 6 month)', base_url().'reports/account_ledgers/create?limit_date=1', 'float-right btn-success ml-5'); ?>
  <?= getHttpButton('Generate Ledger (6 to 9 month)', base_url().'reports/account_ledgers/create?limit_date=2', 'float-right btn-success ml-5'); ?>
  <?= getHttpButton('Generate Ledger (9 to current month)', base_url().'reports/account_ledgers/create?limit_date=3', 'float-right btn-success ml-5'); ?>
</div>
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