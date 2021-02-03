<?php 
  $profit_and_loss = array();
  $this->load->view('reports/ledgers/report_header', array('header' => 'Trial Balance')); 
?>

<div class="col-md-12">
  <?= getHttpButton('Update Vadotar / Vatav', base_url().'reports/trial_balances?update_vadotar=1', 'float-right btn-success ml-5'); ?>
</div>

<?php $this->load->view('trial_balances/trial_balance', array('trial_balance_records' => $trial_balance, 'loss_account' => 0)); ?>

<hr />
<h5 class="ml-2 pl-2">Loss Account Details</h5>
<?php $this->load->view('trial_balances/trial_balance', array('trial_balance_records' => $loss_account_records, 'loss_account' => 1)); ?>