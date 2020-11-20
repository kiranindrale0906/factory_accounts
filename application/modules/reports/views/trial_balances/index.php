<?php $this->load->view('reports/ledgers/report_header', array('header' => 'Trial Balance')); ?>
  
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
          <td class="text-right"><b><?= four_decimal(-1 * ($liabilities_fine + $assets_fine - $liabilities_vadotar - $assets_vadotar), '-');  ?></b></td>
        </tr>
        <tr>
          <td><b>Closing Stock: </b></td>
          <td class="text-right"><b><?= four_decimal($assets_fine + $liabilities_fine - $liabilities_vadotar - $assets_vadotar, '-');  ?></b></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group container">
      <div class="table-responsive m-t-20">
        <table class="table table-sm fixedthead table-default">
          <thead>
            <tr>
              <th>Factory Closing Stock</th>
              <th class="text-right">Accounts</th>
              <th class="text-right">Factory</th>
              <th class="text-right">Total</th>
            </tr>
          </thead>
          <tr>
            <td>AR GOLD</td>
            <td class="text-right"><?= four_decimal(-1 * $accounts_argold_balance) ?></td>
            <td class="text-right"><?= four_decimal(-1 * $live_argold_balance) ?></td>
            <td class="text-right"><?= four_decimal($accounts_argold_balance - $live_argold_balance) ?></td>
          </tr>
          <tr>
            <td>ARF</td>
            <td class="text-right"><?= four_decimal(-1 * $accounts_arf_balance) ?></td>
            <td class="text-right"><?= four_decimal(-1 * $live_arf_balance) ?>  </td>
            <td class="text-right"><?= four_decimal($accounts_arf_balance - $live_arf_balance) ?></td>
          </tr>
          <tr>
            <td>ARC</td>
            <td class="text-right"><?= four_decimal(-1 * $accounts_arc_balance) ?></td>
            <td class="text-right"><?= four_decimal(-1 * $live_arc_balance) ?>  </td>
            <td class="text-right"><?= four_decimal($accounts_arc_balance - $live_arc_balance) ?></td>
          </tr>
          <tr>
            <td>Total</td>
            <td class="text-right"><?= four_decimal(-1 * ($accounts_argold_balance + $accounts_arf_balance + $accounts_arc_balance)) ?></td>
            <td class="text-right"><?= four_decimal(-1 * ($live_argold_balance + $live_arf_balance + $live_arc_balance)) ?>  </td>
            <td class="text-right"><b><?= four_decimal(-1 * (  $accounts_argold_balance  - $live_argold_balance
                                                             + $accounts_arf_balance - $live_arf_balance
                                                             + $accounts_arc_balance - $live_arc_balance)) ?></b></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>