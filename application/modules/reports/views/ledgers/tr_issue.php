<tr>
  <?php if ($report == 'vadotar report'): ?>
    <td><?= $record['receipt_type'];?></td>
  <?php endif; ?>
  <?php if ($report != 'account ledger'): ?>
    <td><?= $record['account_name'];?></td>
  <?php endif; ?>
  <td><?= $record['str_voucher_date'] ?></td>
  <td><?= $record['voucher_number'].' '.$record['narration'].' '.$record['description'].' chitti '.$record['chitti_id'];?></td>
  <td class="text-right"><?= four_decimal($record['credit_weight']) ?></td>
  <td class="text-right"><?= four_decimal($record['purity']) ?></td>
  <td class="text-right"><?= four_decimal($record['credit_weight']*$record['purity']/100); ?></td>
  <td class="text-right"><?= four_decimal($record['factory_purity']) ?></td>
  <td class="text-right"><?= four_decimal($record['credit_weight']*$record['factory_purity']/100); ?></td>
  <?php if ($report != 'account ledger'): ?>
    <td class="text-right"><?= four_decimal(($record['purity']-$record['factory_purity'])*$record['credit_weight']/100) ?></td>
  <?php else: ?>
    <td class="text-right"><?= four_decimal($record['credit_amount'], '-') ?></td>
  <?php endif; ?>
</tr>