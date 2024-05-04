<?php 
  $url = 'reports/average_reports';
?>
  <h6 class="heading blue bold text-uppercase mb-0">Average Reports</h6>
  <hr>
<div class="row"> 
  <div class="col-md-6">
    <div class="form-group container"> 
      <h5> Select Type: 
        <a class="ml-5 <?= (!empty($_GET['type'])&& $_GET['type']=='Sales') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?type=Sales&sale_type=<?= $sale_type?>'>Sales</a>
        <a class="ml-5 <?= (!empty($_GET['type'])&& $_GET['type']=='Purchase') ? 'bold black underline' : '' ?>" 
           href='<?= base_url().$url ?>?type=Purchase&sale_type=<?= $sale_type?>'>Purchase</a>
      </h5>
    </div>
    <div class="form-group container">
      <h5> Select Sale Type:
        <a class="ml-5 <?= (!empty($_GET['sale_type'])&& $_GET['sale_type']=='Labour') ? 'bold black underline' : '' ?>"
           href='<?= base_url().$url ?>?type=<?= $type ?>&sale_type=Labour'>Labour</a>
        <a class="ml-5 <?= (!empty($_GET['sale_type'])&& $_GET['sale_type']=='Sale') ? 'bold black underline' : '' ?>"
           href='<?= base_url().$url ?>?type=<?= $type ?>&sale_type=Sale'>Sale</a>
      </h5>
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
	<?php if(!empty($_GET['sale_type']) && $_GET['sale_type']=="Sale"){?>
        <th class="text-right">Gold Sale</th>
        <th class="text-right">Vadotar Sale</th>
        <th class="text-right">Total</th>
        
        <?php }?>
        <th class="text-right">Amount</th>
        </tr>
    </thead>
   <?php
     foreach ($sales_records as $sale_date_wise_index => $sale_date_wise_record) {
    ?>

    <tbody>
    <?php
     $total_weight=$total_vadotar_sale=$total_gold_sale=$total_sale_data=$total_factory_fine=$total_wastage=$total_wastage_fine=$total_vadotar=$total_amount=0;
     foreach ($sale_date_wise_record as $index => $record) {
	$total_weight+=$record['weight'];
	$total_factory_fine+=$record['factory_fine'];
	$total_wastage+=$record['wastage'];
	$total_wastage_fine+=$record['wastage_fine'];
	$total_vadotar+=$record['vadotar'];
	$total_amount+=$record['amount'];
	$total_vadotar_sale+=$record['vadotar_sale'];
	$total_gold_sale+=$record['gold_sale'];
     ?>

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
        <?php if(!empty($_GET['sale_type']) && $_GET['sale_type']=="Sale"){?>
        <td class="text-right"><?=!empty($record['gold_sale'])?four_decimal($record['gold_sale']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['vadotar_sale'])?four_decimal($record['vadotar_sale']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['total_sale'])?four_decimal($record['total_sale']):'-'; ?></td>
        
        
        <?php }?>
	<td class="text-right"><?=!empty($record['amount'])?four_decimal($record['amount']):'-'; ?></td>
	
      </tr>
    <?php }?>
    <tr class="bg_gray bold">
    <td>Total</td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($total_weight)?></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($total_factory_fine)?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($total_wastage_fine)?></td>
    <td class="text-right"><?=four_decimal($total_vadotar)?></td>
    <?php if(!empty($_GET['sale_type']) && $_GET['sale_type']=="Sale"){?>
        <td class="text-right"><?=four_decimal($total_gold_sale); ?></td>
        <td class="text-right"><?=four_decimal($total_vadotar_sale); ?></td>
        <td class="text-right"></td>

        <?php }?>

    <td class="text-right"><?=four_decimal($total_amount)?></td>
    </tr>
   <?php }?>
    </tbody>
  </table>
</div>
