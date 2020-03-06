<tr>
  <td class="text-right font-weight-bold">Balance</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class="text-center font-weight-bold" colspan="2">
    <?=sprintf('%0.2f',($total_credit_amt-$total_debit_amt) + $opening_balance['amount_balance']); ?>    
  </td>
  <td class="text-center font-weight-bold" colspan="2">
    <?=sprintf('%0.2f',($total_credit_weight-$total_debit_weight) + $opening_balance['weight_balance']); ?>    
  </td>
  <td class="text-center font-weight-bold"><?=sprintf('%0.2f',$opening_balance['purity_balance']+$total_purity_margin); ?></td>
</tr>