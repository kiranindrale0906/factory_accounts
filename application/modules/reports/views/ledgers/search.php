<?php 
  if ($report_type == 'Vadotar Report' || $report_type == 'Production Report')
    $url = 'reports/vadotar_reports';
  elseif ($report_type == 'Rojmel Report')
    $url = 'reports/rojmel_reports';
  else
    $url = 'reports/account_ledgers';
?>

<div class="row"> 
  <div class="col-md-6">
    <div class="form-group container"> 
      <h5> Select Factory:
        <?php 
          $companies = array('All', 'AR Gold', 'ARF', 'ARC');
          foreach ($companies as $index => $company) { ?>
            <a class="ml-5 <?= ($site_name== $company) ? 'bold black underline' : '' ?>" 
               href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $company?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>'><?= $company ?></a>
          <?php }
        ?>
      </h5>
    </div>
    <div class="form-group container"> 
      <h5> Select Period: 
        <a class="ml-5 <?= ($period=='date') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=date&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>'>Date</a>
        <a class="ml-5 <?= ($period=='week') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=week&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>'>Week</a>
        <a class="ml-5 <?= ($period=='month') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=month&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>'>Month</a>
      </h5>
    </div>
    <!-- <div class="form-group container"> 
      <h5> Details: 
        <a class="ml-5 <?= ($detail=='yes') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=yes&group=<?= $group ?>'>Show Details</a>
        <a class="ml-5 <?= ($detail=='no') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=no&group=<?= $group ?>'>Hide Details</a>
      </h5>
    </div> -->
    <div class="form-group container"> 
      <h5> Group By: 
        <a class="ml-5 <?= ($group=='') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group='>None</a>
        <a class="ml-5 <?= ($group=='voucher_date') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=voucher_date'>Date</a>
      </h5>
    </div>
    <?php if ($report_type == 'Vadotar Report' || $report_type == 'Production Report') { ?>
      <div class="form-group container"> 
        <h5> Report Type: 
          <a class="ml-5 <?= ($report_type=='Vadotar Report') ? 'bold black underline' : '' ?>" 
             href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=Vadotar Report&detail=<?= $detail ?>&group=<?= $group ?>'>Vadotar Report</a>
          <a class="ml-5 <?= ($report_type=='Production Report') ? 'bold black underline' : '' ?>" 
             href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=Production Report&detail=<?= $detail ?>&group=<?= $group ?>'>Production Report</a>
        </h5>
      </div>
    <?php } ?>
  </div>
</div>  