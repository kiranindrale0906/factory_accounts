<?php 
  $url = 'reports/sales_registers';
?>
  <h6 class="heading blue bold text-uppercase mb-0">Sales Register Reports</h6>
  <hr>
<div class="row"> 
  <div class="col-md-6">
    <div class="form-group container"> 
      <h5> Is Export:
        <a class="ml-5 <?= ($is_export== 1) ? 'bold blue underline' : 'bold black' ?>" 
               href='<?= base_url().$url ?>?is_export=1'><?= 'Yes' ?></a>
        <a class="ml-5 <?= ($is_export== 0) ? 'bold blue underline' : 'bold black' ?>" 
               href='<?= base_url().$url ?>?is_export=0'><?= 'NO' ?></a>
      </h5>
    </div>
  </div>
</div>  
<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th class="">Date</th>
        <th class="text-left">Account Name</th>
        <th class="text-left">Is Export</th>
        <th class="text-right"> Taxable Amount</th>
        <th class="text-right">CGST Amount</th>
        <th class="text-right">SGST Amount</th>
        <th class="text-right">TCS Amount</th>
        <th class="text-right">Credit Amount</th>
        </tr>
    </thead>
    <tbody>
    <?php 
      $total_taxable_amount=$total_cgst_amount=$total_sgst_amount=$total_tcs_amount=$total_credit=0;
      
     foreach ($sales_register_records as $index => $record) {
      $total_taxable_amount+=four_decimal($record['taxable_amount']);
      $total_cgst_amount+=four_decimal($record['cgst_amount']);
      $total_sgst_amount+=four_decimal($record['sgst_amount']);
      $total_tcs_amount+=four_decimal($record['tcs_amount']);
      $total_credit+=four_decimal($record['credit_amount']);
      ?>
      <tr>
        <td class="text-left"><?=!empty($record['voucher_date'])?date('d-m-Y',strtotime($record['voucher_date'])):'-'; ?></td>
        <td class="text-left"><?=!empty($record['account_name'])?$record['account_name']:'-'; ?></td>
        <td class="text-left"><?=(!empty($record['is_export']))? "YES":'NO';?></td>
        <td class="text-right"><?=!empty($record['taxable_amount'])?four_decimal($record['taxable_amount']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['cgst_amount'])?four_decimal($record['cgst_amount']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['sgst_amount'])?four_decimal($record['sgst_amount']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['tcs_amount'])?four_decimal($record['tcs_amount']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['credit_amount'])?four_decimal($record['credit_amount']):'-'; ?></td>
       
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
    <td class="text-right"><?=$total_credit?></td>
  </tr>
    </tbody>
  </table>
</div>