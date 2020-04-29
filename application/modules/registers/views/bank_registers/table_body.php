<tbody>
<?php  foreach ($bank_registers as $index => $bank_register){ ?>
	   <tr>
                                        <td><?= ++$index; ?></td>
                                        <td ><?= date('d-m-y', strtotime($bank_register['created_at'])) ?></td>
                                        <td><?= $bank_register['voucher_number'] ?></td>
                                        <td><?= $bank_register['account_name'] ?></td>
                                        <td><?= $bank_register['bank_name'] ?></td>
                                        <td class="text-right"><?= $bank_register['credit_amount'] ?></td>
                                        <td class="text-right"><?= $bank_register['debit_amount'] ?></td>
                                        <td class="text-right"><?= $bank_register['amount'] ?></td>
                                        <td><?= $bank_register['narration'] ?></td>
                                        </tr>
	  <?php }?>
</tbody> 