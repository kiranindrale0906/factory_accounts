<div class="col-md-12">
  <div class="form-group container">
    <h5 class="ml-2 pl-2"></h5>
    <div class="table-responsive m-t-20">
      <table class="table table-sm fixedthead table-default">
        <thead>
          <tr>
            <th>Stock</th>
            <th>Type</th>
            <th class="text-right">Accounts</th>
            <th class="text-right">Accounts Fine</th>
            <th class="text-right">Factory</th>
            <th class="text-right">Factory Fine</th>
            <th class="text-right">Total</th>
            <th class="text-right">Total Fine</th>
          </tr>
        </thead>
        <?php 
          foreach($receipt_types as $receipt_type) {
            foreach($site_names as $site_name) {
              foreach($hostversions as $hostversion) {
                $balance_diff = $account_vadotar_balance[$receipt_type][$site_name][$hostversion]['balance'] - $factory_vadotar_records[$receipt_type][$site_name][$hostversion]['balance'];
                $balance_fine_diff = $factory_vadotar_records[$receipt_type][$site_name][$hostversion]['balance'] - $account_vadotar_balance[$receipt_type][$site_name][$hostversion]['balance'];
        ?>
                <tr>
                  <td><?= $site_name.' '.$hostversion ?></td>
                    <td><?= $receipt_type ?></td>
                    <td class="text-right"><?= four_decimal($account_vadotar_balance[$receipt_type][$site_name][$hostversion]['balance']) ?></td>
                    <td class="text-right"><?= four_decimal($account_vadotar_balance[$receipt_type][$site_name][$hostversion]['balance_fine']) ?></td>
                    <td class="text-right"><?= four_decimal($factory_vadotar_records[$receipt_type][$site_name][$hostversion]['balance']) ?></td>
                    <td class="text-right"><?= four_decimal($factory_vadotar_records[$receipt_type][$site_name][$hostversion]['balance_fine']) ?></td>
                    <td class="text-right"><?= ($balance_diff==0) ? '-' : four_decimal($balance_diff) ?></td>
                    <td class="text-right"><?= ($balance_fine_diff==0) ? '-' : four_decimal($balance_fine_diff) ?></td>
                </tr>
        <?php  
              }
            }
          }
        ?>
      </table>
    </div>
  </div>
</div>

