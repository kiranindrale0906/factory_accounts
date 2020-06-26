<tr>
  <?php if ($report != 'account ledger'): ?>
    <td><?= $record['account_name'];?></td>
  <?php endif; ?>
  <td><?= $record['voucher_date'] ?></td>
  <td><?= $record['voucher_number'];?></td>
  <td class="text-right"><?= four_decimal($record['debit_weight']) ?></td>
  <td class="text-right"><?= four_decimal($record['factory_purity'])?></td>
  <td class="text-right"><?= four_decimal(($record['debit_weight']*$record['purity'])/100); ?></td>
  <td class="text-right"><?= four_decimal($record['purity']) ?></td>
  <td class="text-right"><?= four_decimal(($record['debit_weight']*$record['factory_purity'])/100); ?></td>
  <?php if ($report != 'account ledger'): ?>
    <td class="text-right"><?= four_decimal(($record['factory_purity']-$record['purity'])*$record['debit_weight']/100); ?></td>
  <?php endif; ?>
</tr>