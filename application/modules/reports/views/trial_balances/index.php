<?php 
  $profit_and_loss = array();
  $this->load->view('reports/ledgers/report_header', array('header' => 'Trial Balance')); 
?>


<?php 
  if (isset($trial_balance))
    $this->load->view('trial_balances/trial_balance', array('trial_balance_records' => $trial_balance, 'loss_account' => 0)); 
?>

<hr />
<div class="col-md-12">
<h5 class="ml-2 pl-2">Loss Account Details</h5>
<form class="fields-group-sm">
    <div class="row">
		<?php load_field('date',array('field' => 'date', 'class' => 'datepicker_js', 'col'=>'col-sm-3','value'=>$loss_date))?> 
		<div class="col-sm-4 align-self-center">
		        <?php load_buttons('button', array('name' =>'Search','class'=>'btn-xs btn_blue loss_search_date mr-2')) ?> 
		        <?php load_buttons('button', array('name' =>'Clear','class'=>'btn-xs btn_blue clear_btn')) ?> 
		</div>
	</div>
</form>

<?php $this->load->view('trial_balances/trial_balance', array('trial_balance_records' => $loss_account_records, 'loss_account' => 1)); ?>
</div>
<hr />
<div class="col-md-12">
  <?= getHttpButton('Update Vadotar / Vatav', base_url().'reports/trial_balances?update_vadotar=1', 'float-right btn-success ml-5'); ?>
</div>
<div class="row">
  <?php $this->load->view('trial_balances/alloy_vodator_balance'); ?>
</div>
<div class="row">
  <?php $this->load->view('trial_balances/gpc_vodator_balance'); ?>
</div>
<div class="row">
  <?php $this->load->view('trial_balances/stone_vatav_balance'); ?>
</div>
<div class="row">
  <?php $this->load->view('trial_balances/copper_vatav_balance'); ?>
</div>
<div class="row">
  <?php $this->load->view('trial_balances/rhodium_vatav_balance'); ?>
</div>
<div class="row">
<?php $this->load->view('trial_balances/overall_rolling_balance'); ?>
</div>