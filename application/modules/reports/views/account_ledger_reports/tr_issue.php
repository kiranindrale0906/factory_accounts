<tr>
  <td><?= $record['account_name'];?></td>
  <td><?= $record['voucher_date'] ?></td>
  <td><?= $record['narration'];?></td>
  <td class="text-right"><?= $record['credit_weight'] ?></td>
  <td class="text-right"><?=$record['purity'] ?></td>
  <td class="text-right"><?= $record['credit_weight']*$record['purity']/100; ?></td>
  <td class="text-right"><?=$record['factory_purity'] ?></td>
  <td class="text-right"><?= $record['credit_weight']*$record['factory_purity']/100; ?></td>
  <td class="text-right"><?=($record['purity']-$record['factory_purity'])*$record['credit_weight']/100 ?></td>
</tr>