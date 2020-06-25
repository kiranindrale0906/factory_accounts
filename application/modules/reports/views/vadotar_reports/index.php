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
             href='/accounts/reports/vadotar_reports?company_name=<?= $company?>'><?= $company ?></a>
        <?php }
      ?>
    </h5>
    </div> 
  </div>
</div>  
 
<?php
  $this->load->view('reports/ledgers/date_wise_ledger', array('report' => 'vadotar report')); 
  $this->load->view('reports/vadotar_reports/company_vadotars'); 
?>

