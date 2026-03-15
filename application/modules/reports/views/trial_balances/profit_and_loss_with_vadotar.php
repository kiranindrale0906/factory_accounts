<?php 
  $domestic_export_records = array();
  foreach($purchase_sales_account_domestic_export_with_vadotar_records as $domestic_export_record) 
    $domestic_export_records = $domestic_export_record;
//  pd($domestic_export_records);
  $sales_domestic_gold_fine = !empty($domestic_export_records['gold_fine']) ? $domestic_export_records['gold_fine'] : 0;
  $sales_domestic_gold_rate = !empty($domestic_export_records['gold_rate']) ? $domestic_export_records['gold_rate'] : 0;
  $sales_domestic_amount = !empty($domestic_export_records['gold_amount']) ?  $domestic_export_records['gold_amount'] : 0;

  $sales_domestic_vadotar_fine = !empty($domestic_export_records['vadotar_fine']) ?  $domestic_export_records['vadotar_fine'] : 0;
  $sales_domestic_vadotar_amount = !empty($domestic_export_records['vadotar_amount']) ?  $domestic_export_records['vadotar_amount'] : 0;
  $sales_domestic_vadotar_rate = !empty($domestic_export_records['vadotar_rate']) ? $domestic_export_records['vadotar_rate'] : 0;
?>

<?php
?>

<hr />
<h5 class="ml-2 pl-2">Profit and Loss Account</h5>

<div class="row">
<form class="col-12 fields-group-sm">
</form>
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
            <td class="text-right"><?= four_decimal(@$domestic_opening_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal(@$domestic_opening_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal(@$domestic_opening_fine, '-'); ?></td>
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
            <td>Domestic Gold Sale</td>
            <td class="text-right"><?= four_decimal($sales_domestic_amount) ?>  </td>
            <td class="text-right"><?= four_decimal($sales_domestic_gold_rate); ?>  </td>
            <td class="text-right"><?= four_decimal($sales_domestic_gold_fine, '-'); ?></td>
          </tr>
          <tr>
            <td>Domestic Vadotar Sale</td>
            <td class="text-right"><?= four_decimal($sales_domestic_vadotar_amount, '-') ?>  </td>
            <td class="text-right"><?= four_decimal($sales_domestic_vadotar_rate, '-'); ?>  </td>
            <td class="text-right"><?= four_decimal($sales_domestic_vadotar_fine, '-'); ?></td>
          </tr>
        </table>
      </div>      
    </div>
  </div>  
</div>
