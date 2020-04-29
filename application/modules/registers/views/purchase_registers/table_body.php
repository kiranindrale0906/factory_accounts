<tbody>
<?php  foreach ($purchase_registers as $index => $purchase_register){ ?>
	   <tr>
                                        <td><?= ++$index; ?></td>
                                        <td ><?= date('d-m-y', strtotime($purchase_register['created_at'])) ?></td>
                                        <td><?= $purchase_register['voucher_number'] ?></td>
                                        <td><?= $purchase_register['account_name'] ?></td>
                                        <td class="text-right"><?= $purchase_register['total_gross_weight'] ?></td>
                                        <td class="text-right"><?= $purchase_register['total_net_weight'] ?></td>
                                        <td class="text-right"><?= $purchase_register['total_fine_weight'] ?></td>
                                        </tr>
	  <?php }?>
</tbody> 