<tr class="process_<?= $vouchers['packet_no']?>">
	<td>
		<?php load_field('checkbox', array('field' => 'chitti_id',
																		 	 'index' => $index,
																		 	 'class' => 'chitti_details_id',
																		 	 'option' => array(
																		 	 							array('chk_id' => $index,
																		                      'value' => $vouchers['packet_no'],
																		                      'label' => '',
																		                      'checked' => (!empty($chitti_details[$index]['chitti_id']) ? 'checked' : ''),
																		 	 						        )),
																		   'controller' => 'chitti_details'));?>
	</td>
	<td><?php echo $vouchers['packet_no'];?></td>
	<td><?php echo $vouchers['voucher_date'];?></td>
	<td><?php echo $vouchers['narration'];?></td>
  <td class="text-right"><?= four_decimal($vouchers['credit_weight']) ;?></td>
	<td class="text-right"><?= four_decimal($vouchers['purity']); ?></td>
        <td class="text-right"><?= four_decimal($vouchers['factory_purity'] - $vouchers['purity']) ?></td>
	<td class="text-right"><?//= //four_decimal($vouchers['factory_fine']); ?></td>
</tr>
