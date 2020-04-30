<tbody>
<?php  

  $amount=$gold_rate=$credit_amount=$debit_amount=0;
  foreach ($rate_cut_purchase_weight_registers as $index => $rate_cut_purchase_weight_register){ 
    $amount+=$rate_cut_purchase_weight_register['amount'];
    $gold_rate+=$rate_cut_purchase_weight_register['gold_rate'];
    $credit_amount+=$rate_cut_purchase_weight_register['credit_weight'];
    $debit_amount+=$rate_cut_purchase_weight_register['debit_amount'];
    
?>
	   <tr>
        <td><?= ++$index; ?></td>
        <td ><?= date('d-m-y', strtotime($rate_cut_purchase_weight_register['created_at'])) ?></td>
        <td><?= $rate_cut_purchase_weight_register['voucher_number'] ?></td>
        <td><?= $rate_cut_purchase_weight_register['account_name'] ?></td>
         <td class="text-right"><?= !empty($rate_cut_purchase_weight_register['amount'])?$rate_cut_purchase_weight_register['amount']:0; ?></td>
         <td class="text-right"><?= !empty($rate_cut_purchase_weight_register['gold_rate'])?$rate_cut_purchase_weight_register['gold_rate']:0 ?></td>
         <td class="text-right"><?= $rate_cut_purchase_weight_register['purity'] ?></td>
        <td class="text-right"><?= !empty($rate_cut_purchase_weight_register['credit_weight'])?$rate_cut_purchase_weight_register['credit_weight']:0; ?></td>
        <td class="text-right"><?= !empty($rate_cut_purchase_weight_register['debit_amount'])?$rate_cut_purchase_weight_register['debit_amount']:0; ?></td>
        </tr>
	  <?php }?>

  

<tr class="bg_gray bold">
    <td>Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td class="text-right"><?=four_decimal($amount);?></td>
    <td class="text-right"><?=four_decimal($gold_rate);?></td>
    <td></td>
    <td class="text-right"><?=four_decimal($credit_amount);?></td>
    <td class="text-right"><?=four_decimal($debit_amount);?></td>
  </tr>
</tbody> 