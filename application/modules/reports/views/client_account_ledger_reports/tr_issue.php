<tr>
  <td><?= $record['account_name'];?></td>
  <td class="text-right"><?= four_decimal($record['credit_weight']); ?></td>
  <td class="text-right"><?= four_decimal($record['credit_weight']*$record['purity']/100); ?></td>
</tr>