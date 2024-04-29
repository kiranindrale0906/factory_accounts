<?php 
  $url = 'reports/average_reports';
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

     foreach ($sale_records as $index => $record) {?>
      <tr>
        <td class="text-left"><?=!empty($record['date_sale'])?date('d-m-Y',strtotime($record['date_sale'])):'-'; ?></td>
        <td class="text-left"><?=!empty($record['customer_name'])?$record['customer_name']:'-'; ?></td>
        <td class="text-left"><?=!empty($record['sale_type'])?$record['sale_type']:'-'; ?></td>
        <td class="text-right"><?=!empty($record['weight'])?four_decimal($record['weight']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['purity'])?four_decimal($record['purity']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['factory_fine'])?four_decimal($record['factory_fine']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['wastage'])?four_decimal($record['wastage']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['wastage_fine'])?four_decimal($record['wastage_fine']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['rate'])?four_decimal($record['rate']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['rate_of_gst'])?four_decimal($record['rate_of_gst']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['vadotar'])?four_decimal($record['vadotar']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['amount'])?four_decimal($record['amount']):'-'; ?></td>
      </tr>
    <?php }?>
      <tr class="bg_gray bold">
    <td>Total</td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
  </tr>
    </tbody>
  </table>
</div>