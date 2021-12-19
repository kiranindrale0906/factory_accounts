
  <h6 class="heading blue bold text-uppercase mb-0">Loss Reports</h6>
  <hr>
<div class="row"> 
  <div class="col-md-6">
    <div class="form-group container"> 
      <h5> Select Factory:
        <?php 
        $all_companies = array('AR Gold','ARF','ARC');
          $companies=array_merge($all_companies);
          foreach ($companies as $index => $company) { ?>
            <a class="ml-5 <?= ($site_name== $company) ? 'bold black underline' : '' ?>" 
               href='<?= base_url().'reports/quator_wise_loss_reports' ?>?account_id=<?= $account_id ?>&site_name=<?= $company?>&quator=<?= $quator_name?>'><?= $company ?></a>
          <?php }
        ?>
      </h5>
    </div>
    <div class="form-group container"> 
      <h5> Select Quator:
        <?php
          foreach ($quators as $index => $quator) { ?>
            <a class="ml-5 <?= ($quator_name== $quator) ? 'bold black underline' : '' ?>" 
               href='<?= base_url().'reports/quator_wise_loss_reports' ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&quator=<?= $quator['name']?>'><?= $quator['name'].' ('.date('d-m-Y',strtotime($quator['from_date'])).' to '.date('d-m-Y',strtotime($quator['to_date'])).')' ?></a>
          <?php }
        ?>
      </h5>
    </div>
  </div>
  
</div>  
<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th class="">Type of Loss</th>
        <th class="text-right">Fine Loss</th>
        <th class="text-right">Total Out Weight</th>
        <th class="text-right">Per Kg Loss</th>
        <th class="text-right">Metal Receive After Recovery</th>
        <th class="text-right">Recovered Loss</th>
        <th class="text-right">Per Kg Loss After Recovery</th>
        <th class="text-right">Unrecoverable Loss</th>
        <th class="text-right">Balance Loss</th>
        <th class="text-right">% Recovered</th>
        </tr>
    </thead>
    <tbody>
    <?php 
      $sum_loss_fine=$total_unrecover_loss_vatav=$total_loss=$liabilities_total=$assets_total=$sum_after_recovery_loss=$sum_per_kg_loss=$sum_after_recoverd_loss_fine=$sum_before_recovery_loss=$sum_recoverd_loss_fine=$sum_out_weight=$sum_fine=$sum_unrecoverable_loss=$sum_balance=$sum_out_weight=0;
     foreach ($loss_categories as $index => $loss_category) {
      $sum_loss_fine+=four_decimal($loss_category['loss_fine']);
      $sum_after_recoverd_loss_fine+=four_decimal($loss_category['after_recovered_loss']);
      $sum_out_weight+=four_decimal($loss_category['out_weight']);
      $sum_per_kg_loss+=!empty($loss_category['out_weight'])?four_decimal(($loss_category['loss_fine']/$loss_category['out_weight']*1000)):0;

      $sum_before_recovery_loss+=!empty($loss_category['out_weight'])?four_decimal(($loss_category['loss_fine']/$loss_category['out_weight']*100)):0;
      $sum_recoverd_loss_fine+=four_decimal($loss_category['recoverd_loss_fine']);
      $sum_after_recovery_loss+=!empty($loss_category['out_weight'])?four_decimal((($loss_category['loss_fine']-$loss_category['recoverd_loss_fine'])/$loss_category['out_weight']*1000)):0;
      $sum_unrecoverable_loss+=four_decimal($loss_category['unrecoverable_loss']);
      $sum_balance+=four_decimal($loss_category['balance']);
      ?>
      <tr>
        <td class=""><a href="<?=base_url()?>reports/quator_wise_loss_report_details?category=<?=$index ?>&quator=<?=$quator_name ?>&factory_name=<?=$factory_name ?>"><?=$index?></a></td>
        <td class="text-right"><?=!empty($loss_category['loss_fine'])?four_decimal($loss_category['loss_fine']):'-'?></td>
        <td class="text-right"><?=!empty($loss_category['out_weight'])?four_decimal($loss_category['out_weight']):'-';?></td>
        <td class="text-right"><?=!empty($loss_category['out_weight'])?four_decimal(($loss_category['loss_fine']/$loss_category['out_weight']*1000)):'-';?></td>
        <td class="text-right"><?=!empty($loss_category['after_recovered_loss'])?four_decimal($loss_category['after_recovered_loss']):'-';?></td>
        <td class="text-right"><?=!empty($loss_category['recoverd_loss_fine'])?four_decimal($loss_category['recoverd_loss_fine']):'-';?></td>
        <td class="text-right"><?=!empty($loss_category['out_weight'])?four_decimal((($loss_category['loss_fine']-$loss_category['recoverd_loss_fine'])/$loss_category['out_weight']*1000)):'-';?></td>
         
        <td class="text-right"><?=!empty($loss_category['unrecoverable_loss'])?four_decimal($loss_category['unrecoverable_loss']):'-'; ?></td>
        <td class="text-right"><?=!empty($loss_category['balance'])?four_decimal($loss_category['balance']):'-'; ?></td>
        <td class="text-right"><?=(!empty($loss_category['loss_fine'])&&!empty($loss_category['after_recovered_loss']))?four_decimal(($loss_category['after_recovered_loss']/$loss_category['loss_fine']*100)):'-';?></td>
       
      </tr>
    <?php }?>
      <tr class="bg_gray bold">
    <td>Total</td>
    <td class="text-right"><?=four_decimal($sum_loss_fine)?></td>
    <td class="text-right"><?=four_decimal($sum_out_weight)?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_after_recoverd_loss_fine)?></td>
    <td class="text-right"><?=four_decimal($sum_recoverd_loss_fine)?></td>
    <td class="text-right"><?=!empty($sum_out_weight)?four_decimal(($sum_loss_fine-$sum_recoverd_loss_fine)/$sum_out_weight*1000):'-'?></td>
    <td class="text-right"><?=four_decimal($sum_unrecoverable_loss)?></td>
    <td class="text-right"><?=four_decimal($sum_balance)?></td>
    <td class="text-right"><?=$recovered_per=!empty($sum_loss_fine)?four_decimal($sum_after_recoverd_loss_fine/$sum_loss_fine*100):'-'?></td>
  </tr>
    </tbody>
  </table>
