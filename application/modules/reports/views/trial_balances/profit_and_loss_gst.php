<?php 
  $purchase_export = $profit_and_loss['purchase_account_export'];
  $purchase_domestic = $profit_and_loss['purchase_account_domestic'];
  $sales = $profit_and_loss['sale_gst_accounts'];

  $debit_note = $sales['cash_amounts'];
  $credit_note = $purchase_domestic['cash_amounts'];

  // $purchase_export_taxable_amount = !empty($profit_and_loss['purchase_account_export']['taxable_amount']) ?  $profit_and_loss['purchase_account_export']['taxable_amount'] : 0;
  // $purchase_export_cgst_amount = !empty($profit_and_loss['purchase_account_export']['cgst_amount']) ?  $profit_and_loss['purchase_account_export']['cgst_amount'] : 0;
  // $purchase_export_sgst_amount = !empty($profit_and_loss['purchase_account_export']['sgst_amount']) ?  $profit_and_loss['purchase_account_export']['sgst_amount'] : 0;
  // $purchase_export_tcs_amount = !empty($profit_and_loss['purchase_account_export']['tcs_amount']) ?  $profit_and_loss['purchase_account_export']['tcs_amount'] : 0;
  
  // $purchase_domestic_cash_amount = !empty($profit_and_loss['purchase_account_domestic']['cash_amount']) ?  $profit_and_loss['purchase_account_domestic']['cash_amount'] : 0;
  // $purchase_domestic_taxable_amount = !empty($profit_and_loss['purchase_account_domestic']['taxable_amount']) ?  $profit_and_loss['purchase_account_domestic']['taxable_amount'] : 0;
  // $purchase_domestic_cgst_amount = !empty($profit_and_loss['purchase_account_domestic']['cgst_amount']) ?  $profit_and_loss['purchase_account_domestic']['cgst_amount'] : 0;
  // $purchase_domestic_sgst_amount = !empty($profit_and_loss['purchase_account_domestic']['sgst_amount']) ?  $profit_and_loss['purchase_account_domestic']['sgst_amount'] : 0;
  // $purchase_domestic_tcs_amount = !empty($profit_and_loss['purchase_account_domestic']['tcs_amount']) ?  $profit_and_loss['purchase_account_domestic']['tcs_amount'] : 0;

  // $sales_cash_amount = !empty($profit_and_loss['sale_gst_accounts']['cash_amount']) ? $profit_and_loss['sale_gst_accounts']['cash_amount'] : 0;
  // $sales_taxable_amount = !empty($profit_and_loss['sale_gst_accounts']['taxable_amount']) ? $profit_and_loss['sale_gst_accounts']['taxable_amount'] : 0;
  // $sales_cgst_amount = !empty($profit_and_loss['sale_gst_accounts']['cgst_amount']) ? $profit_and_loss['sale_gst_accounts']['cgst_amount'] : 0;
  // $sales_sgst_amount = !empty($profit_and_loss['sale_gst_accounts']['sgst_amount']) ? $profit_and_loss['sale_gst_accounts']['sgst_amount'] : 0;
  // $sales_tcs_amount = !empty($profit_and_loss['sale_gst_accounts']['tcs_amount']) ? $profit_and_loss['sale_gst_accounts']['tcs_amount'] : 0;

  
  $total_income_amount =   $debit_note['taxable_amount']
                         + $debit_note['cgst_amount'] + $debit_note['sgst_amount']
                         + $debit_note['tcs_amount']
                         + $sales['taxable_amount']
                         + $sales['cgst_amount'] + $sales['sgst_amount']
                         + $sales['tcs_amount'];
  
  $total_expenses_amount =   $credit_note['taxable_amount']
                           + $credit_note['cgst_amount'] + $credit_note['sgst_amount']
                           + $credit_note['tcs_amount']
                           + $purchase_export['taxable_amount'] + $purchase_domestic['taxable_amount']
                           + $purchase_export['cgst_amount'] + $purchase_domestic['cgst_amount']
                           + $purchase_export['sgst_amount'] + $purchase_domestic['sgst_amount']
                           + $purchase_export['tcs_amount'] + $purchase_domestic['tcs_amount'];
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
              <th>PURCHASE</th>
              <th class="text-right">Amount</th>
            </tr>
          </thead>

          <tr>
            <td>CREDIT NOTE TAXABLE</td>
            <td class="text-right"><?= four_decimal($credit_note['taxable_amount'], '-') ?></td>
          </tr>
          <tr>
            <td>CREDIT NOTE CGST</td>
            <td class="text-right"><?= four_decimal($credit_note['cgst_amount'], '-') ?></td>
          </tr>
          <tr>
            <td>CREDIT NOTE SGST</td>
            <td class="text-right"><?= four_decimal($credit_note['sgst_amount'], '-') ?></td>
          </tr>
          <tr>
            <td>CREDIT NOTE TCS</td>
            <td class="text-right"><?= four_decimal($credit_note['tcs_amount'], '-') ?></td>
          </tr>
          <tr>
            <td>PURCHASE DOMESTIC TAXABLE</td>
            <td class="text-right"><?= four_decimal($purchase_domestic['taxable_amount'], '-') ?></td>
          </tr>
          <tr>
            <td>PURCHASE DOMESTIC CGST</td>
            <td class="text-right"><?= four_decimal($purchase_domestic['cgst_amount'], '-') ?></td>            
          </tr>
          <tr>
            <td>PURCHASE DOMESTIC SGST</td>
              <td class="text-right"><?= four_decimal($purchase_domestic['sgst_amount'], '-') ?></td>
          </tr>
          <tr>
            <td>PURCHASE DOMESTIC TCS</td>
             <td class="text-right"><?= four_decimal($purchase_domestic['tcs_amount'], '-') ?></td>
          </tr>
          
          <tr>
            <td>PURCHASE EXPORT TAXABLE</td>
            <td class="text-right"><?= four_decimal($purchase_export['taxable_amount'], '-') ?></td>
          </tr>
           <tr>
            <td>PURCHASE EXPORT CGST</td>
            <td class="text-right"><?= four_decimal($purchase_export['cgst_amount'], '-') ?></td>
          </tr>
          <tr>
            <td>PURCHASE EXPORT SGST</td>
            <td class="text-right"><?= four_decimal($purchase_export['sgst_amount'], '-') ?></td>
          </tr>
          <tr>
            <td>PURCHASE EXPORT TCS</td>
            <td class="text-right"><?= four_decimal($purchase_export['tcs_amount'], '-') ?></td>
          </tr>
          <tr>
            <th>TOTAL</th>
            <th class="text-right"><?= four_decimal($total_expenses_amount, '-') ?></th>
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
              <th>SALES</th>
              <th class="text-right">Amount</th>
            </tr>
          </thead>
          <tr>
            <td>DEBIT NOTE TAXABLE</td>
            <td class="text-right"><?= four_decimal($debit_note['taxable_amount'], '-') ?>  </td>
          </tr>
          <tr>
            <td>CREDIT NOTE CGST</td>
            <td class="text-right"><?= four_decimal($debit_note['cgst_amount'], '-') ?></td>
          </tr>
          <tr>
            <td>CREDIT NOTE SGST</td>
            <td class="text-right"><?= four_decimal($debit_note['sgst_amount'], '-') ?></td>
          </tr>
          <tr>
            <td>CREDIT NOTE TCS</td>
            <td class="text-right"><?= four_decimal($debit_note['tcs_amount'], '-') ?></td>
          </tr>
          <tr>
            <td>SALES ACCOUNT TAXABLE</td>
            <td class="text-right"><?= four_decimal($sales['taxable_amount'], '-') ?>  </td>
          </tr>
          <tr>
            <td>SALES ACCOUNT CGST</td>
            <td class="text-right"><?= four_decimal($sales['cgst_amount'], '-') ?>  </td>
          </tr>
          <tr>
            <td>SALES ACCOUNT SGST</td>
            <td class="text-right"><?= four_decimal($sales['sgst_amount'], '-') ?>  </td>
          </tr>
          <tr>
            <td>SALES ACCOUNT TCS</td>
            <td class="text-right"><?= four_decimal($sales['tcs_amount'], '-') ?>  </td>
          </tr>
          <tr>
            <th>TOTAL</th>
            <th class="text-right"><?= four_decimal($total_income_amount, '-') ?></th>
          </tr>
        </table>
      </div>      
    </div>
  </div>  
</div>