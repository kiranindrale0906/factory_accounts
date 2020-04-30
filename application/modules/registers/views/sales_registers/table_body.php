<tbody>
<?php  foreach ($sales_registers as $index => $sales_registers){ ?>
	   <tr>
                                        <td><?= ++$index; ?></td>
                                        <td ><?= date('d-m-y', strtotime($sales_registers['created_at'])) ?></td>
                                        <td><?= $sales_registers['voucher_number'] ?></td>
                                        <td><?= $sales_registers['account_name'] ?></td>
                                        <td class="text-right"><?= $sales_registers['total_gross_weight'] ?></td>
                                        <td class="text-right"><?= $sales_registers['total_net_weight'] ?></td>
                                        <td class="text-right"><?= $sales_registers['total_fine_weight'] ?></td>
                                        </tr>
	  <?php }?>
</tbody> 