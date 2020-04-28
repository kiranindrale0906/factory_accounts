<tbody>
<?php  foreach ($account_ledgers as $index => $account_ledger){ ?>
	   <tr>
                                        <td><?= ++$index; ?></td>
                                        <td ><?= date('d-m-y', strtotime($account_ledger['created_at'])) ?></td>
                                        <td><?= $account_ledger['account_name'] ?></td>
                                        <td><?= $account_ledger['voucher_type'] ?></td>
                                        <td><?= $account_ledger['voucher_number'] ?></td>
                                        <td class="text-right"><?= $account_ledger['credit_amount'] ?></td>
                                        <td class="text-right"><?= $account_ledger['debit_amount'] ?></td>
                                        <td class="text-right"><?= $account_ledger['credit_weight'] ?></td>
                                        <td class="text-right"><?= $account_ledger['debit_weight'] ?></td>
                                    </tr>
	  <?php }?>
</tbody> 