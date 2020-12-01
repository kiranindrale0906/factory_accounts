<hr />
<h5 class="ml-2 pl-2">Profit and Loss Account</h5>

<div class="row">
  <div class="col-md-6">
    <div class="form-group container">
      <div class="table-responsive m-t-20">
        <table class="table table-sm fixedthead table-default">
          <thead>
            <tr>
              <th>Expenses</th>
              <th class="text-right">Amount</th>
              <th class="text-right">Rate</th>
              <th class="text-right">Fine</th>
            </tr>
          </thead>
          <?php
              $liabilities_fine = 0; 
              $liabilities_vadotar = 0;  
              $liabilities_amount = 0;
              $purchase_rate = 0;

              if(!empty($trial_balance)) {
                foreach ($trial_balance as $record) {
                  if (   $record['account_name'] != 'PURCHASE ACCOUNT'
                      && $record['account_name'] != 'Main Vadotar') continue;

                  if ($record['account_name'] == 'PURCHASE ACCOUNT')
                    $purchase_rate = -1 * $record['amount'] / $record['fine'];
                  $liabilities_vadotar = $liabilities_vadotar + $record['vadotar'];
                  $liabilities_fine = $liabilities_fine + $record['fine']; 
                  $liabilities_amount = $liabilities_amount + $record['amount']; 
                  if(round($record['fine'],2)!=0){
                  ?>

                  <tr>
                    <td><?= $record['account_name']; ?></td>
                    <td class="text-right"><?= four_decimal((-1 * $record['amount']), '-') ?>  </td>
                    <td class="text-right"><?= four_decimal((-1 * $record['amount'] / $record['fine']), '-') ?>  </td>
                    <td class="text-right"><?= four_decimal(($record['fine']), '-'); ?></td>
                  </tr>
                <?php }}
              } 
          ?>
          <tr>
            <td>Pending Vadotar</td>
            <td class="text-right">-</td>
            <td class="text-right">-</td>
            <td class="text-right"><?= four_decimal($pending_vadotar, '-'); ?></td>
          </tr>
          <tr>
            <th>Total</th>
            <th class="text-right"><?= four_decimal($liabilities_amount, '-'); ?></th>
            <th class="text-right"></th>          
            <th class="text-right"><?= four_decimal($liabilities_fine + $pending_vadotar, '-'); ?></th>          
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
              <th>Income</th>
              <th class="text-right">Amount</th>
              <th class="text-right">Rate</th>
              <th class="text-right">Fine</th>
            </tr>
          </thead>
          <?php 
              $assets_fine = 0;  
              $assets_vadotar = 0;  
              $assets_amount = 0;  
              $sales_weight = 0;
              if(!empty($trial_balance)) {
                foreach ($trial_balance as $record) {
                  if ($record['account_name'] != 'SALES ACCOUNT') continue;
                  if ($record['account_name'] == 'SALES ACCOUNT') {
                    $sales_weight = -1 * $record['fine'];
                    $sales_rate = $record['amount'] / (-1 * $record['fine']);
                  }
                  $assets_vadotar = $assets_vadotar + $record['vadotar'];
                  $assets_fine = $assets_fine + $record['fine'];
                  $assets_amount= $assets_amount + $record['amount'];
                  if(round($record['fine'],2)!=0){
                   ?>

                  <tr>
                    <td><?= $record['account_name']; ?></td>
                    <td class="text-right"><?= four_decimal($record['amount'], '-') ?>  </td>
                    <td class="text-right"><?= four_decimal($record['amount'] / (-1 * $record['fine']), '-') ?>  </td>
                    <td class="text-right"><?= four_decimal(-1 * $record['fine'], '-') ?></td>
                  </tr>
                <?php }
                }
              } 
          ?>
          <tr>
            <td>Sales Diff</td>
            <td class="text-right"><?= four_decimal($sales_weight * ($purchase_rate - $sales_rate), '-'); ?></td>
            <td class="text-right"><?= four_decimal($purchase_rate - $sales_rate,'-') ?></td>
            <td class="text-right"><?= four_decimal($pending_vadotar, '-'); ?></td>
          </tr>
          <tr>
            <td>Closing Stock</td>
            <td class="text-right"><?= four_decimal(($liabilities_fine + $pending_vadotar + $assets_fine) * $purchase_rate, '-'); ?></td>
            <td class="text-right"><?= four_decimal($purchase_rate, '-'); ?></td>          
            <td class="text-right"><?= four_decimal(($liabilities_fine + $pending_vadotar + $assets_fine), '-'); ?></td>          
          </tr>
          <tr>
            <th>Total</th>
            <th class="text-right"><?= four_decimal($liabilities_amount - $assets_amount + $assets_amount, '-'); ?></th>          
            <th class="text-right"></th>          
            <th class="text-right"><?= four_decimal($liabilities_fine + $pending_vadotar - $assets_fine + $assets_fine, '-'); ?></th>          
          </tr>
        </table>
      </div>      
    </div>
  </div>  
</div>