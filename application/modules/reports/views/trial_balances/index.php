<?php $this->load->view('reports/ledgers/report_header', array('header' => 'Trial Balance')); ?>

<!-- <div class="row"> 
  <div class="col-md-6">
    <div class="container">
      <h6>
        Bhav Cut: 
        <a class="ml-5 <?= ($trial_balance_type == 'Stock') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/trial_balances?type=Stock'>No</a>
        <a class="ml-5 <?= ($trial_balance_type != 'Stock') ? 'bold black underline' : '' ?>"
               href='<?= base_url() ?>reports/trial_balances?type=Amount'>Yes</a>    
      </h6>
    </div>
  </div>
</div>
 -->
<div class="row">
  <div class="col-md-6">
    <div class="form-group container">
      <div class="table-responsive m-t-20">
        <table class="table table-sm fixedthead table-default">
          <thead>
            <tr>
              <th>Liabilities</th>
              <th class="text-right">Amount</th>
              <th class="text-right">Fine</th>
              <th class="text-right">Vadotar</th>
            </tr>
          </thead>
          <?php
              $liabilities_fine = 0; 
              $liabilities_vadotar = 0;  
              $liabilities_amount = 0;

              if(!empty($trial_balance)) {
                foreach ($trial_balance as $record) {
                  if (   ($record['fine'] <= 0
                          && $record['account_name'] != 'VADOTAR')
                      || ($record['account_name'] == 'Tounch Loss Fine')) continue;
                  $liabilities_vadotar = $liabilities_vadotar + $record['vadotar'];
                  $liabilities_fine = $liabilities_fine + $record['fine']; 
                  $liabilities_amount = $liabilities_amount + $record['amount']; 
                  if(round($record['fine'],2)!=0){
                  ?>

                  <tr>
                    <td><?= $record['account_name']; ?></td>
                    <td class="text-right"><?= four_decimal(($record['amount']), '-') ?>  </td>
                    <td class="text-right"><?= four_decimal(($record['fine']), '-'); ?></td>
                    <td class="text-right"><?= four_decimal(($record['vadotar']), '-') ?>  </td>
                  </tr>
                <?php }}
              } 
          ?>
          <tr>
            <th>Total</th>
            <th class="text-right"><?= four_decimal($liabilities_amount, '-'); ?></th>
            <th class="text-right"><?= four_decimal($liabilities_fine, '-'); ?></th>          
            <th class="text-right"><?= four_decimal($liabilities_vadotar, '-'); ?></th>
          </tr>
        </table>

        
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group container">
      <div class="table-responsive m-t-20">
        <table class="table table-sm fixedthead table-default">
          <thead>
            <tr>
              <th>Assets</th>
              <th class="text-right">Amount</th>
              <th class="text-right">Fine</th>
              <th class="text-right">Vadotar</th>
            </tr>
          </thead>
          <?php 
              $assets_fine = 0;  
              $assets_vadotar = 0;  
              $assets_amount = 0;  
              if(!empty($trial_balance)) {
                foreach ($trial_balance as $record) {
                  if (  ($record['fine'] >= 0
                         && $record['account_name'] != 'Tounch Loss Fine')
                      || ($record['account_name'] == 'VADOTAR')) continue;
                  $assets_vadotar = $assets_vadotar + $record['vadotar'];
                  $assets_fine = $assets_fine + $record['fine'];
                  $assets_amount= $assets_amount + $record['amount'];
                  if(round($record['fine'],2)!=0){
                   ?>

                  <tr>
                    <td><?= $record['account_name']; ?></td>
                    <td class="text-right"><?= four_decimal(-1 * $record['amount'], '-') ?>  </td>
                    <td class="text-right"><?= four_decimal(-1 * $record['fine'], '-') ?></td>
                    <td class="text-right"><?= four_decimal(-1 * $record['vadotar'], '-') ?>  </td>
                  </tr>
                <?php }
                }
              } 
          ?>
          <tr>
            <th>Total</th>
            <th class="text-right"><?= four_decimal(-1 * $assets_amount, '-'); ?></th>          
            <th class="text-right"><?= four_decimal(-1 * $assets_fine, '-'); ?></th>          
            <th class="text-right"><?= four_decimal(-1 * $assets_vadotar, '-'); ?></th>
          </tr>
        </table>
      </div>      
    </div>
  </div>  
</div>
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

<?php $this->load->view('trial_balances/profit_and_loss', array('pending_vadotar' => four_decimal($liabilities_vadotar + $assets_vadotar))); ?>
