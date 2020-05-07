<tbody>
<?php 
$credit_amount=$debit_amount=$amount=0;
if(isset($opening_balance['opening_balance']) && $opening_balance['opening_balance']<0)
 $debit_amount = $opening_balance['opening_balance'];

if(isset($opening_balance['opening_balance']) && $opening_balance['opening_balance']>0)
 $credit_amount = $opening_balance['opening_balance']; 
?>
  <tr>
    <td></td>
    <td>Opening Balance</td>
    <td></td>
    <td></td>
    <td class="text-right"> <?php if(!empty($credit_amount)) { echo decimal_number_format($credit_amount); } ?>
    <td class="text-right"><?php if(!empty($debit_amount)) { echo decimal_number_format($debit_amount); } ?> </td>
    <td></td>
  </tr>

<?php foreach ($cash_registers as $index => $cash_register){ 
       $credit_amount+= $cash_register['credit_amount'];
       $debit_amount+= $cash_register['debit_amount'];
       $amount+=$cash_register['amount'];
  ?>
	    <tr>
          <td><?= ++$index; ?></td>
          <td ><?= date('d-m-y', strtotime($cash_register['created_at'])) ?></td>
          <td><?= $cash_register['voucher_number'] ?></td>
          <td><?= $cash_register['account_name'] ?></td>
          <td class="text-right"><?=!empty($cash_register['credit_amount'])?$cash_register['credit_amount']:0; ?></td>
          <td class="text-right"><?= !empty($cash_register['debit_amount'])?$cash_register['debit_amount']:0 ?></td>
          <td><?= $cash_register['narration'] ?></td>
      </tr>
	  <?php }?>
    <tr class="bg_gray bold">
      <td>Total</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="text-right"><?=decimal_number_format($credit_amount);?></td>
      <td class="text-right"><?=decimal_number_format($debit_amount);?></td>
      <td></td>
    </tr>
    <?php
      $balance = $credit_amount - $debit_amount;
    ?>
    <tr class="bg_gray bold">
      <td>Balance</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="text-right"><?=($balance>0) ? decimal_number_format($balance) :"" ?></td>
      <td class="text-right"><?=($balance<0) ? decimal_number_format(($balance*-1)) : ""?></td>
      <td></td>
    </tr>
</tbody> 



 