</div>
<h6 class="heading blue bold text-uppercase mb-0">Loss Account Details</h6>
<hr>
<div class="row">
  <div class="col-md-6">
    <div class="form-group container">
      <div class="table-responsive">
        <table class="table table-sm fixedthead table-default">
          <thead>
            <tr>
              <th>Liabilities</th>
              <th class="text-right">Amount</th>
              <th class="text-right">Usd Amount</th>
              <th class="text-right">Fine</th>
              <th class="text-right">Vadotar</th>
            </tr>
          </thead>
          <?php
              $liabilities_fine = 0; 
              $liabilities_vadotar = 0;  
              $liabilities_amount = 0;
              $liabilities_usd_amount = 0;

              if(!empty($loss_account_records)) {
                foreach ($loss_account_records as $record) {
                  if (  ($record['fine'] >= 0
                         && $record['account_name'] != 'Tounch Loss Fine')
                      || ($record['account_name'] == 'VADOTAR')) continue;

                  if ($record['account_name'] == 'SALES ACCOUNT') $profit_and_loss['sales_account'] = $record;
                  if (!empty($sales_accounts)) $profit_and_loss['sale_gst_accounts'] = $sales_accounts;

                  $liabilities_vadotar = $liabilities_vadotar + $record['vadotar'];
                  $liabilities_fine = $liabilities_fine + $record['fine']; 
                  $liabilities_amount = $liabilities_amount + $record['amount']; 
                  $liabilities_usd_amount = $liabilities_usd_amount + @$record['usd_amount']; 
                  $gpc_vodator_fine=0;
                  if(round($record['fine'],2)!=0){

                    if($record['account_name']=="AR Gold GPC Vodator"){
                      $gpc_vodator_fine=four_decimal((-1 * $record['fine']), '-');
                    }

                  ?>

                  <tr>
                    <td><?= $record['account_name']; ?></td>
                    <td class="text-right"><?= four_decimal((-1 * $record['amount']), '-') ?>  </td>
                    <td class="text-right"><?= four_decimal((-1 * @$record['usd_amount']), '-') ?>  </td>
                    <td class="text-right"><?= four_decimal((-1 * $record['fine']), '-'); ?></td>
                    <td class="text-right"><?= four_decimal((-1 * $record['vadotar']), '-') ?>  </td>
                  </tr>
                <?php }}
              } 
          ?>
          <tr>
            <th>Total</th>
            <th class="text-right"><?= four_decimal(-1 * $liabilities_amount, '-'); ?></th>
            <th class="text-right"><?= four_decimal(-1 * $liabilities_usd_amount, '-'); ?></th>
            <th class="text-right"><?= $liabilities_total=four_decimal(-1 * $liabilities_fine, '0'); ?></th>          
            <th class="text-right"><?= four_decimal(-1 * $liabilities_vadotar, '-'); ?></th>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group container">
      <div class="table-responsive">
        <table class="table table-sm fixedthead table-default">
          <thead>
            <tr>
              <th>Assets</th>
              <th class="text-right">Amount</th>
              <th class="text-right">Usd Amount</th>
              <th class="text-right">Fine</th>
              <th class="text-right">Vadotar</th>
            </tr>
          </thead>
          <?php 
              $assets_fine = 0;  
              $assets_vadotar = 0;  
              $assets_amount = 0;  
              $assets_usd_amount = 0;  
              if(!empty($loss_account_records)) {
                foreach ($loss_account_records as $record) {
                  if (   ($record['fine'] <= 0
                          && $record['account_name'] != 'VADOTAR')
                      || ($record['account_name'] == 'Tounch Loss Fine')) continue;

                  if ($record['account_name'] == 'PURCHASE ACCOUNT') $profit_and_loss['purchase_account'] = $record;
                  if ($record['account_name'] == 'MAIN VADOTAR')     $profit_and_loss['main_vadotar'] = $record;
                    
                  $assets_vadotar = $assets_vadotar + $record['vadotar'];
                  $assets_fine = $assets_fine + $record['fine'];
                  $assets_amount= $assets_amount + $record['amount'];
                  $assets_usd_amount= $assets_usd_amount + @$record['usd_amount'];
                  $gpc_powder_fine=0;
                  if(round($record['fine'],2)!=0){
                    if(in_array($record['account_name'], array("GPC Powder ARC","GPC Powder ARF","GPC Powder AR Gold"))){
                      $gpc_powder_fine=four_decimal(($record['fine']), '-');
                    }
                   ?>

                  <tr>
                    <td><?= $record['account_name']; ?></td>
                    <td class="text-right"><?= four_decimal($record['amount'], '-') ?>  </td>
                    <td class="text-right"><?= four_decimal(@$record['usd_amount'], '-') ?>  </td>
                    <td class="text-right"><?= four_decimal($record['fine'], '-') ?></td>
                    <td class="text-right"><?= four_decimal($record['vadotar'], '-') ?>  </td>
                  </tr>
                <?php }
                }
              } 
          ?>
          <tr>
            <th>Total</th>
            <th class="text-right"><?= four_decimal($assets_amount, '-'); ?></th>          
            <th class="text-right"><?= four_decimal($assets_usd_amount, '-'); ?></th>          
            <th class="text-right"><?=$assets_total= four_decimal($assets_fine, '0'); ?></th>          
            <th class="text-right"><?= four_decimal($assets_vadotar, '-'); ?></th>
          </tr>
          </table>
        </div> 
    </div>
  </div>  
