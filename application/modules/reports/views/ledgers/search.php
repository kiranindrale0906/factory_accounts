<?php 
  if ($report_type == 'Vadotar Report' || $report_type == 'Production Report')
    $url = 'reports/vadotar_reports';
  elseif ($report_type == 'Rojmel Report')
    $url = 'reports/rojmel_reports';
  elseif ($report_type == 'Account Receipt Report')
    $url = 'reports/account_receipt_reports';
  elseif ($report_type == 'Metal Receipt Type Report')
    $url = 'reports/metal_receipt_type_ledgers';
  else
    $url = 'reports/account_ledgers';
?>

<div class="row"> 
  <div class="col-md-12">
    <div class="form-group container"> 
      <h5> Select Factory:
        <?php 
        $all_companies = array();
        $arg_companies = array();
        $arf_companies = array();
        $arc_companies = array();
        $export_companies = array();
        $domestic_companies = array();
        if($_SESSION['all_details']==1){
          $all_companies = array('All');
          $arg_companies = array('AR Gold (May 2022)','AR Gold (Aug 2022)');
          $arf_companies = array('ARF (May 2022)','AR Gold (Aug 2022)');
          $arc_companies = array('ARC (May 2022)','AR Gold (Aug 2022)');
          $export_companies = array('Export');
          $domestic_companies = array('Domestic');
        }
        if($_SESSION['arg_details']==1){
          $arg_companies = array('AR Gold (May 2022)','AR Gold (Aug 2022)');
        }
        if($_SESSION['arf_details']==1){
          $arf_companies = array('ARF (May 2022)','ARF (Aug 2022)');
        }
        if($_SESSION['arc_details']==1){
          $arc_companies = array('ARC (May 2022)','ARC (Aug 2022)');
        }
        if(!empty($_SESSION['export_details'])&&$_SESSION['export_details']==1){
          $export_companies = array('Export');
        }
        if(!empty($_SESSION['domestic_details'])&&$_SESSION['domestic_details']==1){
          $domestic_companies = array('Domestic');
        }
          $companies=array_merge($all_companies,$arg_companies,$arf_companies,$arc_companies,$export_companies,$domestic_companies);
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
           href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=date&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>&domestic_export=<?= $domestic_export ?>'>Date</a>
        <a class="ml-5 <?= ($period=='week') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=week&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>&domestic_export=<?= $domestic_export ?>'>Week</a>
        <a class="ml-5 <?= ($period=='month') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=month&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>&domestic_export=<?= $domestic_export ?>'>Month</a>
        <a class="ml-5 <?= ($period=='year') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=year&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>&domestic_export=<?= $domestic_export ?>'>Year</a>
      </h5>
    </div>
    <!-- <div class="form-group container"> 
      <h5> Details: 
        <a class="ml-5 <?= ($detail=='yes') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=yes&group=<?= $group ?>&domestic_export=<?= $domestic_export ?>'>Show Details</a>
        <a class="ml-5 <?= ($detail=='no') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=no&group=<?= $group ?>&domestic_export=<?= $domestic_export ?>'>Hide Details</a>
      </h5>
    </div> -->
    <?php if ($report_type != 'Rojmel Report' && $report_type != 'Account Receipt Report' && $report_type != 'Metal Receipt Type Report') { ?>
      <div class="form-group container"> 
        <h5> Group By: 
          <a class="ml-5 <?= ($group=='') ? 'bold black underline' : '' ?>" 
             href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=&domestic_export=<?= $domestic_export ?>'>None</a>
          <a class="ml-5 <?= ($group=='voucher_date') ? 'bold black underline' : '' ?>" 
             href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=voucher_date&domestic_export=<?= $domestic_export ?>'>Date</a>
        </h5>
      </div>
    <?php } ?>
    <?php 
      if ($report_type != 'Account Receipt Report'){
      if ($_SESSION['vodator_report']==1 || $_SESSION['production_report']==1 || $report_type == 'Vadotar Report' || $report_type == 'Production Report') { ?>
      <div class="form-group container"> 
        <h5> 
        <?php if($_SESSION['vodator_report']==1 || $_SESSION['production_report']==1){ ?>
        Report Type: 

        <?php } if($_SESSION['vodator_report']==1){ ?>
          <a class="ml-5 <?= ($report_type=='Vadotar Report') ? 'bold black underline' : '' ?>" 
             href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=Vadotar Report&detail=<?= $detail ?>&group=<?= $group ?>&domestic_export=<?= $domestic_export ?>'>Vadotar Report</a>
        <?php }?>
        <?php if($_SESSION['production_report']==1){ ?>
          <a class="ml-5 <?= ($report_type=='Production Report') ? 'bold black underline' : '' ?>" 
             href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=Production Report&detail=<?= $detail ?>&group=<?= $group ?>&domestic_export=<?= $domestic_export ?>'>Production Report</a>
        <?php }?>
        </h5>
      </div>

      <div class="form-group container"> 
        <h5> 
        <?php if($_SESSION['vodator_report']==1 || $_SESSION['production_report']==1){ ?>
        Domestic / Export: 
          <a class="ml-5 <?= ($domestic_export=='All') ? 'bold black underline' : '' ?>" 
             href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>&domestic_export=All'>All</a>
          <a class="ml-5 <?= ($domestic_export=='Domestic') ? 'bold black underline' : '' ?>" 
             href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>&domestic_export=Domestic'>Domestic</a>
          <a class="ml-5 <?= ($domestic_export=='Export') ? 'bold black underline' : '' ?>" 
             href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>&domestic_export=Export'>Export</a>
          <a class="ml-5 <?= ($domestic_export=='Tanishq') ? 'bold black underline' : '' ?>" 
             href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>&domestic_export=Tanishq'>Tanishq</a>
          <a class="ml-5 <?= ($domestic_export=='Domestic Internal') ? 'bold black underline' : '' ?>" 
             href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&site_name=<?= $site_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>&domestic_export=Domestic Internal'>Domestic Internal</a>
        <?php }?>
        
        </h5>
      </div>
    <?php } }?>
  </div>
</div>  

    <?php 
    if ($report_type == 'Account Receipt Report'){
    if (!empty($account_names)) { ?>
    
    <div class="col-md-12">
      <h6>
        Account Name: 
        <a class="ml-5 <?= ($account_name == '') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&account_name=&site_name=<?= $company?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>'>All</a>
          <?php foreach ($account_names as $account) { ?>
            <a class="ml-5 <?= ($account_name == $account) ? 'bold black underline' : '' ?>"
               href='<?= base_url().$url ?>?account_id=<?= $account_id ?>&account_name=<?= $account?>&site_name=<?= $company?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>'><?= $account ?></a>    
          <?php } ?>
      </h6>
      </div>
<?php }} ?>
