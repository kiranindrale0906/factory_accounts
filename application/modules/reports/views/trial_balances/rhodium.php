<hr />
<h5 class="ml-2 pl-2">Rodium</h5>

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
            <td>Dip R/d Purchase</td>
            <td class="text-right"><?= four_decimal($rhodium['Dip R/d']['amount'], '-'); ?></td>
            <td class="text-right"><?= four_decimal($rhodium['Dip R/d']['rate'], '-'); ?></td>
            <td class="text-right"><?= four_decimal($rhodium['Dip R/d']['fine'], '-'); ?></td>
          </tr>
          <tr>
            <td>Pen R/d Purchase</td>
            <td class="text-right"><?= four_decimal($rhodium['Pen R/d']['amount'], '-'); ?></td>
            <td class="text-right"><?= four_decimal($rhodium['Pen R/d']['rate'], '-'); ?></td>
            <td class="text-right"><?= four_decimal($rhodium['Pen R/d']['fine'], '-'); ?></td>
          </tr>
          <tr>
            <?php 
              $rhodium_purchase_amount = $rhodium['Dip R/d']['amount'] + $rhodium['Pen R/d']['amount'];
              $rhodium_purchase_fine = $rhodium['Dip R/d']['fine'] + $rhodium['Pen R/d']['fine'];
              $rhodium_purchase_rate = ($rhodium_purchase_fine==0) ? 0 : $rhodium_purchase_amount / $rhodium_purchase_fine; 
            ?>
            <th>Total</th>
            <th class="text-right"><?= four_decimal($rhodium_purchase_amount, '-'); ?></th>
            <th class="text-right"><?= four_decimal($rhodium_purchase_rate, '-'); ?></th>
            <th class="text-right"><?= four_decimal($rhodium_purchase_fine, '-'); ?></th>
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
            <td>Dip R/d Issue</td>
            <td class="text-right"><?= four_decimal($rhodium['Dip R/d Issue']['amount'], '-'); ?></td>
            <td class="text-right"><?= four_decimal($rhodium['Dip R/d Issue']['rate'], '-'); ?></td>
            <td class="text-right"><?= four_decimal($rhodium['Dip R/d Issue']['fine'], '-'); ?></td>
          </tr>
          <tr>
            <td>Pen R/d Issue</td>
            <td class="text-right"><?= four_decimal($rhodium['Pen R/d Issue']['amount'], '-'); ?></td>
            <td class="text-right"><?= four_decimal($rhodium['Pen R/d Issue']['rate'], '-'); ?></td>
            <td class="text-right"><?= four_decimal($rhodium['Pen R/d Issue']['fine'], '-'); ?></td>
          </tr>
          <tr>
            <td>Dip R/d Closing</td>
            <td class="text-right"><?= four_decimal($rhodium['Dip R/d Closing']['amount'], '-'); ?></td>
            <td class="text-right"><?= four_decimal($rhodium['Dip R/d Closing']['rate'], '-'); ?></td>
            <td class="text-right"><?= four_decimal($rhodium['Dip R/d Closing']['fine'], '-'); ?></td>
          </tr>
          <tr>
            <td>Pen R/d Closing</td>
            <td class="text-right"><?= four_decimal($rhodium['Pen R/d Closing']['amount'], '-'); ?></td>
            <td class="text-right"><?= four_decimal($rhodium['Pen R/d Closing']['rate'], '-'); ?></td>
            <td class="text-right"><?= four_decimal($rhodium['Pen R/d Closing']['fine'], '-'); ?></td>
          </tr>
          <tr>
            <?php 
              $rhodium_sale_amount = $rhodium['Dip R/d Issue']['amount'] + $rhodium['Pen R/d Issue']['amount'] 
                                     + $rhodium['Dip R/d Closing']['amount'] + $rhodium['Pen R/d Closing']['amount'];
              $rhodium_sale_fine = $rhodium['Dip R/d Issue']['fine'] + $rhodium['Pen R/d Issue']['fine'] 
                                     + $rhodium['Dip R/d Closing']['fine'] + $rhodium['Pen R/d Closing']['fine'];
              $rhodium_sale_rate = ($rhodium_sale_fine==0) ? 0 : $rhodium_sale_amount / $rhodium_sale_fine; 
            ?>
            <th>Total</th>
            <th class="text-right"><?= four_decimal($rhodium_sale_amount, '-') ?>  </th>
            <th class="text-right"><?= four_decimal($rhodium_sale_rate, '-'); ?>  </th>
            <th class="text-right"><?= four_decimal($rhodium_sale_fine, '-'); ?></th>
          </tr>
        </table>
      </div>      
    </div>
  </div>  
</div>
