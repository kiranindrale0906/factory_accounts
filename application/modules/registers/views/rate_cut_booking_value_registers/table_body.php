<tbody>
  <?php  
$amount=$gold_weight=$credit_amount=$debit_amount=0;
  foreach ($rate_cut_booking_value_registers as $index => $rate_cut_booking_value_register){ 
    $amount+=$rate_cut_booking_value_registers['amount'];
    $gold_weight+=$rate_cut_booking_value_registers['gold_weight'];
    $credit_amount+=$rate_cut_booking_value_registers['credit_amount'];
    $debit_amount+=$rate_cut_booking_value_registers['debit_amount'];
    ?>
  	   <tr>
          <td><?= ++$index; ?></td>
          <td ><?= date('d-m-y', strtotime($rate_cut_booking_value_registers['created_at'])) ?></td>
          <td><?= $rate_cut_booking_value_registers['voucher_number'] ?></td>
          <td><?= $rate_cut_booking_value_registers['account_name'] ?></td>
          <td class="text-right"><?= !empty($rate_cut_booking_value_registers['amount'])?$rate_cut_booking_value_registers['amount']:0; ?></td>
          <td class="text-right"><?= !empty($rate_cut_booking_value_registers['gold_weight'])?$rate_cut_booking_value_registers['gold_weight']:0; ?></td>
          <td class="text-right"><?= $rate_cut_booking_value_registers['purity'] ?></td>
          <td class="text-right"><?= !empty($rate_cut_booking_value_registers['credit_amount'])?$rate_cut_booking_value_registers['credit_amount']:0 ?></td>
          <td class="text-right"><?= !empty($rate_cut_booking_value_registers['debit_amount'])?$rate_cut_booking_value_registers['debit_amount']:0; ?></td>
       </tr>
	  <?php }?>
<tr class="bg_gray bold">
    <td>Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td class="text-right"><?=$amount;?></td>
    <td class="text-right"><?=$gold_weight;?></td>
    <td></td>
    <td class="text-right"><?=$credit_amount;?></td>
    <td class="text-right"><?=$debit_amount;?></td>
  </tr>
</tbody> 