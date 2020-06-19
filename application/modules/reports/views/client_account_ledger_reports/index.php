<br>
 <div class="boxrow mb-2">
    <div class="float-left">
     <h6 class="heading blue bold text-uppercase mb-0"><?= @getTableSettings()['page_title']; ?></h6>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group container">
        <div>
          <?php load_field('dropdown', array('field'=>'company_id','option' => $company_names ,'class'=>"onchange_trial_balance_comapny_name")); ?>
        </div>
        <div class="table-responsive m-t-20">
          <table class="table table-sm fixedthead table-default">
            <thead>
              <tr>
                <th>Account Name</th>
                <th class="text-right">Receipt Weight</th>
                <th class="text-right">Issue Weight</th>
                <th class="text-right">Receipt Fine</th>
                <th class="text-right">Issue Fine</th>
                <th class="text-right">Factory Receipt Fine</th>
                <th class="text-right">Factory Issue Fine</th>
                <th class="text-right">Vadotar</th>
              </tr>
            </thead>
            <?php 
                $total_weight_receipt = 0;
                $total_weight_issue = 0;
                $total_fine_receipt = 0;  
                $total_fine_issue = 0;  
                $total_factory_fine_receipt = 0;  
                $total_factory_fine_issue = 0;  
                $total_different = 0;  
                if(!empty($trial_balance)) {
                  foreach ($trial_balance as $record) {
                    $total_different = $total_different + $record['different'];
                    if($record['receipt_weight'] > 0)
                      $total_weight_receipt = $total_weight_receipt + $record['receipt_weight'];
                    else 
                      $total_weight_issue = $total_weight_issue + $record['receipt_weight'];

                    if($record['fine'] > 0)
                      $total_fine_receipt = $total_fine_receipt + $record['fine'];
                    else 
                      $total_fine_issue = $total_fine_issue + $record['fine'];

                    if($record['factory_fine'] > 0)
                      $total_factory_fine_receipt = $total_factory_fine_receipt + $record['factory_fine'];
                    else 
                      $total_factory_fine_issue = $total_factory_fine_issue + $record['factory_fine'];
                    ?>

                    <tr>
                      <td><?= $record['account_name']; ?></td>
                      <td class="text-right"><?= ($record['receipt_weight'] > 0) ? $record['receipt_weight'] : '-'; ?></td>
                      <td class="text-right"><?= ($record['receipt_weight'] < 0) ? four_decimal($record['receipt_weight']*-1) : '-'; ?></td>
                      <td class="text-right"><?= ($record['fine'] > 0) ? four_decimal($record['fine']) : '-'; ?></td>
                      <td class="text-right"><?= ($record['fine'] < 0) ? four_decimal($record['fine']*-1) : '-'; ?></td>
                      <td class="text-right"><?= ($record['factory_fine'] > 0) ? four_decimal($record['factory_fine']) : '-';?></td>
                      <td class="text-right"><?= ($record['factory_fine'] < 0) ? four_decimal($record['factory_fine'] * -1) : '-';?></td>
                      <td class="text-right"><?= ($record['different'] != 0) ? four_decimal($record['different']) : '-'?>  </td>
                    </tr>
                  <?php }
                } 
            ?>
            <tr>
              <th>Trial Balance Total</th>
              <th class="text-right"><?= four_decimal($total_weight_receipt); ?></th>
              <th class="text-right"><?= four_decimal($total_weight_issue * -1); ?></th>
              <th class="text-right"><?= four_decimal($total_fine_receipt); ?></th>          
              <th class="text-right"><?= four_decimal($total_fine_issue * -1); ?></th>
              <th class="text-right"><?= four_decimal($total_factory_fine_receipt); ?></th>
              <th class="text-right"><?= four_decimal($total_factory_fine_issue * -1); ?></th>
              <th class="text-right"></th>
            </tr>

            <tr>
              <?php
                $cs_total_weight_receipt = 0;
                $cs_total_weight_issue = 0;
                $cs_total_fine_receipt = 0;
                $cs_total_fine_issue = 0;
                $cs_total_factory_fine_receipt = 0;
                $cs_total_factory_fine_issue = 0;

                if ($total_weight_receipt > $total_weight_issue)               
                  $cs_total_weight_issue = $total_weight_receipt - ($total_weight_issue * -1);
                else
                  $cs_total_weight_receipt = ($total_weight_issue * -1) - $total_weight_receipt;

                if ($total_fine_receipt > $total_fine_issue)               
                  $cs_total_fine_issue = $total_fine_receipt - ($total_fine_issue * -1);
                else
                  $cs_total_fine_receipt = ($total_fine_issue * -1) - $total_fine_receipt;

                if ($total_factory_fine_receipt > $total_factory_fine_issue)               
                  $cs_total_factory_fine_issue = $total_factory_fine_receipt - ($total_factory_fine_issue * -1);
                else
                  $cs_total_factory_fine_receipt = ($total_factory_fine_issue * -1) - $total_factory_fine_receipt;

                $cs_total_different_balance = $total_different;
              ?>
              <th>Closing Stock</th>
              <th class="text-right">
                <?= four_decimal($cs_total_weight_receipt); ?>  
              </th>
              <th class="text-right">
                <?= four_decimal($cs_total_weight_issue); ?>
              </th>
              <th class="text-right">
                <?= four_decimal($cs_total_fine_receipt); ?>  
              </th>
              <th class="text-right">
                <?= four_decimal($cs_total_fine_issue); ?>  
              </th>
              <th class="text-right">
                <?= four_decimal($cs_total_factory_fine_receipt); ?>
              </th>
              <th class="text-right">
                <?= four_decimal($cs_total_factory_fine_issue); ?>
              </th>
              <th><?=four_decimal($total_different);?></th>
            </tr>
            <th>Total</th>
              <th class="text-right">
                <?= four_decimal($total_weight_receipt + $cs_total_weight_receipt); ?>  
              </th>
              <th class="text-right">
                <?= four_decimal($total_weight_issue * -1 + $cs_total_weight_issue); ?>
              </th>
              <th class="text-right">
                <?= four_decimal($total_fine_receipt + $cs_total_fine_receipt); ?>  
              </th>
              <th class="text-right">
                <?= four_decimal($total_fine_issue * -1 + $cs_total_fine_issue); ?>  
              </th>
              <th class="text-right">
                <?= four_decimal($total_factory_fine_receipt + $cs_total_factory_fine_receipt); ?>
              </th>
              <th class="text-right">
                <?= four_decimal($total_factory_fine_issue * -1 + $cs_total_factory_fine_issue); ?>
              </th>
              <th><?=four_decimal($total_different);?></th>
            </tr>

            <th>Balance</th>
              <th class="text-right">-</th>
              <th class="text-right">-</th>
              <th class="text-right">-</th>
              <th class="text-right">-</th>
              <th class="text-right">-</th>
              <th class="text-right"><?= ($total_different < 0) ? (four_decimal($total_different * -1)) : '-' ;?></th>
              <th><?=four_decimal($total_different);?></th>
            </tr>
          </table>
        </div>
        
      </div>
    </div>
  </div>