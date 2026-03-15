<tbody>
<?php 
$amount=$gold_rate=$credit_weight=$debit_weight=0;
 foreach ($rate_cut_booking_weight_registers as $index => $rate_cut_booking_weight_register){ 
    $amount+=$rate_cut_booking_weight_register['amount'];
    $gold_rate+=$rate_cut_booking_weight_register['gold_rate'];
    $credit_weight+=$rate_cut_booking_weight_register['credit_weight'];
    $debit_weight+=$rate_cut_booking_weight_register['debit_weight'];
    $amount  +=$rate_cut_booking_weight_register['amount'];
        ?>
	   <tr>
        <td><?= ++$index; ?></td>
        <td ><?= date('d-m-y', strtotime($rate_cut_booking_weight_register['created_at'])) ?></td>
        <td><?= $rate_cut_booking_weight_register['voucher_number'] ?></td>
        <td><?= $rate_cut_booking_weight_register['account_name'] ?></td>
        <td><?= $rate_cut_booking_weight_register['transaction_type'] ?></td>
        <td class="text-right"><?= !empty($rate_cut_booking_weight_register['gold_rate'])?$rate_cut_booking_weight_register['gold_rate']:"0.0000"; ?></td>
        <td class="text-right"><?= $rate_cut_booking_weight_register['gold_rate_purity'] ?></td>
        <td class="text-right"><?= $rate_cut_booking_weight_register['amount'] ?></td>
        <td class="text-right"><?= !empty($rate_cut_booking_weight_register['credit_weight'])?$rate_cut_booking_weight_register['credit_weight']:"0.0000"; ?></td>
        <td class="text-right"><?= !empty($rate_cut_booking_weight_register['debit_weight'])?$rate_cut_booking_weight_register['debit_weight']:"0.0000"; ?></td>
        </tr>
	  <?php }?>
  <tr class="bg_gray bold">
    <td>Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td class="text-right"></td>
    <td></td>
    <td class="text-right"><?=decimal_number_format($amount)?></td>
    <td class="text-right"><?=decimal_number_format($credit_weight);?></td>
    <td class="text-right"><?=decimal_number_format($debit_weight);?></td>
  </tr>
</tbody> 