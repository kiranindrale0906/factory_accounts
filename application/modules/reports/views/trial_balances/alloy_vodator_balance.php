<?php 
  foreach($receipt_types as $receipt_type) {
    foreach($site_names as $site_name) {
      foreach($hostversions as $hostversion) {
?>
    

<div class="col-md-12">
  <div class="form-group container">
    <h5 class="ml-2 pl-2"><?= $receipt_type ?></h5>
    <div class="table-responsive m-t-20">
      <table class="table table-sm fixedthead table-default">
        <thead>
          <tr>
            <th>Stock</th>
            <th class="text-right">Accounts</th>
            <th class="text-right">Accounts Fine</th>
            <th class="text-right">Factory</th>
            <th class="text-right">Factory Fine</th>
            <th class="text-right">Total</th>
            <th class="text-right">Total Fine</th>
          </tr>
        </thead>
        <tr>
          <td><?= $site_name.' '.$hostversion ?></td>
            <td class="text-right"><?= four_decimal($receipt_type[$site_name][$hostversion]['account_vadotar_balance']['balance']) ?></td>
            <td class="text-right"><?= four_decimal($receipt_type[$site_name][$hostversion]['account_vadotar_balance']['balance_fine']) ?></td>
            <td class="text-right"><?= four_decimal($receipt_type[$site_name][$hostversion]['factory_vadotar_records']['balance']) ?></td>
            <td class="text-right"><?= four_decimal($receipt_type[$site_name][$hostversion]['factory_vadotar_records']['balance_fine']) ?></td>
            <td class="text-right"><?= four_decimal($receipt_type[$site_name][$hostversion]['account_vadotar_balance']['balance'] - $receipt_type[$site_name][$hostversion]['factory_vadotar_records']['balance']) ?></td>
            <td class="text-right"><?= four_decimal($receipt_type[$site_name][$hostversion]['factory_vadotar_records']['balance'] - $receipt_type[$site_name][$hostversion]['factory_vadotar_records']['balance_fine']) ?></td>
        </tr>
        
      </table>
    </div>
  </div>
</div>

<?php  
      }
    }
  }
?>
