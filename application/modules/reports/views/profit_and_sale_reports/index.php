<?php 
  $url = 'reports/profit_and_loss_reports';
?>
  <h6 class="heading blue bold text-uppercase mb-0">Profit and Sale Reports</h6>
  <hr>
    <form class="fields-group-sm">
    <div class="row">
      <?php load_field('date',array('field' => 'from_date', 'class' => 'datepicker_js', 'col'=>'col-sm-3','value'=>$from_date))?> 
      <?php load_field('date',array('field' => 'to_date', 'class' => 'datepicker_js', 'col'=>'col-sm-3','value'=>$to_date))?>
      <div class="col-sm-4 align-self-center">
          <?php load_buttons('button', array('name' =>'Search','class'=>'btn-xs btn_blue profit_and_sale_search_date mr-2')) ?> 
          <?php load_buttons('button', array('name' =>'Clear','class'=>'btn-xs btn_blue clear_btn')) ?> 
      </div>
  </div>
</form> 

<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th class="">Date</th>
        <th class="">Account Name</th>
        <th class="">Chitti No</th>
        <th class="">Sale Type</th>
        <th class="text-right">Credit Amount</th>
        <th class="text-right">Purity</th>
        <th class="text-right">Factory Purity</th>
        <th class="text-right">Gold amount</th>
        <th class="text-right">Gold Rate</th>
        <th class="text-right">Gold Fine</th>
        <th class="text-right">Vadotar amount</th>
        <th class="text-right">Vadotar Rate</th>
        <th class="text-right">Vadotar Fine</th>
        </tr>
    </thead>
    <tbody>
	   <?php 
      $total_credit_weight=$total_gold_amount=$total_vadotar_amount=$total_gold_rate=$total_vadotar_rate=$total_gold_fine=$total_vadotar_fine=0;
     foreach ($profit_and_sale_records as $index => $record) {
	$total_credit_weight+=$record['credit_weight'];
	$total_gold_amount+=$record['gold_amount'];
	$total_gold_fine+=$record['gold_fine'];
	$total_gold_rate+=$record['gold_rate'];
	$total_vadotar_fine+=$record['vadotar_fine'];
	$total_vadotar_amount+=$record['vadotar_amount'];
      
      ?>
      <tr>
	<td class="text-left"><?=!empty($record['voucher_date'])?date('d-m-Y',strtotime($record['voucher_date'])):'-'; ?></td>
        <td class="text-left"><?=!empty($record['account_name'])?$record['account_name']:'-'; ?></td>
        <td class="text-left"><?=!empty($record['chitti_id'])?"Chitti no -".$record['chitti_id']:'-'; ?></td>
        <td class="text-left"><?=!empty($record['sale_type'])?$record['sale_type']:'-'; ?></td>
        <td class="text-right"><?=!empty($record['credit_weight'])?four_decimal($record['credit_weight']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['purity'])?four_decimal($record['purity']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['factory_purity'])?four_decimal($record['factory_purity']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['gold_amount'])?four_decimal($record['gold_amount']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['gold_rate'])?four_decimal($record['gold_rate']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['gold_fine'])?four_decimal($record['gold_fine']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['vadotar_amount'])?four_decimal($record['vadotar_amount']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['vadotar_rate'])?four_decimal($record['vadotar_rate']):'-'; ?></td>
        <td class="text-right"><?=!empty($record['vadotar_fine'])?four_decimal($record['vadotar_fine']):'-'; ?></td>      
      </tr>
    <?php }?>
    </tbody>
	<tr class="bg_gray bold">
    <td>Total</td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"><?=$total_credit_weight?></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"><?=$total_gold_amount?></td>
    <td class="text-right"><?=$total_gold_rate?></td>
    <td class="text-right"><?=$total_gold_fine?></td>
    <td class="text-right"><?=$total_vadotar_amount?></td>
    <td class="text-right"><?=$total_vadotar_rate?></td>
    <td class="text-right"><?=$total_vadotar_fine?></td>
  </tr>
  </table>
</div>
