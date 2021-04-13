<?php 
  $purchase_amount = !empty($profit_and_loss['purchase_account']['amount'])?-1 * $profit_and_loss['purchase_account']['amount']:0;

  $purchase_rate = !empty($profit_and_loss['purchase_account']['fine'])?-1 * $profit_and_loss['purchase_account']['amount'] / $profit_and_loss['purchase_account']['fine']:0;
  $purchase_fine = !empty($profit_and_loss['purchase_account']['fine'])?$profit_and_loss['purchase_account']['fine']:0;
  $sales_amount = !empty($profit_and_loss['sales_account']['amount'])?$profit_and_loss['sales_account']['amount']:0;
  $sales_rate = !empty($profit_and_loss['sales_account']['fine'])?(-1 * $profit_and_loss['sales_account']['amount'] / $profit_and_loss['sales_account']['fine']):0;
  $gold_rate=$gold_rate/10;
  $sales_fine = !empty($profit_and_loss['sales_account']['fine'])?-1 * $profit_and_loss['sales_account']['fine']:0;
  $main_vadotar_fine = @$profit_and_loss['main_vadotar']['fine'];
  $pending_vadotar_fine = -1 * $profit_and_loss['pending_vadotar'];
  $exchange_rate_diff = $purchase_rate - $sales_rate;
  $closing_fine = $purchase_fine + $main_vadotar_fine + $pending_vadotar_fine - $sales_fine;
  $income_total = $sales_amount + ($sales_fine * $exchange_rate_diff) + ($closing_fine * $gold_rate);
?>

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

          <tr>
            <td>PURCHASE ACCOUNT</td>
            <td class="text-right"><?= four_decimal($purchase_amount, '-') ?></td>
            <td class="text-right"><?= four_decimal($purchase_rate, '-'); ?></td>
            <td class="text-right"><?= four_decimal($purchase_fine, '-'); ?></td>
          </tr>
          <tr>
            <td>Main Vadotar</td>
            <td class="text-right">-</td>
            <td class="text-right">-</td>
            <td class="text-right"><?= four_decimal($main_vadotar_fine, '-') ?></td>
          </tr>
          <tr>
            <td>Pending Vadotar</td>
            <td class="text-right">-</td>
            <td class="text-right">-</td>
            <td class="text-right"><?= four_decimal($pending_vadotar_fine, '-'); ?></td>
          </tr>
          <tr>
            <td>Gross Profit</td>
            <td class="text-right"><?= four_decimal($income_total - $purchase_amount); ?></td>
            <td class="text-right">-</td>
            <td class="text-right">-</td>
          </tr>
          <tr>
            <th>Total</th>
            <th class="text-right"><?= four_decimal($purchase_amount + ($income_total - $purchase_amount), '-'); ?></th>
            <th class="text-right">-</th>          
            <th class="text-right"><?= four_decimal($purchase_fine + $main_vadotar_fine + $pending_vadotar_fine, '-'); ?></th>          
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
          <tr>
            <td>SALES ACCOUNT</td>
            <td class="text-right"><?= four_decimal($sales_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($sales_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($sales_fine, '-'); ?></td>
          </tr>
          <tr>
            <td>Exchange Gain / Loss</td>
            <td class="text-right"><?= four_decimal($sales_fine * $exchange_rate_diff , '-'); ?></td>
            <td class="text-right"><?= four_decimal($exchange_rate_diff, '-'); ?></td>
            <td class="text-right"></td>
          </tr>
          <tr>
            <td>Closing Stock</td>
            <td class="text-right"><?= four_decimal($closing_fine * ($gold_rate), '-'); ?></td>
            <td class="text-right"><?= four_decimal(($gold_rate), '-'); ?></td>          
            <td class="text-right"><?= four_decimal($closing_fine, '-'); ?></td>          
          </tr>
          <tr>
            <th>Total</th>
            <th class="text-right">
              <?= four_decimal($income_total, '-'); ?>
            </th>
            <th class="text-right"></th>          
            <th class="text-right"><?= four_decimal($sales_fine + $closing_fine, '-'); ?></th>          
          </tr>
        </table>
      </div>      
    </div>
  </div>  
</div>