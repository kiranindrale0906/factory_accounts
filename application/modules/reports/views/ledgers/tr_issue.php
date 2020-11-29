<tr>
  <?php if ($report_type == 'Vadotar Report'): ?>
    <td><?= $record['receipt_type'];?></td>
  <?php endif; ?>
  <?php if ($report_type != 'Account Ledger'): ?>
    <td><?= $record['account_name'];?></td>
  <?php endif; ?>
  <td><?= $record['str_voucher_date'] ?></td>
  <td>
    <?php
      echo $record['voucher_number'].' '.$record['narration'].' '.$record['description'].' '.$record['chitti_no'];
      if ($record['voucher_type'] == 'metal issue voucher')
        echo ' '.$record['chitti_no'];
    ?>
  </td>
  <td class="text-right"><?= four_decimal($record['credit_weight'], '-') ?></td>
  <td class="text-right"><?= four_decimal($record['purity'], '-') ?></td>
  <td class="text-right"><?= four_decimal($record['fine'], '-'); ?></td>
  <td class="text-right"><?= four_decimal($record['factory_purity'], '-') ?></td>
  <td class="text-right"><?= four_decimal($record['factory_fine'], '-'); ?></td>
  <?php if ($report_type == 'Vadotar Report'): ?>
    <td class="text-right"><?= four_decimal($record['factory_fine']-$record['fine'], '-'); ?></td>
  <?php elseif ($report_type == 'Account Ledger'): ?>
    <td class="text-right"><?= four_decimal($record['credit_amount'], '-') ?></td>
  <?php endif; ?>
</tr>