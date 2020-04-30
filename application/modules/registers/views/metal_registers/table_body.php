<tbody>
<?php  
$credit_amount=$debit_amount=$amount=0;
foreach ($bank_registers as $index => $bank_register){ 
               $credit_amount+= $bank_register['credit_amount'];
               $debit_amount+= $bank_register['debit_amount'];
               $amount+=$bank_register['amount'];


        ?>
	   <tr>
                                        <td><?= ++$index; ?></td>
                                        <td ><?= date('d-m-y', strtotime($bank_register['created_at'])) ?></td>
                                        <td><?=$bank_register['voucher_number'] ?></td>
                                        <td><?= $bank_register['account_name'] ?></td>
                                        <td><?= $bank_register['bank_name'] ?></td>
                                        <td class="text-right"><?= !empty($bank_register['credit_amount'])?$bank_register['credit_amount']:0 ?></td>
                                        <td class="text-right"><?= !empty(
                                        $bank_register['debit_amount'])?$bank_register['debit_amount']:0; ?>
                                                
                                        </td>
                                        <td class="text-right"><?= !empty(
                                        $bank_register['amount'])?$bank_register['amount']:0 ?></td>
                                        <td><?= $bank_register['narration'] ?></td>
                                        </tr>
	  <?php }?>
  <tr class="bg_gray bold">
    <td>Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td class="text-right"><?=$credit_amount;?></td>
    <td class="text-right"><?=$debit_amount;?></td>
    <td class="text-right"><?=$amount;?></td>
    <td></td>
  </tr>
</tbody>