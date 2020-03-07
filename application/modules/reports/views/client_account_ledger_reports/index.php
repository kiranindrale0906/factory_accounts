<?php $this->load->view('ac_vouchers/ac_vouchers/company_error_message'); ?> 
<br>

<?php   
  if(!empty($account_names)) {
    foreach ($account_names as $key => $account) { ?>
      <h5> <?=$account['name'];?> </h5>
      <?php
      $previous_date = '';
      foreach ($voucher_dates as $index => $voucher_date) {  

        ?>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group container">
              <div class="table-responsive m-t-20">
                <h5 class="heading blue m-0">Receipt: <?= $voucher_date; ?></h5>
                <table class="table table-sm fixedthead table-default">
                  <?php 
                    $this->load->view('reports/client_account_ledger_reports/thead'); 
                    $this->load->view('reports/client_account_ledger_reports/tbody', 
                        array('voucher_date_records' => isset($receipts[$account['name']][$voucher_date][$account['name']])                              ? $receipts[$account['name']][$voucher_date][$account['name']] :
                                                          array(),
                              'previous_date' => $previous_date,
                              'voucher_date' => $voucher_date,
                              'type' => 'receipt',
                              'account_name'=>$account['name'])); 
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
                    $this->load->view('reports/client_account_ledger_reports/thead');
                    $this->load->view('reports/client_account_ledger_reports/tbody', 
                                                        array('voucher_date_records' => isset($issues[$account['name']][$voucher_date][$account['name']]) ? $issues[$account['name']][$voucher_date][$account['name']] : array(),
                                                          'previous_date' => $previous_date,
                                                          'voucher_date' => $voucher_date,
                                                          'type' => 'issue',
                                                          'account_name'=>$account['name'])); 
                  ?>
                  
                </table>
              </div> 
            </div>
          </div>

          
        </div>
        <?php 
        $previous_date = $voucher_date;
      }
    }
  }
      

?>
  