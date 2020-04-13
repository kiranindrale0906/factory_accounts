<tr>
  <td><?= $record['account_name'];?></td>
  <td><?= $record['voucher_date'] ?></td>
  <td><?= $record['narration'];?></td>
  <td class="text-right"><?= four_decimal($record['credit_weight']); ?></td>
  <td class="text-right"><?= four_decimal($record['purity']); ?></td>
  <td class="text-right"><?= four_decimal($record['credit_weight']*$record['purity']/100); ?></td>
  <td class="text-right"><?= four_decimal($record['factory_purity']) ?></td>
  <td class="text-right"><?= four_decimal($record['credit_weight']*$record['factory_purity']/100); ?></td>
  <?php if ($record['account_name'] == 'Opening') { ?>
    <td class="text-right">74180.7900</td>
  <?php } else { ?>
    <td class="text-right"><?= four_decimal(($record['purity']-$record['factory_purity'])*$record['credit_weight']/100); ?></td>
  <?php } ?>
</tr>
