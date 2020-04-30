<tbody>
<?php  foreach ($rate_cut_purchase_weight_registers as $index => $rate_cut_purchase_weight_register){ ?>
	   <tr>
                                        <td><?= ++$index; ?></td>
                                        <td ><?= date('d-m-y', strtotime($rate_cut_purchase_weight_register['created_at'])) ?></td>
                                        <td><?= $rate_cut_purchase_weight_register['voucher_number'] ?></td>
                                        <td><?= $rate_cut_purchase_weight_register['account_name'] ?></td>
                                         <td class="text-right"><?= $rate_cut_purchase_weight_register['amount'] ?></td>
                                         <td class="text-right"><?= $rate_cut_purchase_weight_register['gold_rate'] ?></td>
                                         <td class="text-right"><?= $rate_cut_purchase_weight_register['purity'] ?></td>
                                        <td class="text-right"><?= $rate_cut_purchase_weight_register['credit_weight'] ?></td>
                                        <td class="text-right"><?= $rate_cut_purchase_weight_register['debit_amount'] ?></td>
                                        </tr>
	  <?php }?>
</tbody> 