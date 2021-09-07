<tbody>
  <?php 
  $gross_weight=$net_weight=$fine_weight=0;
  foreach ($sales_registers as $index => $sales_registers){
    $gross_weight+=$sales_registers['total_gross_weight'];
    $net_weight+=$sales_registers['total_net_weight'];
    $fine_weight+=$sales_registers['total_fine_weight']; ?>
	   <tr>
      <td><?= ++$index; ?></td>
      <td ><?= date('d-m-y', strtotime($sales_registers['created_at'])) ?></td>
      <td><?= $sales_registers['voucher_number'] ?></td>
      <td><?= $sales_registers['account_name'] ?></td>
      <td class="text-right"><?= !empty($sales_registers['total_gross_weight'])?$sales_registers['total_gross_weight']:"0.0000"; ?></td>
      <td class="text-right"><?= !empty($sales_registers['total_net_weight'])?$sales_registers['total_net_weight']:"0.0000"; ?></td>
      <td class="text-right"><?= !empty($sales_registers['total_fine_weight'])?$sales_registers['total_fine_weight']:"0.0000"; ?></td>
    </tr>
	 <?php }?>
  <tr class="bg_gray bold">
    <td>Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td class="text-right"><?=decimal_number_format($gross_weight);?></td>
    <td class="text-right"><?=decimal_number_format($net_weight);?></td>
    <td class="text-right"><?=decimal_number_format($fine_weight);?></td>
  </tr>
</tbody> 
  
    
