<?php $this->load->view('reports/ledgers/report_header', array('header' => 'Trial Balance')); ?>

<div class="row">
  <div class="col-md-6">
    <div class="form-group container">
      <div class="table-responsive m-t-20">
        <table class="table table-sm fixedthead table-default">
          <thead>
            <tr>
              <th>Liabilities</th>
              <th class="text-right">Fine</th>
              <th class="text-right">Vadotar</th>
            </tr>
          </thead>
          <?php
              $liabilities_fine = 0; 
              $liabilities_vadotar = 0;  
              
              if(!empty($trial_balance)) {
                foreach ($trial_balance as $record) {
                  if ($record['fine'] <= 0) continue;
                  $liabilities_vadotar = $liabilities_vadotar + $record['vadotar'];
                  $liabilities_fine = $liabilities_fine + $record['fine']; ?>

                  <tr>
                    <td><?= $record['account_name']; ?></td>
                    <td class="text-right"><?= four_decimal(($record['fine']), '-'); ?></td>
                    <td class="text-right"><?= four_decimal(($record['vadotar']), '-') ?>  </td>
                  </tr>
                <?php }
              } 
          ?>
          <tr>
            <th>Total</th>
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
              <th class="text-right">Fine</th>
              <th class="text-right">Vadotar</th>
            </tr>
          </thead>
          <?php 
              $assets_fine = 0;  
              $assets_vadotar = 0;  
              if(!empty($trial_balance)) {
                foreach ($trial_balance as $record) {
                  if ($record['fine'] >= 0) continue;
                  $assets_vadotar = $assets_vadotar + $record['vadotar'];
                  $assets_fine = $assets_fine + $record['fine']; ?>

                  <tr>
                    <td><?= $record['account_name']; ?></td>
                    <td class="text-right"><?= four_decimal(-1 * $record['fine'], '-') ?></td>
                    <td class="text-right"><?= four_decimal(-1 * $record['vadotar'], '-') ?>  </td>
                  </tr>
                <?php }
              } 
          ?>
          <tr>
            <th>Total</th>
            <th class="text-right"><?= four_decimal(-1 * $assets_fine, '-'); ?></th>          
            <th class="text-right"><?= four_decimal(-1 * $assets_vadotar, '-'); ?></th>
          </tr>
        </table>
      </div>
      
    </div>
  </div>  <div class="col-md-6">
    <div class="form-group container">
      <div class="table-responsive m-t-20">
        <table class="table table-sm fixedthead table-default">
          <thead>
            <tr>
              <th></th>
              <th class="text-right"></th>
              <th class="text-right"></th>
              <th class="text-right">Total</th>
            </tr>
          </thead>
                  <tr>
                    <td>AR GOLD</td>
                    <td class="text-right"><?= four_decimal($argold_balance->argold) ?></td>
                    <td class="text-right"><?= four_decimal($live_balance->argold) ?>  </td>
                    <td class="text-right"><?= four_decimal($argold_balance->argold+$live_balance->argold) ?>  </td>
                  </tr>'
                  <tr>
                    <td>ARC</td>
                    <td class="text-right"><?= four_decimal($argold_balance->arc) ?></td>
                    <td class="text-right"><?= four_decimal($live_balance->arc) ?>  </td>
                    <td class="text-right"><?= four_decimal($argold_balance->arc+$live_balance->arc) ?>  </td>
                  </tr>
                  <tr>
                    <td>ARF</td>
                    <td class="text-right"><?= four_decimal($argold_balance->arf) ?></td>
                    <td class="text-right"><?= four_decimal($live_balance->arf) ?>  </td>
                    <td class="text-right"><?= four_decimal($argold_balance->arf+$live_balance->arf) ?>  </td>
                  </tr>
               
        </table>
      </div>
      
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group container">
      <table class="table table-sm fixedthead table-default">
        <tr>
          <td><b>Liabilities: </b></td>
          <td class="text-right"><?= four_decimal($liabilities_fine, '-') ?></td>
        </tr>
          <td><b>Vadotar: </b></td>
          <td class="text-right"><?= four_decimal($assets_vadotar - $liabilities_vadotar);  ?></td>
        </tr>
        <tr>
        <tr>
          <td><b>Assets: </b></td>
          <td class="text-right"><?= four_decimal(-1 * $assets_fine, '-');  ?></td>
        </tr>
        <tr>
          <td><b>Total: </b></td>
          <td class="text-right"><b><?= four_decimal(-1 * ($liabilities_fine + $assets_fine + $assets_vadotar - $liabilities_vadotar), '-');  ?></b></td>
        </tr>
        <tr>
          <td><b>Closing Stock: </b></td>
          <td class="text-right"><b><?= four_decimal($assets_fine + $liabilities_fine + $assets_vadotar - $liabilities_vadotar, '-');  ?></b></td>
        </tr>
        <tr>
          <td><b>Balance: </b></td>
          <td class="text-right">0</td>
        </tr>
    </div>
  </div>
</div>