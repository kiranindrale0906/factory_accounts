<tr class="process_<?= $vouchers['packet_no']?>">
	<td>
		<?php load_field('checkbox', array('field' => 'domestic_labour_chitti_id',
																		 	 'index' => $index,
																		 	 'class' => 'domestic_labour_chitti_details_id',
																		 	 'option' => array(
																		 	 							array('chk_id' => $index,
																		                      'value' => $vouchers['packet_no'].'-'.$vouchers['argold_id'],
																		                      'label' => '',
																		                      'checked' => (!empty($domestic_labour_chitti_details[$index]['domestic_labour_chitti_id']) ? 'checked' : ''),
																		 	 						        )),
																		   'controller' => 'domestic_labour_chitti_details'));?>
		<?php load_field('hidden', array('field' => 'voucher_id',
			                             				  'class' => 'voucher_id',
														  'index' => $index,
														  'value' => !empty($vouchers['id'])?$vouchers['id']:0,
														  'controller' => 'domestic_labour_chitti_details')); ?>																   
	</td>
	<td><?php echo $vouchers['voucher_date'];?></td>
	<td><?php echo $vouchers['narration'];?> </td>
  	<td class="text-right"><?= (!empty($vouchers['customer_name'])&& $vouchers['customer_name']!='Market Issue')?($vouchers['customer_name']):'' ;?></td>
  	
  	<td class="text-right"><?= four_decimal($vouchers['credit_weight']) ;?></td>
  	<td class="text-right"><?php load_field('plain/text', array('field' => 'rate',
			                             				  'class' => 'rate',
														  'index' => $index,
														  'value' => !empty($vouchers['rate'])?$vouchers['rate']:0,
														  'controller' => 'domestic_labour_chitti_details')); ?>
		
	</td>
	<td class="text-right"><?= four_decimal($vouchers['purity']); ?></td>
	<td class="text-right"><?= four_decimal($vouchers['factory_purity']); ?></td>
	<td class="text-right"><?= four_decimal($vouchers['fine']); ?></td>
	<td class="text-right"><?= four_decimal($vouchers['factory_fine']); ?></td>
</tr>
