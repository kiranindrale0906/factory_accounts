<?php 
  $total_income_amount =   $debit_note['taxable_amount']
                         + $debit_note['cgst_amount'] + $debit_note['sgst_amount']
                         + $debit_note['tcs_amount']
                         + $sales['taxable_amount']
                         + $sales['cgst_amount'] + $sales['sgst_amount']
                         + $sales['tcs_amount'];
  
  $total_expenses_amount =   $credit_note['taxable_amount']
                           + $credit_note['cgst_amount'] + $credit_note['sgst_amount']
                           + $credit_note['tcs_amount']
                           + $purchase_export_Sale['taxable_amount'] + $purchase_domestic_Sale['taxable_amount']
                           + $purchase_export_Sale['cgst_amount'] + $purchase_domestic_Sale['cgst_amount']
                           + $purchase_export_Sale['sgst_amount'] + $purchase_domestic_Sale['sgst_amount']
                           + $purchase_export_Sale['tcs_amount'] + $purchase_domestic_Sale['tcs_amount']
                           + $purchase_domestic_Labour['taxable_amount']
                           + $purchase_domestic_Labour['cgst_amount']
                           + $purchase_domestic_Labour['sgst_amount']
                           + $purchase_domestic_Labour['tcs_amount'];
?>

<hr />
<h5 class="ml-2 pl-2">GST</h5>

<div class="row">
  <div class="col-md-6">
    <div class="form-group container">
      <div class="table-responsive m-t-20">
        <table class="table table-sm fixedthead table-default">
          <thead>
            <tr>
              <th>PURCHASE</th>
              <th class="text-right">Amount</th>
            </tr>
          </thead>

          <?php $this->load->view('trial_balances/gst_fields', array('gst_voucher' => 'CREDIT NOTE', 'gst' => $credit_note)); ?>
          <?php $this->load->view('trial_balances/gst_fields', array('gst_voucher' => 'DOMESTIC SALE', 'gst' => $profit_and_loss['purchase_account_domestic_Sale'])); ?>
          <?php $this->load->view('trial_balances/gst_fields', array('gst_voucher' => 'DOMESTIC LABOUR', 'gst' => $profit_and_loss['purchase_account_domestic_Labour'])); ?>
          <?php $this->load->view('trial_balances/gst_fields', array('gst_voucher' => 'EXPORT SALE', 'gst' => $profit_and_loss['purchase_account_export_Sale'])); ?>
          
          <tr>
            <th>TOTAL</th>
            <th class="text-right"><?= four_decimal($total_expenses_amount, '-') ?></th>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group container">
      <div class="table-responsive m-t-20">
        <table class="table table-sm fixedthead table-default">
          <thead>
            <tr>
              <th>SALES</th>
              <th class="text-right">Amount</th>
            </tr>
          </thead>
          <?php $this->load->view('trial_balances/gst_fields', array('gst_voucher' => 'DEBIT NOTE', 'gst' => $debit_note)); ?>
          <?php $this->load->view('trial_balances/gst_fields', array('gst_voucher' => 'DOMESTIC LABOUR', 'gst' => $profit_and_loss['sale_account_domestic_Labour'])); ?>
          <?php $this->load->view('trial_balances/gst_fields', array('gst_voucher' => 'EXPORT SALE', 'gst' => $profit_and_loss['sale_account_export_Sale'])); ?>
          <tr>
            <th>TOTAL</th>
            <th class="text-right"><?= four_decimal($total_income_amount, '-') ?></th>
          </tr>
        </table>
      </div>      
    </div>
  </div>  
</div>