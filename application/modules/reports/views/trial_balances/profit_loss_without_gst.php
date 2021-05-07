<?php 
 
 

  $purchase_export_amount = !empty($profit_and_loss['purchase_account_export']['amount']) ? -1 * $profit_and_loss['purchase_account_export']['amount'] : 0;
  $purchase_export_taxable_amount = !empty($profit_and_loss['purchase_account_export']['taxable_amount']) ?  $profit_and_loss['purchase_account_export']['taxable_amount'] : 0;
  $purchase_export_cgst_amount = !empty($profit_and_loss['purchase_account_export']['cgst_amount']) ?  $profit_and_loss['purchase_account_export']['cgst_amount'] : 0;
  $purchase_export_sgst_amount = !empty($profit_and_loss['purchase_account_export']['sgst_amount']) ?  $profit_and_loss['purchase_account_export']['sgst_amount'] : 0;
  $purchase_export_tcs_amount = !empty($profit_and_loss['purchase_account_export']['tcs_amount']) ?  $profit_and_loss['purchase_account_export']['tcs_amount'] : 0;
  $purchase_export_rate = !empty($profit_and_loss['purchase_account_export']['fine']) ? -1 * $profit_and_loss['purchase_account_export']['amount'] / $profit_and_loss['purchase_account_export']['fine'] : 0;

  $purchase_export_fine = !empty($profit_and_loss['purchase_account_export']['fine']) ? $profit_and_loss['purchase_account_export']['fine'] : 0;


  $purchase_domestic_rate = !empty($profit_and_loss['purchase_account_domestic']['fine']) ? -1 * $profit_and_loss['purchase_account_domestic']['amount'] / $profit_and_loss['purchase_account_domestic']['fine'] : 0;
   $purchase_domestic_fine = !empty($profit_and_loss['purchase_account_domestic']['fine']) ? $profit_and_loss['purchase_account_domestic']['fine'] : 0;

  $purchase_domestic_amount = !empty($profit_and_loss['purchase_account_domestic']['amount']) ? -1 * $profit_and_loss['purchase_account_domestic']['amount'] : 0;
  $purchase_domestic_taxable_amount = !empty($profit_and_loss['purchase_account_domestic']['taxable_amount']) ?  $profit_and_loss['purchase_account_domestic']['taxable_amount'] : 0;
  $purchase_domestic_cgst_amount = !empty($profit_and_loss['purchase_account_domestic']['cgst_amount']) ?  $profit_and_loss['purchase_account_domestic']['cgst_amount'] : 0;
  $purchase_domestic_sgst_amount = !empty($profit_and_loss['purchase_account_domestic']['sgst_amount']) ?  $profit_and_loss['purchase_account_domestic']['sgst_amount'] : 0;
  $purchase_domestic_tcs_amount = !empty($profit_and_loss['purchase_account_domestic']['tcs_amount']) ?  $profit_and_loss['purchase_account_domestic']['tcs_amount'] : 0;



  $main_vadotar_fine = @$profit_and_loss['main_vadotar']['fine'];
  $main_vadotar_amount = $main_vadotar_rate = 0;

  $pending_vadotar_fine = -1 * $profit_and_loss['pending_vadotar'];
  $pending_vadotar_amount = $pending_vadotar_rate = 0;

  $sales_fine = !empty($profit_and_loss['sales_account']['fine']) ? -1 * $profit_and_loss['sales_account']['fine'] : 0;
  $sales_rate = !empty($profit_and_loss['sales_account']['fine']) ? (-1 * $profit_and_loss['sales_account']['amount'] / $profit_and_loss['sales_account']['fine']) : 0;
  $sales_amount = !empty($profit_and_loss['sales_account']['amount']) ? $profit_and_loss['sales_account']['amount'] : 0;

  $closing_fine = $purchase_export_fine +$purchase_domestic_fine + $main_vadotar_fine + $pending_vadotar_fine - $sales_fine;
  $closing_rate = $gold_rate / .995 / 10;
  $closing_amount = $closing_fine * $closing_rate;

  $total_sales_with_closing_amount = $sales_amount + $closing_amount;
  $total_sales_with_closing_fine = $sales_fine + $closing_fine;
  $total_sales_with_closing_rate = !empty($total_sales_with_closing_fine)?$total_sales_with_closing_amount / $total_sales_with_closing_fine:0;

  $exchange_gain_loss_fine = $total_sales_with_closing_fine;
  $exchange_gain_loss_rate = ($purchase_export_rate + $purchase_domestic_rate) - $total_sales_with_closing_rate;
  $exchange_gain_loss_amount = $exchange_gain_loss_fine * $exchange_gain_loss_rate;

  $total_income_amount = $sales_amount + $closing_amount + $exchange_gain_loss_amount;
  $total_income_fine = $total_sales_with_closing_fine;
  $total_income_rate = !empty($total_income_fine)?$total_income_amount / $total_income_fine:0;

  $gross_profit_fine = 0;
  $gross_profit_rate = 0;
  $gross_profit_amount = $total_income_amount - ($purchase_export_rate + $purchase_domestic_rate);

  $total_expenses_amount = $purchase_export_amount +$purchase_domestic_amount +$purchase_export_taxable_amount +$purchase_domestic_taxable_amount +$purchase_export_cgst_amount +$purchase_domestic_cgst_amount +$purchase_export_sgst_amount +$purchase_domestic_sgst_amount +$purchase_export_tcs_amount +$purchase_domestic_tcs_amount + $gross_profit_amount;
  $total_expenses_fine = $purchase_export_fine +$purchase_domestic_fine + $main_vadotar_fine + $pending_vadotar_fine;
  $total_expenses_rate = 0;
