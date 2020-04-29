<tbody>
<?php  foreach ($rate_cut_purchase_value_registers as $index => $rate_cut_purchase_value_register){ ?>
	   <tr>
                                        <td><?= ++$index; ?></td>
                                        <td ><?= date('d-m-y', strtotime($rate_cut_purchase_value_register['created_at'])) ?></td>
                                        <td><?= $rate_cut_purchase_value_register['voucher_number'] ?></td>
                                        <td><?= $rate_cut_purchase_value_register['account_name'] ?></td>
                                        <td class="text-right"><?= $rate_cut_purchase_value_register['amount'] ?></td>
                                        <td class="text-right"><?= $rate_cut_purchase_value_register['gold_weight'] ?></td>
                                        <td class="text-right"><?= $rate_cut_purchase_value_register['purity'] ?></td>
                                        <td class="text-right"><?= $rate_cut_purchase_value_register['credit_amount'] ?></td>
                                        <td class="text-right"><?= $rate_cut_purchase_value_register['debit_amount'] ?></td>
                                       </tr>
	  <?php }?>
</tbody> 