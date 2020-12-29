<tr>
  <?php if ($report_type == 'Vadotar Report'): ?>
    <td><?= $record['receipt_type'];?></td>
  <?php endif; ?>
  <?php if ($report_type != 'Account Ledger'): ?>
    <td><?= $record['account_name'];?></td>
  <?php endif; ?>
  <td><?= $record['str_voucher_date'] ?></td>
  <td><?= $record['voucher_number'].' '.$record['narration'].' '.$record['description'].' '.$record['chitti_no']; ?>
     <?php if(isset($record['chitti_no']) && $record['chitti_no']!=0){ ?>
        <a class=""  href='<?= base_url() ?>argold/chittis/view/<?=$record['chitti_no']?>'>view</a>
     <?php  }
    ?>
  </td>
  <td class="text-right"><?= four_decimal($record['debit_weight'], '-') ?></td>
  <td class="text-right"><?= four_decimal($record['factory_purity'], '-')?></td>
  <td class="text-right"><?= four_decimal($record['factory_fine'], '-'); ?></td>
  <td class="text-right"><?= four_decimal($record['purity'], '-') ?></td>
  <td class="text-right"><?= four_decimal($record['fine'], '-'); ?></td>
  <?php if ($report_type == 'Vadotar Report' || $report_type == 'Production Report'): ?>
    <td class="text-right"><?= four_decimal($record['fine']-$record['factory_fine'], '-'); ?></td>
    <td class="text-right"><?= four_decimal(($record['fine']-$record['factory_fine']) / $record['debit_weight'] * 100, '-'); ?></td>
  <?php elseif ($report_type == 'Account Ledger'): ?>
    <td class="text-right"><?= four_decimal($record['debit_amount'], '-'); ?></td>
  <?php endif; ?>
</tr>
