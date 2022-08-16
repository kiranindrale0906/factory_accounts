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
                $accounts_weight = four_decimal($account_vadotar_balance[$receipt_type][$site_name][$hostversion]['balance']);
                $accounts_fine = four_decimal($account_vadotar_balance[$receipt_type][$site_name][$hostversion]['balance_fine']);
                $factory_weight = four_decimal($factory_vadotar_records[$receipt_type][$site_name][$hostversion]['balance']);
                $factory_fine = four_decimal($factory_vadotar_records[$receipt_type][$site_name][$hostversion]['balance_fine']);
                $balance_diff = $accounts_weight - $factory_weight;
                $balance_fine_diff = $accounts_fine - $factory_fine;
        ?>
                <tr>
                  <td><?= $site_name.' '.$hostversion ?></td>
                    <td><?= $receipt_type ?></td>
                    <td class="text-right"><?= (round($accounts_weight,2)==0) ? '-' : four_decimal($accounts_weight) ?></td>
                    <td class="text-right"><?= (round($accounts_fine,2)==0) ? '-' : four_decimal($accounts_fine) ?></td>
                    <td class="text-right"><?= (round($factory_weight,2)==0) ? '-' : four_decimal($factory_weight) ?></td>
                    <td class="text-right"><?= (round($factory_fine,2)==0) ? '-' : four_decimal($factory_fine) ?></td>
                    <td class="text-right"><?= (round($balance_diff,2)==0) ? '-' : four_decimal($balance_diff) ?></td>
                    <td class="text-right"><?= (round($balance_fine_diff,2)==0) ? '-' : four_decimal($balance_fine_diff) ?></td>
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

