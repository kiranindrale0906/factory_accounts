<div class="boxrow"><div class="float-left bold">
Generate Ledger:
  <?//= getHttpButton('(4 to 5 month 2022)', base_url().'reports/account_ledgers/create?limit_date=1', 'float-right btn-success ml-5'); ?>
  <?//= getHttpButton('Generate Ledger (5 to 6 month 2022)', base_url().'reports/account_ledgers/create?limit_date=2', 'float-right btn-success ml-5'); ?>
  <?//= getHttpButton('Generate Ledger (6 to 7 2022)', base_url().'reports/account_ledgers/create?limit_date=3', 'float-right btn-success ml-5'); ?>
  <?//= getHttpButton('Generate Ledger (7 to 8 2022)', base_url().'reports/account_ledgers/create?limit_date=4', 'float-right btn-success ml-5'); ?>
  <?//= getHttpButton('Generate Ledger (9 to 12 2022)', base_url().'reports/account_ledgers/create?limit_date=5', 'float-right btn-success ml-5'); ?>

  <?= getHttpButton('(1 to 3 month 2024)', base_url().'reports/account_ledgers/create?limit_date=6', 'float-right btn-success ml-5'); ?>
  <?= getHttpButton('(4 to 7 month 2024)', base_url().'reports/account_ledgers/create?limit_date=7', 'float-right btn-success ml-5'); ?>
  <?= getHttpButton('(8 to 12 month 2024)', base_url().'reports/account_ledgers/create?limit_date=8', 'float-right btn-success ml-5'); ?>
  <?= getHttpButton('(from current month 2025)', base_url().'reports/account_ledgers/create?limit_date=10', 'float-right btn-success ml-5'); ?>
</div></div>
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
