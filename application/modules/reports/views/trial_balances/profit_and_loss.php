<?php 
  $domestic_export_records = array();
  foreach($purchase_sales_account_domestic_export_records as $domestic_export_record) 
    $domestic_export_records[$domestic_export_record['account_name']][$domestic_export_record['is_export']] = $domestic_export_record;
  
  $domestic_export_records['SALES ACCOUNT'][1] = array('amount' => $sale_export_Sale['taxable_amount'],
                                                       'fine' =>  $sale_export_Sale['factory_fine']);


  $domestic_export_records['PURCHASE ACCOUNT'][0]['fine'] = $domestic_export_records['PURCHASE ACCOUNT'][0]['fine'];
  $domestic_export_records['PURCHASE ACCOUNT'][0]['amount'] = $domestic_export_records['PURCHASE ACCOUNT'][0]['amount'] - 0;

  $purchase_domestic_fine = !empty($domestic_export_records['PURCHASE ACCOUNT'][0]['fine']) ? $domestic_export_records['PURCHASE ACCOUNT'][0]['fine'] : 0;
  $purchase_domestic_rate = !empty($domestic_export_records['PURCHASE ACCOUNT'][0]['fine']) ? -1 * $domestic_export_records['PURCHASE ACCOUNT'][0]['amount'] / $domestic_export_records['PURCHASE ACCOUNT'][0]['fine'] : 0;
  $purchase_domestic_amount = !empty($domestic_export_records['PURCHASE ACCOUNT'][0]['amount']) ? -1 * $domestic_export_records['PURCHASE ACCOUNT'][0]['amount'] : 0;

  $domestic_export_records['PURCHASE ACCOUNT'][1]['fine'] = $domestic_export_records['PURCHASE ACCOUNT'][1]['fine'] ?? 0;
  $domestic_export_records['PURCHASE ACCOUNT'][1]['amount'] = $domestic_export_records['PURCHASE ACCOUNT'][1]['amount'] ?? 0;
  $domestic_export_records['PURCHASE ACCOUNT'][1]['fine'] = $domestic_export_records['PURCHASE ACCOUNT'][1]['fine'] + 0;
  $domestic_export_records['PURCHASE ACCOUNT'][1]['amount'] = $domestic_export_records['PURCHASE ACCOUNT'][1]['amount'] - 0;

  $purchase_export_fine = !empty($domestic_export_records['PURCHASE ACCOUNT'][1]['fine']) ? $domestic_export_records['PURCHASE ACCOUNT'][1]['fine'] : 0;
  $purchase_export_rate = !empty($domestic_export_records['PURCHASE ACCOUNT'][1]['fine']) ? -1 * $domestic_export_records['PURCHASE ACCOUNT'][1]['amount'] / $domestic_export_records['PURCHASE ACCOUNT'][1]['fine'] : 0;
  $purchase_export_amount = !empty($domestic_export_records['PURCHASE ACCOUNT'][1]['amount']) ? -1 * $domestic_export_records['PURCHASE ACCOUNT'][1]['amount'] : 0;


  $domestic_export_records['SALES ACCOUNT'][0]['fine'] = $domestic_export_records['SALES ACCOUNT'][0]['fine'];
  $domestic_export_records['SALES ACCOUNT'][0]['amount'] = $domestic_export_records['SALES ACCOUNT'][0]['amount'];

  $sales_domestic_fine = !empty($domestic_export_records['SALES ACCOUNT'][0]['fine']) ? -1 * $domestic_export_records['SALES ACCOUNT'][0]['fine'] : 0;
  $sales_domestic_rate = !empty($domestic_export_records['SALES ACCOUNT'][0]['fine']) ? -1 * $domestic_export_records['SALES ACCOUNT'][0]['amount'] / $domestic_export_records['SALES ACCOUNT'][0]['fine'] : 0;
  $sales_domestic_amount = !empty($domestic_export_records['SALES ACCOUNT'][0]['amount']) ? $domestic_export_records['SALES ACCOUNT'][0]['amount'] : 0;

  $domestic_export_records['SALES ACCOUNT'][1]['fine'] = $domestic_export_records['SALES ACCOUNT'][1]['fine'] + 0;
  $domestic_export_records['SALES ACCOUNT'][1]['amount'] = $domestic_export_records['SALES ACCOUNT'][1]['amount'] + 0;

  $sales_export_fine = !empty($domestic_export_records['SALES ACCOUNT'][1]['fine']) ? $domestic_export_records['SALES ACCOUNT'][1]['fine'] : 0;
  $sales_export_rate = !empty($domestic_export_records['SALES ACCOUNT'][1]['fine']) ? $domestic_export_records['SALES ACCOUNT'][1]['amount'] / $domestic_export_records['SALES ACCOUNT'][1]['fine'] : 0;
  $sales_export_amount = !empty($domestic_export_records['SALES ACCOUNT'][1]['amount']) ? $domestic_export_records['SALES ACCOUNT'][1]['amount'] : 0;

  $main_vadotar_fine = @$profit_and_loss['main_vadotar']['fine'];
  $main_vadotar_fine = $main_vadotar_fine;
  $main_vadotar_amount = $main_vadotar_rate = 0;

  $pending_vadotar_fine = -1 * $profit_and_loss['pending_vadotar'];
  $pending_vadotar_amount = $pending_vadotar_rate = 0;

  // $sales_fine = !empty($profit_and_loss['sales_account']['fine']) ? -1 * $profit_and_loss['sales_account']['fine'] : 0;
  // $sales_rate = !empty($profit_and_loss['sales_account']['fine']) ? (-1 * $profit_and_loss['sales_account']['amount'] / $profit_and_loss['sales_account']['fine']) : 0;
  // $sales_amount = !empty($profit_and_loss['sales_account']['amount']) ? $profit_and_loss['sales_account']['amount'] : 0;

  $domestic_opening_fine = 71950.427;
  $domestic_opening_rate = 4883.300;
  $domestic_opening_amount = 351356714.000;

  $sales_fine = $sales_domestic_fine + $sales_export_fine;
  $sales_amount = $sales_domestic_amount + $sales_export_amount;
  $sales_rate = ($sales_fine != 0) ? $sales_amount / $sales_fine : 0;

  $domestic_closing_fine = $purchase_domestic_fine + $main_vadotar_fine + $pending_vadotar_fine - $sales_domestic_fine + 71950.427;
  $closing_rate = $gold_rate / .995 / 10;
  $domestic_closing_amount = $domestic_closing_fine * $closing_rate;

  $export_opening_fine = 22345.893;
  $export_opening_rate = 4256.720;
  $export_opening_amount = 95120251.000;

  $export_closing_fine = $purchase_export_fine - $sales_export_fine + 22345.893;
  $export_closing_rate = $spot_gold / 31.1034 * $usd_rate;
  $export_closing_amount = $export_closing_fine * $export_closing_rate;

  // $closing_fine = $purchase_domestic_fine + $purchase_export_fine + $main_vadotar_fine + $pending_vadotar_fine - $sales_domestic_fine - $sales_export_fine;
  // $closing_rate = $gold_rate / .995 / 10;
  // $closing_amount = $closing_fine * $closing_rate;

  $total_sales_with_closing_amount = $sales_domestic_amount + $sales_export_amount + $domestic_closing_amount + $export_closing_amount;
  $total_sales_with_closing_fine = $sales_domestic_fine + $sales_export_fine + $domestic_closing_fine + $export_closing_fine;
  $total_sales_with_closing_rate = ($total_sales_with_closing_fine != 0) ? $total_sales_with_closing_amount / $total_sales_with_closing_fine : 0;

  
  // $exchange_gain_loss_fine = $total_sales_with_closing_fine;
  // $exchange_gain_loss_rate = $purchase_rate - $total_sales_with_closing_rate;
  // $exchange_gain_loss_amount = $exchange_gain_loss_fine * $exchange_gain_loss_rate;

  $export_labour_amount = $sale_export_Labour['taxable_amount'] + 0;
  $domestic_labour_amount['amount'] += 0;

  
