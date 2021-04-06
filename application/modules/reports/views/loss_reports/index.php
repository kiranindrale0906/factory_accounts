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
        <th class="text-right">Recovered Loss</th>
        <th class="text-right">% Loss Before Recovery</th>
        <th class="text-right">% Loss After Recovery</th>
        <th class="text-right">Unrecoverable Loss</th>
        </tr>
    </thead>
    <tbody>
    <?php 
      $sum_overall_loss_fine=$sum_all_loss_before_recovery=$sum_per_kg_loss=$sum_recoverd_loss_fine=$sum_out_weight=$sum_fine=$sum_unrecovery_loss=$sum_all_loss_after_recovery=$sum_out_weight=0;
     foreach ($loss_categories as $index => $loss_category) {
      $sum_overall_loss_fine+=four_decimal($loss_category['overall_loss_fine']);
      $sum_out_weight+=four_decimal($loss_category['out_weight']);
      $sum_recoverd_loss_fine+=four_decimal($loss_category['recoverd_loss_fine']);
      $sum_all_loss_before_recovery+=four_decimal($loss_category['all_loss_before_recovery']);
      $sum_all_loss_after_recovery+=four_decimal($loss_category['all_loss_after_recovery']);
      $sum_unrecovery_loss+=four_decimal($loss_category['unrecovery_loss']);
      $sum_per_kg_loss+=!empty($loss_category['out_weight'])?four_decimal($loss_category['overall_loss_fine']/$loss_category['out_weight']*1000):0;
      ?>
      <tr>
        <td class=""><a href="<?=base_url()?>reports/loss_report_details?category=<?=$index ?>&factory_name=<?=$factory_name ?>"><?=$index?></a></td>
        <td class="text-right"><?=four_decimal($loss_category['overall_loss_fine'])?></td>
        <td class="text-right"><?=four_decimal($loss_category['out_weight'])?></td>
        <td class="text-right"><?=!empty($loss_category['out_weight'])?four_decimal($loss_category['overall_loss_fine']/$loss_category['out_weight']*1000):0?></td>
        
        <td class="text-right"><?=four_decimal($loss_category['recoverd_loss_fine'])?></td>
        <td class="text-right"><?=four_decimal($loss_category['all_loss_before_recovery'])?></td>
        <td class="text-right"><?=four_decimal($loss_category['all_loss_after_recovery'])?></td>
        <td class="text-right"><?=four_decimal($loss_category['unrecovery_loss']) ?></td>
       
      </tr>
    <?php }?>
      <tr class="bg_gray bold">
    <td>Total</td>
    <td class="text-right"><?=$sum_overall_loss_fine?></td>
    <td class="text-right"><?=$sum_out_weight?></td>
    <td class="text-right"><?=$sum_per_kg_loss?></td>
    <td class="text-right"><?=$sum_recoverd_loss_fine?></td>
    <td class="text-right"><?=$sum_all_loss_before_recovery?></td>
    <td class="text-right"><?=$sum_all_loss_after_recovery?></td>
    <td class="text-right"><?=$sum_unrecovery_loss?></td>
  </tr>
    </tbody>
  </table>
</div>