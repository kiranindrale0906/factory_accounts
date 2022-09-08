<tr class="process_<?= $vouchers['packet_no']?>">
	<td>
		<?php load_field('checkbox', array('field' => 'chitti_id',
																		 	 'index' => $index,
																		 	 'class' => 'chitti_details_id',
																		 	 'option' => array(
																		 	 							array('chk_id' => $index,
																		                      'value' => $vouchers['packet_no'].'-'.$vouchers['argold_id'],
																		                      'label' => '',
																		                      'checked' => (!empty($chitti_details[$index]['chitti_id']) ? 'checked' : ''),
																		 	 						        )),
																		   'controller' => 'chitti_details'));?>
	</td>
	<td><?php echo $vouchers['packet_no'];?></td>
	<td><?php echo $vouchers['voucher_date'];?></td>
	<td><?php echo $vouchers['narration'];?> 
	<a href=<?= get_api_url_from_site_name($record['site_name'])."issue_departments/issue_departments/view/".$vouchers['argold_id'] ?> target='_blank'>View</a></td>
        <td class="text-right"><?= (!empty($vouchers['customer_name'])&& $vouchers['customer_name']!='Market Issue')?($vouchers['customer_name']):'' ;?></td>
	<td class="quantity"><?php echo $vouchers['quantity'];?></td>
  	<td class="text-right"><?= four_decimal($vouchers['credit_weight']) ;?></td>
	<td class="text-right"><?= four_decimal($vouchers['purity']); ?></td>
        <td class="text-right"><?= four_decimal($vouchers['factory_purity'] - $vouchers['purity']) ?></td>
    <?php if($this->router->class == 'chitti_exports'){ ?>
    <td class="text-right"><?= four_decimal($vouchers['usd_wastage_percentage']) ?></td>
    <td class="text-right"><?= four_decimal($vouchers['inr_wastage_percentage']) ?></td>
	<?php }?>
	<td class="text-right"><?= four_decimal($vouchers['credit_weight']*$vouchers['factory_purity']/100); ?></td>
</tr>