?>

<?php
  $total_domestic_purchase_amount = $domestic_opening_amount + $purchase_domestic_amount;
  $total_domestic_purchase_fine = $domestic_opening_fine + $purchase_domestic_fine;
  $total_domestic_purchase_rate = ($total_domestic_purchase_fine != 0) ? $total_domestic_purchase_amount / $total_domestic_purchase_fine : 0;

  $total_import_purchase_amount = $export_opening_amount + $purchase_export_amount;
  $total_import_purchase_fine = $export_opening_fine + $purchase_export_fine;
  $total_import_purchase_rate = ($total_import_purchase_fine != 0) ? $total_import_purchase_amount / $total_import_purchase_fine : 0;
        
  $total_purchase_amount = $total_domestic_purchase_amount + $total_import_purchase_amount;
  $total_purchase_fine = $total_domestic_purchase_fine + $total_import_purchase_fine;
  $total_purchase_rate = ($total_purchase_fine != 0) ? $total_purchase_amount  / $total_purchase_fine : 0;
      
  $domestic_closing_amount = $domestic_closing_fine * $closing_rate;
            
  $total_domestic_amount = $sales_domestic_amount + $domestic_closing_amount;
  $total_domestic_fine = $sales_domestic_fine + $domestic_closing_fine;
  $total_domestic_rate = ($total_domestic_fine != 0) ? $total_domestic_amount / $total_domestic_fine : 0;      

  $domestic_gain_loss_fine = $sales_domestic_fine + $domestic_closing_fine;
  $domestic_gain_loss_rate = ($domestic_gain_loss_fine != 0) ? (($sales_domestic_amount + $domestic_closing_amount) / $domestic_gain_loss_fine) - $total_domestic_purchase_rate: 0;
  $domestic_gain_loss_amount = $domestic_gain_loss_fine * $domestic_gain_loss_rate;

  $export_closing_amount = $export_closing_fine * $export_closing_rate;

  $total_export_amount = $sales_export_amount + $export_closing_amount;
  $total_export_fine = $sales_export_fine + $export_closing_fine;
  $total_export_rate = ($total_export_fine !=0 ) ? $total_export_amount / $total_export_fine : 0;

  $export_gain_loss_fine = $sales_export_fine + $export_closing_fine;
  $export_gain_loss_rate = ($export_gain_loss_fine != 0) ? (($sales_export_amount + $export_closing_amount) / $export_gain_loss_fine) - $total_import_purchase_rate : 0;
  $export_gain_loss_amount = $export_gain_loss_fine * $export_gain_loss_rate;

  $total_sales_amount = $total_domestic_amount + $total_export_amount + $export_labour_amount + $domestic_labour_amount['amount'];
  $total_sales_fine = $sales_domestic_fine + $sales_export_fine;

  $total_income_amount = $total_sales_amount + $domestic_gain_loss_amount + $export_gain_loss_amount;
  $total_income_fine = $total_sales_with_closing_fine;
  $total_income_rate = ($total_income_fine != 0) ? $total_income_amount / $total_income_fine : 0;

  $gross_profit_fine = 0;
  $gross_profit_rate = 0;
  $gross_profit_amount = $total_income_amount + $domestic_gain_loss_amount + $export_gain_loss_amount + $domestic_labour_amount['amount'] - $total_purchase_amount;

  $total_expenses_amount = $total_purchase_amount + $gross_profit_amount;
  $total_expenses_fine = $total_purchase_fine + $main_vadotar_fine + $pending_vadotar_fine;
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
            <td>Domestic Purchase Opening</td>
            <td class="text-right"><?= four_decimal($domestic_opening_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($domestic_opening_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($domestic_opening_fine, '-'); ?></td>
          </tr>
          <tr>
            <td>Domestic Purchase</td>
            <td class="text-right"><?= four_decimal($purchase_domestic_amount, '-') ?></td>
            <td class="text-right"><?= four_decimal($purchase_domestic_rate, '-'); ?></td>
            <td class="text-right"><?= four_decimal($purchase_domestic_fine, '-'); ?></td>
          </tr>

          
          <tr>
            <th>Total Domestic Purchase</th>
            <th class="text-right"><?= four_decimal($total_domestic_purchase_amount, '-') ?></th>
            <th class="text-right"><?= four_decimal($total_domestic_purchase_rate, '-'); ?></th>
            <th class="text-right"><?= four_decimal($total_domestic_purchase_fine, '-'); ?></th>
          </tr>

          <tr>
            <td>Import Opening</td>
            <td class="text-right"><?= four_decimal($export_opening_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($export_opening_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($export_opening_fine, '-'); ?></td>
          </tr>
          
          <tr>
            <td>Import</td>
            <td class="text-right"><?= four_decimal($purchase_export_amount, '-') ?></td>
            <td class="text-right"><?= four_decimal($purchase_export_rate, '-'); ?></td>
            <td class="text-right"><?= four_decimal($purchase_export_fine, '-'); ?></td>
          </tr>

          <tr>
            <th>Total Import Purchase</th>
            <th class="text-right"><?= four_decimal($total_import_purchase_amount, '-') ?></th>
            <th class="text-right"><?= four_decimal($total_import_purchase_rate, '-'); ?></th>
            <th class="text-right"><?= four_decimal($total_import_purchase_fine, '-'); ?></th>
          </tr>

          <tr>
            <td>Main Vadotar</td>
            <td class="text-right"><?= four_decimal($main_vadotar_amount, '-') ?></td>
            <td class="text-right"><?= four_decimal($main_vadotar_rate, '-') ?></td>
            <td class="text-right"><?= four_decimal($main_vadotar_fine - 0, '-') ?></td>
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

          <tr>
            <td>Total Purchase</td>
            <td class="text-right"><?= four_decimal($total_purchase_amount, '-') ?></td>
            <td class="text-right"><?= four_decimal($total_purchase_rate, '-'); ?></td>
            <td class="text-right"><?= four_decimal($total_purchase_fine + 0, '-'); ?></td>
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
            <td>Domestic Sale</td>
            <td class="text-right"><?= four_decimal($sales_domestic_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($sales_domestic_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($sales_domestic_fine, '-'); ?></td>
          </tr>

          
          <tr>
            <td>Domestic Closing Stock</td>
            <td class="text-right"><?= four_decimal($domestic_closing_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($closing_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($domestic_closing_fine, '-'); ?></td>
          </tr>
          <tr>
            <th>Total Domestic Sale</th>
            <th class="text-right"><?= four_decimal($total_domestic_amount, '-') ?>  </th>
            <th class="text-right"><?= four_decimal($total_domestic_rate, '-'); ?>  </th>
            <th class="text-right"><?= four_decimal($total_domestic_fine, '-'); ?></th>
          </tr>

          <tr>
            <th>Domestic Gain</th>
            <th class="text-right"><?= four_decimal($domestic_gain_loss_amount, '-') ?>  </th>
            <th class="text-right"><?= four_decimal($domestic_gain_loss_rate, '-'); ?>  </th>
            <th class="text-right"><?= four_decimal($domestic_gain_loss_fine, '-'); ?></th>
          </tr>
          <tr>
            <td>Export Sale</td>
            <td class="text-right"><?= four_decimal($sales_export_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($sales_export_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($sales_export_fine, '-'); ?></td>
          </tr>

          <tr>
            <td>Export Closing Stock</td>
            <td class="text-right"><?= four_decimal($export_closing_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($export_closing_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($export_closing_fine, '-'); ?></td>
          </tr>
          <tr>
            <th>Total Export Sale</th>
            <th class="text-right"><?= four_decimal($total_export_amount, '-') ?>  </th>
            <th class="text-right"><?= four_decimal($total_export_rate, '-'); ?>  </th>
            <th class="text-right"><?= four_decimal($total_export_fine, '-'); ?></th>
          </tr>

          <tr>
            <th>Export Gain</th>
            <th class="text-right"><?= four_decimal($export_gain_loss_amount, '-') ?>  </th>
            <th class="text-right"><?= four_decimal($export_gain_loss_rate, '-'); ?>  </th>
            <th class="text-right"><?= four_decimal($export_gain_loss_fine, '-'); ?></th>
          </tr>
          <tr>
            <td>Export Labour</td>
            <td class="text-right"><?= four_decimal($export_labour_amount, '-') ?>  </td>
            <td class="text-right">-</td>
            <td class="text-right">-</td>
          </tr>
          <tr>
            <td>Export Loss</td>
            <td class="text-right">-</td>
            <td class="text-right">-</td>
            <td class="text-right">-</td>
          </tr>
          <tr>
            <td>Domestic Labour Amount</td>
            <td class="text-right"><?= $domestic_labour_amount['amount'] ?></td>
            <td class="text-right">-</td>
            <td class="text-right">-</td>
          </tr>
          <!-- <tr>
            <th>TOTAL SALE</th>
            <th class="text-right"><?= four_decimal($sales_amount, '-') ?>  </th>
            <th class="text-right"><?= four_decimal($sales_rate, '-'); ?>  </th>
            <th class="text-right"><?= four_decimal($sales_fine, '-'); ?></th>
          </tr> -->
          
          
           <!-- <tr>
            <th>Sales and Closing</th>
            <th class="text-right"><?= four_decimal($total_sales_with_closing_amount, '-') ?>  </th>
            <th class="text-right"><?= four_decimal($total_sales_with_closing_rate, '-'); ?>  </th>
            <th class="text-right"><?= four_decimal($total_sales_with_closing_fine, '-'); ?></th>
          </tr> -->
          <tr>
            <th>Total</th>
            <th class="text-right"><?= four_decimal($total_income_amount, '-') ?></th>
            <th class="text-right"><?= four_decimal($total_income_rate, '-'); ?></th>
            <th class="text-right"><?= four_decimal($total_income_fine, '-'); ?></th>
          </tr>

          <tr>
            <td>Total Sales</td>
            <td class="text-right"><?= four_decimal($total_sales_amount, '-') ?></td>
            <td class="text-right">-</td>
            <td class="text-right"><?= four_decimal($total_sales_fine, '-'); ?></td>
          </tr>
        </table>
      </div>      
    </div>
  </div>  
</div>
