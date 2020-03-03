<?php //pd($client_account_ledger); ?>
<?php 
   if(!empty($client_account_ledger)) {
    foreach ($client_account_ledger as $client_name => $company_data) { ?>
      <div class="row m-1">
       <b> Client Name :  <?=$client_name?> </b>
      </div>
      <br>
      <div class="row m-1">
        <table class="table table-bordered table-sm table-default">
          <thead>
            <tr>
              <th class="text-center">Date</th>
              <th class="text-center">Voucher Type</th>
              <th class="text-center">Voucher Number </th>
              <th class="text-center">Credit Amount</th>
              <th class="text-center">Debit Amount</th>
              <th class="text-center">Credit Weight</th>
              <th class="text-center">Debit Weight</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($company_data)){ 
              $total_credit_amt=0;
              $total_debit_amt=0;
              $total_credit_weight=0;
              $total_debit_weight=0;
              foreach ($company_data as $ledger) {

                $total_credit_amt=$total_credit_amt+$ledger['credit_amount'];
                $total_debit_amt=$total_debit_amt+$ledger['debit_amount'];
                $total_credit_weight=$total_credit_weight+$ledger['credit_weight'];
                $total_debit_weight=$total_debit_weight+$ledger['debit_weight'];
              ?>
            <tr>
              <td class="text-right"><?php echo $ledger['voucher_date']; ?></td>
              <td class="text-right"><?php echo $ledger['voucher_type']; ?></td>
              <td class="text-right"><?php echo $ledger['voucher_number']; ?></td>
              <td class="text-right">
                <?php echo !empty($ledger['credit_amount'])?$ledger['credit_amount']:''; ?>      
              </td>
              <td class="text-right">
                <?php echo !empty($ledger['debit_amount'])?$ledger['debit_amount']:''; ?>    
              </td>
              <td class="text-right">
                <?php echo !($ledger['credit_weight']=="0.00")?$ledger['credit_weight']:''; ?>    
              </td>
              <td class="text-right"><?php echo !($ledger['debit_weight']=="0.00")?$ledger['debit_weight']:''; ?></td>
            </tr>
            <?php } ?>
             <tr>
              <td class="text-right font-weight-bold">Total</td>
              <td></td>
              <td></td>

              <td class="text-right font-weight-bold"><?=!empty($total_credit_amt)?$total_credit_amt:''?></td>
              <td class="text-right font-weight-bold"><?=!empty($total_debit_amt)?$total_debit_amt:''?></td>
              <td class="text-right font-weight-bold"><?=!empty($total_credit_weight)?$total_credit_weight:''?></td>
              <td class="text-right font-weight-bold"><?=!empty($total_debit_weight)?$total_debit_weight:'' ?></td>
            </tr>
            <?php  } else { ?>
              <tr>
                <td colspan="7">No data found.</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <br>
    <?php  
    }
  }
?>
