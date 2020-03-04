
<form method="get" class="form-horizontal fields-group-sm" enctype="multipart/form-data"
      action="<?=ADMIN_PATH."reports/account_ledger_reports/index"?>">
        
  <?php load_field('dropdown', array('field' => 'account_id', 'option'=>@$account_names )); ?> 
 
  <?php load_field('text', array('field' => 'date_from', 'class' => 'datepicker_js'));  ?> 
  <?php load_field('text', array('field' => 'date_to', 'class' => 'datepicker_js'));  ?> 


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
<div class="row m-1">
   <b>Opening Amount : <?=sprintf('%0.2f', @$opening_balance['amount_balance']);?> </b> 
</div>   
<div class="row m-1">
  <b>Opening Weight  : <?=sprintf('%0.2f', @$opening_balance['weight_balance']);?> </b>
</div>
<div class="row m-1">
  <b>Opening Purity Margin  : <?=sprintf('%0.2f', @$opening_balance['purity_balance']);?></b> 
</div> 

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
            <th class="text-center">Purity Margin</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($account_ledger)){ 
            $total_credit_amt=0;
            $total_debit_amt=0;
            $total_credit_weight=0;
            $total_debit_weight=0;
            $total_purity_margin=0;
            foreach ($account_ledger as $ledger) {
              $total_credit_amt=$total_credit_amt+$ledger['credit_amount'];
              $total_debit_amt=$total_debit_amt+$ledger['debit_amount'];
              $total_credit_weight=$total_credit_weight+$ledger['credit_weight'];
              $total_debit_weight=$total_debit_weight+$ledger['debit_weight'];

              $total_purity_margin=$total_purity_margin+$ledger['purity_margin'];
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
            <td class="text-right"><?php echo !($ledger['purity_margin']=="0.00")?$ledger['purity_margin']:''; ?></td>
          </tr>
          <?php } ?>
           <tr>
            <td class="text-right font-weight-bold">Total</td>
            <td></td>
            <td></td>

            <td class="text-right font-weight-bold"><?=sprintf('%0.2f', $total_credit_amt); ?></td>
            <td class="text-right font-weight-bold"><?=sprintf('%0.2f', $total_debit_amt); ?></td>
            <td class="text-right font-weight-bold"><?=sprintf('%0.2f', $total_credit_weight); ?></td>
            <td class="text-right font-weight-bold"><?=sprintf('%0.2f', $total_debit_weight); ?></td>
            <td class="text-right font-weight-bold"><?=sprintf('%0.2f', $total_purity_margin); ?></td>
          </tr>
          <tr>
            <td class="text-right font-weight-bold">Balance</td>
            <td></td>
            <td></td>

            <td class="text-center font-weight-bold" colspan="2">
              <?=sprintf('%0.2f', ($total_credit_amt-$total_debit_amt)); ?>    
            </td>
            <td class="text-center font-weight-bold" colspan="2">
              <?=sprintf('%0.2f', $total_credit_weight-$total_debit_weight); ?>    
            </td>
            <td class="text-center font-weight-bold"><?=sprintf('%0.2f', $total_purity_margin); ?></td>
          </tr>
          <?php  } else { ?>
            <tr>
              <td colspan="8">No data found.</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>