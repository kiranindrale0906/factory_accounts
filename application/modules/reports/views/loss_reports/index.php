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
        <th class="">Type of Loss Out</th>
        <th class="text-right">Overall Final Loss</th>
        <th class="text-right">Overall Production</th>
        <th class="text-right">Product Production</th>
        <th class="text-right">Over Loss % After Recovery</th>
        </tr>
    </thead>
    <tbody>
    <?php 
      $sum_weight=$sum_fine=0;
     foreach ($loss_categories as $index => $loss_category) {
      ?>
      <tr>
        <td class=""><a href="<?=base_url()?>reports/loss_report_details?category=<?=$index ?>&factory_name=<?=$factory_name ?>"><?=$index?></a></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php }?>
      <tr class="bg_gray bold">
    <td>Total</td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
  </tr>
    </tbody>
  </table>
</div>