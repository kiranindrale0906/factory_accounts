<?php
$grand_credit = 0;
$grand_debit = 0;
$grand_balance = 0; 

if(!empty($opening_balance['opening_balance']) && $opening_balance<0)
 $grand_debit = $opening_balance['opening_balance'];

if(!empty($opening_balance['opening_balance']) && $opening_balance>0)
	$grand_debit = $opening_balance['opening_balance']; ?>

<tr>
  <td colspan="3">Opening Balance</td>
  <td class="text-right"><?=(!empty($opening_balance['opening_balance']) && $opening_balance<0)?decimal_number_format($opening_balance['opening_balance']):"" ?></td>
 	<td class="text-right"><?=(!empty($opening_balance['opening_balance']) && $opening_balance>0)?decimal_number_format($opening_balance['opening_balance']):"" ?></td>
  <td></td>
</tr>

<?php
foreach ($metal_register as $key => $metal_data) {
 	$grand_credit += !empty($metal_data['credit_weight'])?$metal_data['credit_weight']:0;
 	$grand_debit += !empty($metal_data['debit_weight'])?$metal_data['debit_weight']:0; ?>

	<tr>
	    <td><?= date('d-m-y', strtotime($metal_data['voucher_date'])) ?></td>
	    <td><?= $metal_data['voucher_number'] ?></td>
	    <td><?= $metal_data['account_name'] ?></td>
	    <td class="text-right"><?= (!empty($metal_data['credit_weight'])) ? decimal_number_format($metal_data['credit_weight']):"0.0000"; ?></td>
	    <td class="text-right"><?= (!empty($metal_data['debit_weight'])) ? decimal_number_format($metal_data['debit_weight']) : "0.0000"; ?></td>
	    <td><?= (!empty($metal_data['narration'])) ? $metal_data['narration'] : '' ?></td>
	</tr>

<?php
	}
?>
 <tr>
  <td class="text-right" colspan="3"><b>Total</b></td>
  <td class="text-right"><b><?= decimal_number_format($grand_credit) ?></b></td>
  <td class="text-right"><b><?= decimal_number_format($grand_debit) ?></b></td>
  <td></td>
</tr>