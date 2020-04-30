<tbody>
<?php  foreach ($cash_registers as $index => $cash_register){ ?>
	   <tr>
                                        <td><?= ++$index; ?></td>
                                        <td ><?= date('d-m-y', strtotime($cash_register['created_at'])) ?></td>
                                        <td><?= $cash_register['voucher_number'] ?></td>
                                        <td><?= $cash_register['account_name'] ?></td>
                                        <td class="text-right"><?= $cash_register['credit_amount'] ?></td>
                                        <td class="text-right"><?= $cash_register['debit_amount'] ?></td>
                                        <td class="text-right"><?= $cash_register['amount'] ?></td>
                                        <td><?= $cash_register['narration'] ?></td>
                                        </tr>
	  <?php }?>
</tbody> 