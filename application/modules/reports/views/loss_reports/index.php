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
        $all_companies = array();
        $arg_companies = array();
        $arf_companies = array();
        $arc_companies = array();
        if($_SESSION['all_details']==1){
          $all_companies = array('All');
          $arg_companies = array('AR Gold Nov 2020','AR Gold Jan 2021');
          $arf_companies = array('ARF Nov 2020','ARF Jan 2021');
          $arc_companies = array('ARC Nov 2020','ARC Jan 2021');
        }
        if($_SESSION['arg_details']==1){
          $arg_companies = array('AR Gold Nov 2020','AR Gold Jan 2021');
        }
        if($_SESSION['arf_details']==1){
          $arf_companies = array('ARF Nov 2020','ARF Jan 2021');
        }
        if($_SESSION['arc_details']==1){
          $arc_companies = array('ARC Nov 2020','ARC Jan 2021');
        }
          $companies=array_merge($all_companies,$arg_companies,$arf_companies,$arc_companies);
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
        <th class="text-right"></th>
        </tr>
    </thead>
    <tbody>
    <?php 
      $sum_weight=$sum_fine=0;
     foreach ($loss_categories as $index => $loss_category) {
      ?>
      <tr>
        <td class=""><a href="<?=base_url()?>reports/loss_report_details?category=<?=$index ?>&factory_name=<?=$factory_name ?>"><?=$index?></a></td>
      </tr>
    <?php }?>
      <tr class="bg_gray bold">
    <td>Total</td>
    <td class="text-right"><?//=four_decimal($sum_fine)?></td>
  </tr>
    </tbody>
  </table>
</div>