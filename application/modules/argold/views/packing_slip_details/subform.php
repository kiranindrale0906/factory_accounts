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
		<?php load_field('hidden', array('field' => 'voucher_id',
			                             				  'class' => 'voucher_id',
														  'index' => $index,
														  'value' => !empty($vouchers['id'])?$vouchers['id']:0,
														  'controller' => 'packing_slip_details')); ?>																   
	</td>
	<td><?php echo $vouchers['voucher_date'];?></td>
	<td><?php echo $vouchers['narration'];?> </td>
  	<td class="text-right"><?= (!empty($vouchers['customer_name'])&& $vouchers['customer_name']!='Market Issue')?($vouchers['customer_name']):'' ;?></td>
  	<td class="text-right"><?= four_decimal($vouchers['credit_weight']) ;?></td>
  	<td class="text-right"><?= four_decimal($vouchers['packing_slip_balance']) ;?></td>
	<td class="text-right"><?= four_decimal($vouchers['purity']); ?></td>
	<td class="text-right"><?php load_field('plain/text', array('field' => 'packing_slip_gross_weight',
			                             				  'class' => 'packing_slip_net_weight',
														  'index' => $index,
														  'value' => !empty($vouchers['packing_slip_gross_weight'])?$vouchers['packing_slip_gross_weight']:0,
														  'controller' => 'packing_slip_details')); ?>
		
	</td>
	<td class="text-right"><?php load_field('plain/text', array('field' => 'packing_slip_quantity',
			                             				  'class' => 'packing_slip_quantity',
														  'index' => $index,
														  'value' => !empty($vouchers['packing_slip_quantity'])?$vouchers['packing_slip_quantity']:0,
														  'controller' => 'packing_slip_details')); ?>
		
	</td>
	
	<td class="text-right"><?php load_field('plain/text', array('field' => 'packing_slip_stone',
			                             				  'class' => 'packing_slip_stone',
														  'index' => $index,
														  'value' => !empty($vouchers['packing_slip_stone'])?$vouchers['packing_slip_stone']:0,
														  'controller' => 'packing_slip_details')); ?>
		
	</td>
	<td class="text-right"><?php load_field('plain/text', array('field' => 'packing_slip_making_charge',
			                             				  'class' => 'packing_slip_making_charge',
														  'index' => $index,
														  'value' => !empty($vouchers['packing_slip_making_charge'])?$vouchers['packing_slip_making_charge']:0,
														  'controller' => 'packing_slip_details')); ?>
		
	</td>
	<td class="text-right"><?php load_field('plain/dropdown', array('field' => 'packing_slip_category_name',
			                             				  'class' => 'packing_slip_category_name',
														  'index' => $index,
														  'option'=>array(array('id'=>'CZ','name'=>'CZ'),
														  				  array('id'=>'Meena','name'=>'Meena'),
														  				  array('id'=>'Pearls','name'=>'Pearls'),
														  				  array('id'=>'Plastic','name'=>'Plastic'),
														  				  array('id'=>'Rudraksh','name'=>'Rudraksh')),
														  'value' => !empty($vouchers['packing_slip_category_name'])?$vouchers['packing_slip_category_name']:'',
														  'controller' => 'packing_slip_details')); ?>
		
	</td>
	<td class=""><?php load_field('plain/text', array('field' => 'packing_slip_colour',
			                             				  'class' => 'packing_slip_colour',
														  'index' => $index,
														  'value' => !empty($vouchers['packing_slip_colour'])?$vouchers['packing_slip_colour']:'',
														  'controller' => 'packing_slip_details')); ?>
		
	</td>
	<td class=""><?php load_field('plain/text', array('field' => 'packing_slip_code',
			                             				  'class' => 'packing_slip_code',
														  'index' => $index,
														  'value' => !empty($vouchers['packing_slip_code'])?$vouchers['packing_slip_code']:'',
														  'controller' => 'packing_slip_details')); ?>
		
	</td>
	<td class=""><?php load_field('plain/text', array('field' => 'packing_slip_description',
			                             				  'class' => 'packing_slip_description',
			                             				  'value' => !empty($vouchers['packing_slip_description'])?$vouchers['packing_slip_description']:'',
														  'index' => $index,
														  'controller' => 'packing_slip_details')); ?></td>
    <td class="text-right"><?= four_decimal($vouchers['factory_purity']) ?></td>
    <td class="text-right"><?= four_decimal($vouchers['factory_purity'] - $vouchers['purity']) ?></td>
    <td class="text-right"><?= four_decimal($vouchers['credit_weight']*$vouchers['factory_purity']/100); ?></td>
    <td class="text-right"><?= four_decimal($vouchers['site_name']) ?></td>
</tr>
