<?php 
  $url = 'reports/purchase_registers';
?>
  <h6 class="heading blue bold text-uppercase mb-0">Average Reports</h6>
  <hr>
<div class="row"> 
  <div class="col-md-6">
    <div class="form-group container"> 
    </div>
  </div>
</div>  
<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>


        <th class="">Date</th>
        <th class="text-left">Customer Name</th>
        <th class="text-left">Type</th>
        <th class="text-right">Weight</th>
        <th class="text-right">Purity</th>
        <th class="text-right">Factory Fine</th>
        <th class="text-right">Wastage</th>
        <th class="text-right">Wastage Fine</th>
        <th class="text-right">Rate</th>
        <th class="text-right">Rate With Gst</th>
        <th class="text-right">Vadotar</th>
        <th class="text-right">Amount</th>
        <th class="text-right"></th>
        </tr>
    </thead>
    <tbody>
    <?php 
      $total_taxable_amount=$total_cgst_amount=$total_sgst_amount=$total_tcs_amount=$total_debit=0;
      
     foreach ($purchase_records as $index => $record) {
      $total_taxable_amount+=four_decimal($record['taxable_amount']);
      $total_cgst_amount+=four_decimal($record['cgst_amount']);
      $total_sgst_amount+=four_decimal($record['sgst_amount']);
      $total_tcs_amount+=four_decimal($record['tcs_amount']);
      $total_debit+=four_decimal($record['credit_amount']);
      ?>
      <tr>
        <td class="text-left"><?=!empty($record['voucher_date'])?date('d-m-Y',strtotime($record['voucher_date'])):'-'; ?></td>
        <td class="text-left"><?=!empty($record['account_name'])?$record['account_name']:'-'; ?></td>
        <td class="text-left"><?=(!empty($record['is_export']))? "YES":'NO'; ?></td>
        <td class="text-right"><?=!empty($record['taxable_amount'])?four_decimal($record['taxable_amount']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['cgst_amount'])?four_decimal($record['cgst_amount']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['sgst_amount'])?four_decimal($record['sgst_amount']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['tcs_amount'])?four_decimal($record['tcs_amount']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['credit_amount'])?four_decimal($record['credit_amount']):'-'; ?></td>
        <td class="text-right"><a href="<?=base_url().'/argold/voucher_details/view/'.$record['id']?>">View</a></td>
       
      </tr>
    <?php }?>
      <tr class="bg_gray bold">
    <td>Total</td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"><?=$total_taxable_amount?></td>
    <td class="text-right"><?=$total_cgst_amount?></td>
    <td class="text-right"><?=$total_sgst_amount?></td>
    <td class="text-right"><?=$total_tcs_amount?></td>
    <td class="text-right"><?=$total_debit?></td>
    <td class="text-right"></td>
  </tr>
    </tbody>
  </table>
</div>