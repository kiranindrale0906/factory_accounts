<?php $this->load->view('ac_vouchers/ac_vouchers/company_error_message'); ?>
<form method="get" class="form-horizontal fields-group-sm" enctype="multipart/form-data"
      action="<?=ADMIN_PATH."reports/account_ledger_reports/index"?>">
        
  <?php load_field('dropdown', array('field' => 'account_id', 'option'=>@$account_names )); ?> 
 
  <?php //load_field('text', array('field' => 'date_from', 'class' => 'datepicker_js'));  ?> 
  <?php //load_field('text', array('field' => 'date_to', 'class' => 'datepicker_js'));  ?> 


  <div class="row"> 
    <div class="col-sm-6"> 
      <?php
          $add_attr=array('controller' => $this->router->class, 'name' => 'Submit' , 'class' => 'btn_blue');
          load_buttons('submit', $add_attr); 
          
          load_buttons('anchor', array('href'=>ADMIN_PATH."reports/account_ledger_reports/index",'name' => 'Clear Filter' , 'class' => 'btn_blue')); 
      ?> 
    </div>
  </div>  
</form>  
<br>
<?php 
  $previous_date = '';
  $account['name']=ACCOUNT_NAME_REPORT;
  foreach ($voucher_dates as $index => $voucher_date) { ?>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group container">
          <div class="table-responsive m-t-20">
            <h5 class="heading blue m-0">Receipt: <?= $voucher_date ?></h5>
            <table class="table table-sm fixedthead table-default">
              <?php 
                $this->load->view('reports/account_ledger_reports/receipt_thead'); 
                $this->load->view('reports/account_ledger_reports/tbody', 
                        array('voucher_date_records' => isset($receipts[$voucher_date]) ? $receipts[$voucher_date] :
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
                $this->load->view('reports/account_ledger_reports/issue_thead');
                $this->load->view('reports/account_ledger_reports/tbody', 
                                                        array('voucher_date_records' => isset($issues[$voucher_date]) ? $issues[$voucher_date] : array(),
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

?>
  