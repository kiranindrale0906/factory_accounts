<tbody>
<?php  
$credit_amount=$debit_amount=$amount=0;
if(isset($opening_balance['opening_balance']) && $opening_balance['opening_balance']<0)
 $debit_amount = $opening_balance['opening_balance'];

if(isset($opening_balance['opening_balance']) && $opening_balance['opening_balance']>0)
 $credit_amount = $opening_balance['opening_balance'];  ?>

<tr>
  <td></td>
  <td>Opening Balance</td>
  <td></td>
  <td></td>
  <td></td>
  <td class="text-right"> <?php if(!empty($credit_amount)) { echo decimal_number_format($credit_amount); } ?>
  <td class="text-right"><?php if(!empty($debit_amount)) { echo decimal_number_format($debit_amount); } ?> </td>
  <td></td>
</tr>
<?php foreach ($bank_registers as $index => $bank_register) { 
        $credit_amount+= $bank_register['credit_amount'];
        $debit_amount+= $bank_register['debit_amount'];
        $amount+=$bank_register['amount'];  ?>
	   <tr>
        <td><?= ++$index; ?></td>
        <td ><?= date('d-m-y', strtotime($bank_register['created_at'])) ?></td>
        <td><?=$bank_register['voucher_number'] ?></td>
        <td><?= $bank_register['account_name'] ?></td>
        <td><?= $bank_register['bank_name'] ?></td>
        <td class="text-right">
          <?=!empty($bank_register['credit_amount'])? decimal_number_format($bank_register['credit_amount']):0 ?></td>
        <td class="text-right">
          <?=!empty($bank_register['debit_amount'])? decimal_number_format($bank_register['debit_amount']):0; ?> </td>
        <td><?= $bank_register['narration'] ?></td>
      </tr>
	  <?php }?>
  <tr class="bg_gray bold">
    <td>Total</td>
    <td></td>
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
      <td></td>
      <td class="text-right"><?=($balance>0) ? decimal_number_format($balance) :"" ?></td>
      <td class="text-right"><?=($balance<0) ? decimal_number_format(($balance*-1)) : ""?></td>
      <td></td>
      
    </tr>
</tbody>