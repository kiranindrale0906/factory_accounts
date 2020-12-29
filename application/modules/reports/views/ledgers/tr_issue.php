<tr>
  <?php if ($report_type == 'Vadotar Report'): ?>
    <td><?= $record['receipt_type'];?></td>
  <?php endif; ?>
  <?php if ($report_type != 'Account Ledger'): ?>
    <td><?= $record['account_name'];?></td>
  <?php endif; ?>
  <td><?= date('d-m-y', strtotime($record['str_voucher_date'])); ?></td>
  <td>
    <?php
      //if (!empty($record['chitti_no']))
        echo ' #'.$record['chitti_no'].' '.remove_duplicates_in_string($record['narration']).' '.$record['description'];
      // else
      //   echo $record['voucher_number'].' '.remove_duplicates_in_string($record['narration']).' '.$record['description'];
      
      if (isset($record['chitti_no']) && $record['chitti_no']!=0) { ?>
        <a class=""  href='<?= base_url() ?>argold/chittis/view/<?=$record['chitti_no']?>'>view</a>
      <?php if ($record['account_name'] == 'SWARN SHILP CHAINS AND JEWELLERS PVT LTD') { ?>
        | <a class="" href='<?= base_url() ?>argold/change_account_names/index?chitti_no=<?=$record['chitti_no']?>&account_name=SS1'>SS1</a>
      <?php } ?>  
    <?php } ?>
  </td>
  <td class="text-right"><?= four_decimal($record['credit_weight'], '-') ?></td>
  <td class="text-right"><?= four_decimal($record['purity'], '-') ?></td>
  <td class="text-right"><?= four_decimal($record['fine'], '-'); ?></td>
  <td class="text-right"><?= four_decimal($record['factory_purity'], '-') ?></td>
  <td class="text-right"><?= four_decimal($record['factory_fine'], '-'); ?></td>
  <?php if ($report_type == 'Vadotar Report' || $report_type == 'Production Report'): ?>
    <td class="text-right"><?= four_decimal($record['factory_fine']-$record['fine'], '-'); ?></td>
    <td class="text-right"><?= four_decimal(($record['factory_fine']-$record['fine']) / $record['credit_weight'] * 100, '-'); ?></td>
  <?php elseif ($report_type == 'Account Ledger'): ?>
    <td class="text-right"><?= four_decimal($record['credit_amount'], '-') ?></td>
  <?php endif; ?>
</tr>