<tr class="process_<?= $vouchers['packet_no']?>">
	<td>
		<?php load_field('checkbox', array('field' => 'packing_slip_id',
																		 	 'index' => $index,
																		 	 'class' => 'packing_slip_details_id',
																		 	 'option' => array(
																		 	 							array('chk_id' => $index,
																		                      'value' => $vouchers['packet_no'].'-'.$vouchers['argold_id'],
																		                      'label' => '',
																		                      'checked' => (!empty($packing_slip_details[$index]['packing_slip_id']) ? 'checked' : ''),
																		 	 						        )),
																		   'controller' => 'packing_slip_details'));?>
	</td>
	<td><?php echo $vouchers['voucher_date'];?></td>
	<td><?php echo $vouchers['narration'];?> </td>
  	<td class="text-right"><?= (!empty($vouchers['customer_name'])&& $vouchers['customer_name']!='Market Issue')?($vouchers['customer_name']):'' ;?></td>
  	<td class="text-right"><?= four_decimal($vouchers['credit_weight']) ;?></td>
	<td class="text-right"><?= four_decimal($vouchers['purity']); ?></td>
	<td class="text-right"><?php load_field('plain/text', array('field' => 'packing_slip_net_weight',
			                             				  'class' => 'packing_slip_net_weight',
														  'index' => $index,
														  'controller' => 'packing_slip_details')); ?>
		
	</td>
	<td class="text-right"><?php load_field('plain/text', array('field' => 'packing_slip_quantity',
			                             				  'class' => 'packing_slip_quantity',
														  'index' => $index,
														  'controller' => 'packing_slip_details')); ?>
		
	</td>
	<td class="text-right"><?php load_field('plain/text', array('field' => 'packing_slip_stone',
			                             				  'class' => 'packing_slip_stone',
														  'index' => $index,
														  'controller' => 'packing_slip_details')); ?>
		
	</td>
	<td class="text-right"><?php load_field('plain/text', array('field' => 'packing_slip_making_charge',
			                             				  'class' => 'packing_slip_making_charge',
														  'index' => $index,
														  'controller' => 'packing_slip_details')); ?>
		
	</td>
	<td class=""><?php load_field('plain/text', array('field' => 'packing_slip_colour',
			                             				  'class' => 'packing_slip_colour',
														  'index' => $index,
														  'controller' => 'packing_slip_details')); ?>
		
	</td>
	<td class=""><?php load_field('plain/text', array('field' => 'packing_slip_code',
			                             				  'class' => 'packing_slip_code',
														  'index' => $index,
														  'controller' => 'packing_slip_details')); ?>
		
	</td>
	<td class=""><?php load_field('plain/text', array('field' => 'packing_slip_description',
			                             				  'class' => 'packing_slip_description',
														  'index' => $index,
														  'controller' => 'packing_slip_details')); ?></td>
    <td class="text-right"><?= four_decimal($vouchers['factory_purity']) ?></td>
    <td class="text-right"><?= four_decimal($vouchers['factory_purity'] - $vouchers['purity']) ?></td>
    <td class="text-right"><?= four_decimal($vouchers['credit_weight']*$vouchers['factory_purity']/100); ?></td>
</tr>
