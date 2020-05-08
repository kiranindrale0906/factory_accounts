<tbody>
  <?php  
$amount=$gold_weight=$credit_amount=$debit_amount=0;
  foreach ($rate_cut_booking_value_registers as $index => $rate_cut_booking_value_register){ 
    $amount+=$rate_cut_booking_value_register['amount'];
    $gold_weight+=$rate_cut_booking_value_register['gold_weight'];
    $credit_amount+=$rate_cut_booking_value_register['credit_amount'];
    $debit_amount+=$rate_cut_booking_value_register['debit_amount'];
    ?>
  	   <tr>
          <td><?= ++$index; ?></td>
          <td ><?= date('d-m-y', strtotime($rate_cut_booking_value_register['created_at'])) ?></td>
          <td><?= $rate_cut_booking_value_register['voucher_number'] ?></td>
          <td><?= $rate_cut_booking_value_register['account_name'] ?></td>
          <td><?= $rate_cut_booking_value_register['transaction_type'] ?></td>
          <td class="text-right"><?= !empty($rate_cut_booking_value_register['gold_rate'])?$rate_cut_booking_value_register['gold_rate']:"0.0000"; ?></td>
          <td class="text-right"><?= !empty($rate_cut_booking_value_register['gold_weight'])?$rate_cut_booking_value_register['gold_weight']:""; ?></td>
          <td class="text-right"><?= $rate_cut_booking_value_register['gold_weight_purity'] ?></td>
          <td class="text-right"><?= !empty($rate_cut_booking_value_register['credit_amount'])?$rate_cut_booking_value_register['credit_amount']:"0.0000" ?></td>
          <td class="text-right"><?= !empty($rate_cut_booking_value_register['debit_amount'])?$rate_cut_booking_value_register['debit_amount']:"0.0000"; ?></td>
       </tr>
	  <?php }?>
<tr class="bg_gray bold">
    <td>Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td></td>
    <td class="text-right"><?=$credit_amount;?></td>
    <td class="text-right"><?=$debit_amount;?></td>
  </tr>
</tbody> 