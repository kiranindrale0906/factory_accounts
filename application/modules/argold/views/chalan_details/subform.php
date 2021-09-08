<tr class="process_<?= $chittis['id']?>">
	<td>
		<?php load_field('checkbox', array('field' => 'chalan_id',
																		 	 'index' => $index,
																		 	 'class' => 'chalan_id',
																		 	 'option' => array(
																		 	 							array('chk_id' => $index,
																		                      'value' => $chittis['id'],
																		                      'label' => '',
																		                      'checked' => (!empty($chalan_details[$index]['chalan_id']) ? 'checked' : ''),
																		 	 						        )),
																		   'controller' => 'chalan_details'));?>																   
	</td>
  	<td class="text-right"><?= four_decimal($chittis['weight']) ;?></td>
	<td class="text-right"><?= four_decimal($chittis['purity']); ?></td>
	<td class="text-right"><?= four_decimal($chittis['cgst_amount']); ?></td>
	<td class="text-right"><?= four_decimal($chittis['sgst_amount']); ?></td>
	<td class="text-right"><?= four_decimal($chittis['taxable_amount']); ?></td>
	</tr>
