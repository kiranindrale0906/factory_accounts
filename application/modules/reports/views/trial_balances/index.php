<?php 
  $profit_and_loss = array();
  $this->load->view('reports/ledgers/report_header', array('header' => 'Trial Balance')); 
?>

<?php $this->load->view('trial_balances/trial_balance', array('trial_balance_records' => $trial_balance, 'loss_account' => 0)); ?>

<div class="row">
  <div class="col-md-6">
    <div class="form-group container">
      <table class="table table-sm fixedthead table-default">
        <tr>
          <td><b>Liabilities: </b></td>
          <td class="text-right"><?= four_decimal($liabilities_fine, '-') ?></td>
        </tr>
          <td><b>Vadotar: </b></td>
          <td class="text-right"><?= four_decimal(-1 * ($liabilities_vadotar + $assets_vadotar));  ?></td>
        </tr>
        <tr>
        <tr>
          <td><b>Assets: </b></td>
          <td class="text-right"><?= four_decimal(-1 * $assets_fine, '-');  ?></td>
        </tr>
        <tr>
          <td><b>Total: </b></td>
          <td class="text-right"><?= four_decimal(-1 * ($liabilities_fine + $assets_fine - $liabilities_vadotar - $assets_vadotar), '-');  ?></td>
        </tr>
        <tr>
          <td><b>Closing Stock: </b></td>
          <td class="text-right"><b><?= four_decimal($assets_fine + $liabilities_fine - $liabilities_vadotar - $assets_vadotar, '-');  ?></b></td>
        </tr>
      </table>
    </div>
  </div>
  
  <?php $this->load->view('trial_balances/factory_balance'); ?>
</div>

<?php $this->load->view('trial_balances/profit_and_loss', array('profit_and_loss' => $profit_and_loss)); ?>
  <hr />
  <h5 class="ml-2 pl-2">Profit and Loss Account</h5>
<?php $this->load->view('trial_balances/trial_balance', array('trial_balance_records' => $loss_account_records, 'loss_account' => 1)); ?>