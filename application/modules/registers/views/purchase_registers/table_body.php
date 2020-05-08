<tbody>
<?php  
    $gross_weight=$net_weight=$fine_weight=0;
   foreach ($purchase_registers as $index => $purchase_register){ 
        $gross_weight+=$purchase_register['total_gross_weight'];
        $net_weight+=$purchase_register['total_net_weight'] ;
        $fine_weight+=$purchase_register['total_fine_weight'];

?>
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