</div>
<div class="row">
  <div class="col-md-6">
    <h6 class="heading blue bold text-uppercase mb-0">Total Per Kg Loss with Vatav</h6>
  <hr>
    <div class="form-group container">
      <div class="table-responsive">          
        <table class="table table-sm fixedthead table-default">
          <tr class="bold">
            <td>Total Loss</td>
            <td class="text-right"><?=$total_loss=four_decimal($assets_total-$liabilities_total); ?></td>
          </tr>
          <tr>
            <td>Total Fine Loss</td>
            <td class="text-right"><?= four_decimal($sum_loss_fine)?></td>
          </tr> 
          <tr>
            <td>Total Fine Loss Recovered</td>
            <td class="text-right"><?= four_decimal($sum_recoverd_loss_fine)?></td>
          </tr>
          <tr>
            <td>Recovery%</td>
            <td class="text-right"><?= four_decimal($recovered_per) ?>  </td>
          </tr>
          <tr>
            <td>Total Unrecoverable Loss with vatav and Other Loss</td>
            <td class="text-right"><?= $total_unrecover_loss_vatav=four_decimal($sum_unrecoverable_loss+$total_loss); ?></td>
          </tr>
          <tr>
            <td>Work</td>
            <td class="text-right"><?=$work=!empty($work_details)?abs(four_decimal($work_details['amount'])):0; ?></td>
          </tr>
          <tr>
            <td>Per Kg Loss</td>
            <td class="text-right"><?=($work!=0)?four_decimal($total_unrecover_loss_vatav/$work):0 ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <h6 class="heading blue bold text-uppercase mb-0">Total Per Kg Loss without Vatav</h6>
  <hr>
    <div class="form-group container">
      <div class="table-responsive">          
        <table class="table table-sm fixedthead table-default">
          <tr class="bold">
            <td>Total Loss</td>
            <td class="text-right"><?=$without_total_loss=four_decimal($gpc_vodator_fine); ?></td>
          </tr>
          <tr>
            <td>Total Fine Loss</td>
            <td class="text-right"><?= four_decimal($sum_loss_fine)?></td>
          </tr> 
          <tr>
            <td>Total Fine Loss Recovered</td>
            <td class="text-right"><?= four_decimal($sum_recoverd_loss_fine)?></td>
          </tr>
          <tr>
            <td>Recovery%</td>
            <td class="text-right"><?= four_decimal($recovered_per) ?>  </td>
          </tr>
          <tr>
            <td>Total Unrecoverable Loss with vatav and Other Loss</td>
            <td class="text-right"><?= $total_unrecover_loss_vatav=four_decimal($sum_unrecoverable_loss+$without_total_loss); ?></td>
          </tr>
          <tr>
            <td>Work</td>
            <td class="text-right"><?=$work=!empty($work_details)?abs(four_decimal($work_details['amount'])):0; ?></td>
          </tr>
          <tr>
            <td>Per Kg Loss</td>
            <td class="text-right"><?=($work!=0)?four_decimal($total_unrecover_loss_vatav/$work):0 ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>