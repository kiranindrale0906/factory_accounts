<?php 
  $domestic_export_records = array();
  foreach($purchase_sales_account_domestic_export_records as $domestic_export_record) 
    $domestic_export_records[$domestic_export_record['account_name']][$domestic_export_record['is_export']] = $domestic_export_record;
  
  $purchase_domestic_fine = !empty($domestic_export_records['PURCHASE ACCOUNT'][0]['fine']) ? $domestic_export_records['PURCHASE ACCOUNT'][0]['fine'] : 0;
  $purchase_domestic_rate = !empty($domestic_export_records['PURCHASE ACCOUNT'][0]['fine']) ? -1 * $domestic_export_records['PURCHASE ACCOUNT'][0]['amount'] / $domestic_export_records['PURCHASE ACCOUNT'][0]['fine'] : 0;
  $purchase_domestic_amount = !empty($domestic_export_records['PURCHASE ACCOUNT'][0]['amount']) ? -1 * $domestic_export_records['PURCHASE ACCOUNT'][0]['amount'] : 0;

  $purchase_export_fine = !empty($domestic_export_records['PURCHASE ACCOUNT'][1]['fine']) ? $domestic_export_records['PURCHASE ACCOUNT'][1]['fine'] : 0;
  $purchase_export_rate = !empty($domestic_export_records['PURCHASE ACCOUNT'][1]['fine']) ? -1 * $domestic_export_records['PURCHASE ACCOUNT'][1]['amount'] / $domestic_export_records['PURCHASE ACCOUNT'][1]['fine'] : 0;
  $purchase_export_amount = !empty($domestic_export_records['PURCHASE ACCOUNT'][1]['amount']) ? -1 * $domestic_export_records['PURCHASE ACCOUNT'][1]['amount'] : 0;

  $sales_domestic_fine = !empty($domestic_export_records['SALES ACCOUNT'][0]['fine']) ? -1 * $domestic_export_records['SALES ACCOUNT'][0]['fine'] : 0;
  $sales_domestic_rate = !empty($domestic_export_records['SALES ACCOUNT'][0]['fine']) ? -1 * $domestic_export_records['SALES ACCOUNT'][0]['amount'] / $domestic_export_records['SALES ACCOUNT'][0]['fine'] : 0;
  $sales_domestic_amount = !empty($domestic_export_records['SALES ACCOUNT'][0]['amount']) ? $domestic_export_records['SALES ACCOUNT'][0]['amount'] : 0;

  $sales_export_fine = !empty($domestic_export_records['SALES ACCOUNT'][1]['fine']) ? -1 * $domestic_export_records['SALES ACCOUNT'][1]['fine'] : 0;
  $sales_export_rate = !empty($domestic_export_records['SALES ACCOUNT'][1]['fine']) ? -1 * $domestic_export_records['SALES ACCOUNT'][1]['amount'] / $domestic_export_records['SALES ACCOUNT'][1]['fine'] : 0;
  $sales_export_amount = !empty($domestic_export_records['SALES ACCOUNT'][1]['amount']) ? $domestic_export_records['SALES ACCOUNT'][1]['amount'] : 0;

  $main_vadotar_fine = @$profit_and_loss['main_vadotar']['fine'];
  $main_vadotar_amount = $main_vadotar_rate = 0;

  $pending_vadotar_fine = -1 * $profit_and_loss['pending_vadotar'];
  $pending_vadotar_amount = $pending_vadotar_rate = 0;

  $purchase_fine = !empty($profit_and_loss['purchase_account']['fine']) ? $profit_and_loss['purchase_account']['fine'] : 0;
  $purchase_rate = !empty($profit_and_loss['purchase_account']['fine']) ? -1 * $profit_and_loss['purchase_account']['amount'] / $profit_and_loss['purchase_account']['fine'] : 0;
  $purchase_amount = !empty($profit_and_loss['purchase_account']['amount']) ? -1 * $profit_and_loss['purchase_account']['amount'] : 0;

  $sales_fine = !empty($profit_and_loss['sales_account']['fine']) ? -1 * $profit_and_loss['sales_account']['fine'] : 0;
  $sales_rate = !empty($profit_and_loss['sales_account']['fine']) ? (-1 * $profit_and_loss['sales_account']['amount'] / $profit_and_loss['sales_account']['fine']) : 0;
  $sales_amount = !empty($profit_and_loss['sales_account']['amount']) ? $profit_and_loss['sales_account']['amount'] : 0;

  $domestic_closing_fine = $purchase_domestic_fine + $main_vadotar_fine + $pending_vadotar_fine - $sales_domestic_fine;
  $closing_rate = $gold_rate / .995 / 10;
  $domestic_closing_amount = $domestic_closing_fine * $closing_rate;

  $export_closing_fine = $purchase_export_fine - $sales_export_fine;
  $export_closing_rate = $spot_gold / 31.1034 * $usd_rate;
  $export_closing_amount = $export_closing_fine * $export_closing_rate;

  // $closing_fine = $purchase_domestic_fine + $purchase_export_fine + $main_vadotar_fine + $pending_vadotar_fine - $sales_domestic_fine - $sales_export_fine;
  // $closing_rate = $gold_rate / .995 / 10;
  // $closing_amount = $closing_fine * $closing_rate;

  $total_sales_with_closing_amount = $sales_domestic_amount + $sales_export_amount + $domestic_closing_amount + $export_closing_amount;
  $total_sales_with_closing_fine = $sales_domestic_fine + $sales_export_fine + $domestic_closing_fine + $export_closing_fine;
  $total_sales_with_closing_rate = $total_sales_with_closing_amount / $total_sales_with_closing_fine;

  $domestic_gain_loss_fine = $sales_domestic_fine + $domestic_closing_fine;
  $domestic_gain_loss_rate = $purchase_domestic_rate - (($sales_domestic_amount + $domestic_closing_amount) / $domestic_gain_loss_fine);
  $domestic_gain_loss_amount = $domestic_gain_loss_fine * $domestic_gain_loss_rate;

  $export_gain_loss_fine = $sales_export_fine + $export_closing_fine;
  $export_gain_loss_rate = $purchase_export_rate - (($sales_export_amount + $export_closing_amount) / $export_gain_loss_fine);
  $export_gain_loss_amount = $export_gain_loss_fine * $export_gain_loss_rate;

  // $exchange_gain_loss_fine = $total_sales_with_closing_fine;
  // $exchange_gain_loss_rate = $purchase_rate - $total_sales_with_closing_rate;
  // $exchange_gain_loss_amount = $exchange_gain_loss_fine * $exchange_gain_loss_rate;

  $total_income_amount = $total_sales_with_closing_amount + $domestic_gain_loss_amount + $export_gain_loss_amount;
  $total_income_fine = $total_sales_with_closing_fine;
  $total_income_rate = $total_income_amount / $total_income_fine;

  $gross_profit_fine = 0;
  $gross_profit_rate = 0;
  $gross_profit_amount = $total_income_amount - $purchase_domestic_amount - $purchase_export_amount;

  $total_expenses_amount = $purchase_domestic_amount + $purchase_export_amount + $gross_profit_amount;
  $total_expenses_fine = $purchase_domestic_fine + $purchase_export_fine + $main_vadotar_fine + $pending_vadotar_fine;
  $total_expenses_rate = 0;
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
            <td>DOMESTIC</td>
            <td class="text-right"><?= four_decimal($purchase_domestic_amount, '-') ?></td>
            <td class="text-right"><?= four_decimal($purchase_domestic_rate, '-'); ?></td>
            <td class="text-right"><?= four_decimal($purchase_domestic_fine, '-'); ?></td>
          </tr>
          <tr>
            <td>IMPORT</td>
            <td class="text-right"><?= four_decimal($purchase_export_amount, '-') ?></td>
            <td class="text-right"><?= four_decimal($purchase_export_rate, '-'); ?></td>
            <td class="text-right"><?= four_decimal($purchase_export_fine, '-'); ?></td>
          </tr>
          <tr>
            <th>TOTAL PURCHASE</th>
            <th class="text-right"><?= four_decimal($purchase_amount, '-') ?></th>
            <th class="text-right"><?= four_decimal($purchase_rate, '-'); ?></th>
            <th class="text-right"><?= four_decimal($purchase_fine, '-'); ?></th>
          </tr>
          <tr>
            <td>Main Vadotar</td>
            <td class="text-right"><?= four_decimal($main_vadotar_amount, '-') ?></td>
            <td class="text-right"><?= four_decimal($main_vadotar_rate, '-') ?></td>
            <td class="text-right"><?= four_decimal($main_vadotar_fine, '-') ?></td>
          </tr>
          <tr>
            <td>Pending Vadotar</td>
            <td class="text-right"><?= four_decimal($pending_vadotar_amount, '-'); ?></td>
            <td class="text-right"><?= four_decimal($pending_vadotar_rate, '-'); ?></td>
            <td class="text-right"><?= four_decimal($pending_vadotar_fine, '-'); ?></td>
          </tr>
          <tr>
            <td>Gross Profit</td>
            <td class="text-right"><?= four_decimal($gross_profit_amount, '-'); ?></td>
            <td class="text-right"><?= four_decimal($gross_profit_rate, '-'); ?></td>
            <td class="text-right"><?= four_decimal($gross_profit_fine, '-'); ?></td>
          </tr>
          <tr>
            <th>Total</th>
            <th class="text-right"><?= four_decimal($total_expenses_amount, '-'); ?></th>
            <th class="text-right"><?= four_decimal($total_expenses_rate, '-'); ?></th>
            <th class="text-right"><?= four_decimal($total_expenses_fine, '-'); ?></th>
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
            <td>DOMESTIC</td>
            <td class="text-right"><?= four_decimal($sales_domestic_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($sales_domestic_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($sales_domestic_fine, '-'); ?></td>
          </tr>
          <tr>
            <td>EXPORT</td>
            <td class="text-right"><?= four_decimal($sales_export_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($sales_export_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($sales_export_fine, '-'); ?></td>
          </tr>
          <tr>
            <th>TOTAL SALE</th>
            <th class="text-right"><?= four_decimal($sales_amount, '-') ?>  </th>
            <th class="text-right"><?= four_decimal($sales_rate, '-'); ?>  </th>
            <th class="text-right"><?= four_decimal($sales_fine, '-'); ?></th>
          </tr>
          <tr>
            <td>Domestic Closing Stock</td>
            <td class="text-right"><?= four_decimal($domestic_closing_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($closing_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($domestic_closing_fine, '-'); ?></td>
          </tr>
          <tr>
            <td>Export Closing Stock</td>
            <td class="text-right"><?= four_decimal($export_closing_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($export_closing_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($export_closing_fine, '-'); ?></td>
          </tr>
           <tr>
            <th>Sales and Closing</th>
            <th class="text-right"><?= four_decimal($total_sales_with_closing_amount, '-') ?>  </th>
            <th class="text-right"><?= four_decimal($total_sales_with_closing_rate, '-'); ?>  </th>
            <th class="text-right"><?= four_decimal($total_sales_with_closing_fine, '-'); ?></th>
          </tr>
          <tr>
            <td>Domestic Gain / Loss</td>
            <td class="text-right"><?= four_decimal($domestic_gain_loss_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($domestic_gain_loss_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($domestic_gain_loss_fine, '-'); ?></td>
          </tr>
          <tr>
            <td>Export Gain / Loss</td>
            <td class="text-right"><?= four_decimal($export_gain_loss_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($export_gain_loss_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($export_gain_loss_fine, '-'); ?></td>
          </tr>
          <tr>
            <th>Total</th>
            <th class="text-right"><?= four_decimal($total_income_amount, '-') ?>  </th>
            <th class="text-right"><?= four_decimal($total_income_rate, '-'); ?>  </th>
            <th class="text-right"><?= four_decimal($total_income_fine, '-'); ?></th>
          </tr>
        </table>
      </div>      
    </div>
  </div>  
</div>
