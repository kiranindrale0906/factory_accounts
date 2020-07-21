<?php 
  $this->load->view('reports/ledgers/report_header', array('header' => 'Vadotar Report (Ledger)'));
  $this->load->view('ac_vouchers/ac_vouchers/company_error_message'); 
?>

<div class="row"> 
  <div class="col-md-6">
    <div class="form-group container"> 
      <h5> Select Company:
        <?php 
          $companies = array('All', 'AR Gold', 'ARC', 'ARF');
          foreach ($companies as $index => $company) { ?>
            <a class="ml-5 <?= ($company_name== $company) ? 'bold black underline' : '' ?>" 
               href='<?= base_url() ?>reports/vadotar_reports?company_name=<?= $company?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>'><?= $company ?></a>
          <?php }
        ?>
      </h5>
    </div>
    <div class="form-group container"> 
      <h5> Select Period: 
        <a class="ml-5 <?= ($period=='date') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/vadotar_reports?company_name=<?= $company_name?>&period=date&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>'>Date</a>
        <a class="ml-5 <?= ($period=='week') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/vadotar_reports?company_name=<?= $company_name?>&period=week&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>'>Week</a>
        <a class="ml-5 <?= ($period=='month') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/vadotar_reports?company_name=<?= $company_name?>&period=month&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=<?= $group ?>'>Month</a>
      </h5>
    </div>
    <!-- <div class="form-group container"> 
      <h5> Details: 
        <a class="ml-5 <?= ($detail=='yes') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/vadotar_reports?company_name=<?= $company_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=yes&group=<?= $group ?>'>Show Details</a>
        <a class="ml-5 <?= ($detail=='no') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/vadotar_reports?company_name=<?= $company_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=no&group=<?= $group ?>'>Hide Details</a>
      </h5>
    </div> -->
    <div class="form-group container"> 
      <h5> Group By: 
        <a class="ml-5 <?= ($group=='') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/vadotar_reports?company_name=<?= $company_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group='>None</a>
        <a class="ml-5 <?= ($group=='voucher_date') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/vadotar_reports?company_name=<?= $company_name?>&period=<?= $period ?>&report_type=<?= $report_type ?>&detail=<?= $detail ?>&group=voucher_date'>Date</a>
      </h5>
    </div>
    <div class="form-group container"> 
      <h5> Report Type: 
        <a class="ml-5 <?= ($report_type=='vadotar') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/vadotar_reports?company_name=<?= $company_name?>&period=<?= $period ?>&report_type=vadotar&detail=<?= $detail ?>&group=<?= $group ?>'>Vadotar Report</a>
        <a class="ml-5 <?= ($report_type=='production') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/vadotar_reports?company_name=<?= $company_name?>&period=<?= $period ?>&report_type=production&detail=<?= $detail ?>&group=<?= $group ?>'>Production Report</a>
      </h5>
    </div>
  </div>
</div>  
 
<?php
  $this->load->view('reports/ledgers/date_wise_ledger', array('report' => 'vadotar report')); 
  $this->load->view('reports/vadotar_reports/company_vadotars'); 
?>