?>

<hr />
<h5 class="ml-2 pl-2">GST</h5>

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
            <td>PURCHASE ACCOUNT DOMESTIC</td>
            <td class="text-right"><?= four_decimal($purchase_domestic_amount, '-') ?></td>
            <td class="text-right"><?= four_decimal($purchase_domestic_rate, '-'); ?></td>
            <td class="text-right"><?= four_decimal($purchase_domestic_fine, '-'); ?></td>
          </tr>
           <tr>
            <td>PURCHASE DOMESTIC TAXABLE</td>
            <td class="text-right"><?= four_decimal($purchase_domestic_taxable_amount, '-') ?></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
          </tr>
           <tr>
            <td>PURCHASE DOMESTIC CGST</td>
            <td class="text-right"><?= four_decimal($purchase_domestic_cgst_amount, '-') ?></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
          </tr>
          <tr>
            <td>PURCHASE DOMESTIC SGST</td>
             <td class="text-right"><?= four_decimal($purchase_domestic_sgst_amount, '-') ?></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
          </tr>
          <tr>
            <td>PURCHASE DOMESTIC TCS</td>
             <td class="text-right"><?= four_decimal($purchase_domestic_tcs_amount, '-') ?></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
          </tr>
          <tr>
            <td>PURCHASE ACCOUNT EXPORT</td>
            <td class="text-right"><?= four_decimal($purchase_export_amount, '-') ?></td>
            <td class="text-right"><?= four_decimal($purchase_export_rate, '-'); ?></td>
            <td class="text-right"><?= four_decimal($purchase_export_fine, '-'); ?></td>
          </tr>
           <tr>
            <td>PURCHASE EXPORT TAXABLE</td>
            <td class="text-right"><?= four_decimal($purchase_export_taxable_amount, '-') ?></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
          </tr>
           <tr>
            <td>PURCHASE EXPORT CGST</td>
            <td class="text-right"><?= four_decimal($purchase_export_cgst_amount, '-') ?></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
          </tr>
          <tr>
            <td>PURCHASE EXPORT SGST</td>
            <td class="text-right"><?= four_decimal($purchase_export_sgst_amount, '-') ?></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
          </tr>
          <tr>
            <td>PURCHASE EXPORT TCS</td>
            <td class="text-right"><?= four_decimal($purchase_export_tcs_amount, '-') ?></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
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
            <td>SALES ACCOUNT</td>
            <td class="text-right"><?= four_decimal($sales_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($sales_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($sales_fine, '-'); ?></td>
          </tr>
          <tr>
            <td>Closing Stock</td>
            <td class="text-right"><?= four_decimal($closing_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($closing_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($closing_fine, '-'); ?></td>
          </tr>
           <tr>
            <th>Sales and Closing</th>
            <th class="text-right"><?= four_decimal($total_sales_with_closing_amount, '-') ?>  </th>
            <th class="text-right"><?= four_decimal($total_sales_with_closing_rate, '-'); ?>  </th>
            <th class="text-right"><?= four_decimal($total_sales_with_closing_fine, '-'); ?></th>
          </tr>
          <tr>
            <td>Exchange Gain / Loss</td>
            <td class="text-right"><?= four_decimal($exchange_gain_loss_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($exchange_gain_loss_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($exchange_gain_loss_fine, '-'); ?></td>
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