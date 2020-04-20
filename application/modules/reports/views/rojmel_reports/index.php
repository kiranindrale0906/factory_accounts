<?php $this->load->view('ac_vouchers/ac_vouchers/company_error_message'); ?>

<br>
<?php 
  $previous_date = '';
  foreach ($voucher_dates as $index => $voucher_date) { //pd($receipts); ?>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group container">
          <div class="table-responsive m-t-20">
            <h5 class="heading blue m-0">Receipt: <?= $voucher_date ?></h5>
            <table class="table table-sm fixedthead table-default">
              <?php 
                $this->load->view('reports/rojmel_reports/thead'); 
                $this->load->view('reports/rojmel_reports/tbody', 
                                                      array('voucher_date_records' => isset($receipts[$voucher_date]) ? $receipts[$voucher_date] : array(),
                                                            'previous_date' => $previous_date,
                                                            'voucher_date' => $voucher_date,
                                                            'type' => 'receipt')); 
              ?>
            </table>
          </div> 
        </div>
      </div> 

      <div class="col-md-6 border-right">
        <div class="form-group container">
          <div class="table-responsive m-t-20">
            <h5 class="heading blue m-0">Issue</h5>
            <table class="table table-sm fixedthead table-default">
              <?php 
                $this->load->view('reports/rojmel_reports/thead');
                $this->load->view('reports/rojmel_reports/tbody', 
                                                    array('voucher_date_records' => isset($issues[$voucher_date]) ? $issues[$voucher_date] : array(),
                                                          'previous_date' => $previous_date,
                                                          'voucher_date' => $voucher_date,
                                                          'type' => 'issue')); 
              ?>
              
            </table>
          </div> 
        </div>
      </div>

      
    </div>
    <?php 
    $previous_date = $voucher_date;
  }

  if(!empty($voucher_date)) {
    $weight_difference=0;
    if(!empty($balance[ACCOUNT_NAME_REPORT][$voucher_date]['issue']['weight_difference'])) {
      $weight_difference=$balance[ACCOUNT_NAME_REPORT][$voucher_date]['issue']['weight_difference'];
    }
    else if(!empty($balance[ACCOUNT_NAME_REPORT][$voucher_date]['receipt']['weight_difference'])) {
      $weight_difference=$balance[ACCOUNT_NAME_REPORT][$voucher_date]['receipt']['weight_difference'];
    }

    $this->load->view('reports/rojmel_reports/final_balance_table', 
                                                    array('weight_difference' => $weight_difference));
  }  
?>
  