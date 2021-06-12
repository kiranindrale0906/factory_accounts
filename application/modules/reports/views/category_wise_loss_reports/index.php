<?php 
  $url = 'reports/loss_reports';
?>
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
               href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $company?>'><?= $company ?></a>
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
      $sum_loss_fine=$sum_after_recovery_loss=$sum_per_kg_loss=$sum_after_recoverd_loss_fine=$sum_before_recovery_loss=$sum_recoverd_loss_fine=$sum_out_weight=$sum_fine=$sum_unrecoverable_loss=$sum_balance=$sum_out_weight=0;
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
        <td class=""><a href="<?=base_url()?>reports/loss_report_details?category=<?=$index ?>&factory_name=<?=$factory_name ?>"><?=$index?></a></td>
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
    <td class="text-right"><?=!empty($sum_loss_fine)?four_decimal($sum_after_recoverd_loss_fine/$sum_loss_fine*100):'-'?></td>
  </tr>
    </tbody>
  </table>
</div>