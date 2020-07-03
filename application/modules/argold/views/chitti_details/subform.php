<tr class="process_<?= $vouchers['id']?>">
	<td>
		<?php load_field('checkbox', array('field' => 'chitti_id',
																		 	 'index' => $index,
																		 	 'class' => 'chitti_details_id',
																		 	 'option' => array(
																		 	 							array('chk_id' => $index,
																		                      'value' => $vouchers['id'],
																		                      'label' => '',
																		                      'checked' => (!empty($chitti_details[$index]['chitti_id']) ? 'checked' : ''),
																		 	 						        )),
																		   'controller' => 'chitti_details'));?>
	</td>
	<td><?php echo $vouchers['voucher_number'];?></td>
    <td><?php echo $vouchers['voucher_date'];?></td>
    <td><?php echo $vouchers['account_name'];?></td>
	<td><?php echo $vouchers['credit_weight'];?></td>
	<td><?php echo $vouchers['purity'];?></td>
	<td><?php echo $vouchers['factory_purity'];?></td>
	<td><?php echo $vouchers['factory_fine']; ?></td>
	<td><?php echo $vouchers['narration']; ?></td>
</tr>