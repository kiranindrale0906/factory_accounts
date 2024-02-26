<div class="col-md-12">

  <?//= getHttpButton('Generate Ledger (4 to 5 month 2022)', base_url().'reports/purchase_labour_ledgers/create?limit_date=1', 'float-right btn-success ml-5'); ?>
  <?//= getHttpButton('Generate Ledger (5 to 6 month 2022)', base_url().'reports/purchase_labour_ledgers/create?limit_date=2', 'float-right btn-success ml-5'); ?>
  <?//= getHttpButton('Generate Ledger (6 to 7 2022)', base_url().'reports/purchase_labour_ledgers/create?limit_date=3', 'float-right btn-success ml-5'); ?>
  <?//= getHttpButton('Generate Ledger (7 to 8 2022)', base_url().'reports/purchase_labour_ledgers/create?limit_date=4', 'float-right btn-success ml-5'); ?>
  <?//= getHttpButton('Generate Ledger (9 to 12 2022)', base_url().'reports/purchase_labour_ledgers/create?limit_date=5', 'float-right btn-success ml-5'); ?>

  <?= getHttpButton('Generate Ledger (1 to 3 month 2023)', base_url().'reports/purchase_labour_ledgers/create?limit_date=6', 'float-right btn-success ml-5'); ?>
  <?= getHttpButton('Generate Ledger (4 to 7 month 2023)', base_url().'reports/purchase_labour_ledgers/create?limit_date=7', 'float-right btn-success ml-5'); ?>
  <?= getHttpButton('Generate Ledger (8 to 12 month 2023)', base_url().'reports/purchase_labour_ledgers/create?limit_date=8', 'float-right btn-success ml-5'); ?>
  <?= getHttpButton('Generate Ledger (from current month)', base_url().'reports/purchase_labour_ledgers/create?limit_date=9', 'float-right btn-success ml-5'); ?>
</div>
<?php 
  $this->load->view('reports/ledgers/report_header', array('header' => 'Purchase Labour Ledger'));
  $this->load->view('ac_vouchers/ac_vouchers/company_error_message'); 
  $this->load->view('reports/ledgers/account_name_search', array('url' => ADMIN_PATH."reports/purchase_labour_ledgers/index"));
?>

<?php 
  if (!empty($record['account_id'])) {
    $this->load->view('reports/ledgers/search'); 
    $this->load->view('reports/ledgers/date_wise_ledger', array('report' => 'account ledger')); 
  }
?>