<tbody>
<?php  
		$debit_amount=0;
		foreach ($expense_registers as $index => $expense_register){ 
			$debit_amount+=$expense_register['debit_amount'];
			?>
	   <tr>
                                        <td><?= ++$index; ?></td>
                                        <td ><?= date('d-m-y', strtotime($expense_register['created_at'])) ?></td>
                                        <td><?= $expense_register['voucher_number'] ?></td>
                                        <td><?= $expense_register['account_name'] ?></td>
                                        <td class="text-right"><?= !empty($expense_register['debit_amount'])?$expense_register['debit_amount']:0 ?></td>
                                        <td><?= $expense_register['narration'] ?></td>
                                        </tr>
	  <?php }?>
<tr class="bg_gray bold">
    <td>Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td class="text-right"><?=four_decimal($debit_amount);?></td>
    <td class="text-right"></td>
  </tr>
</tbody> 