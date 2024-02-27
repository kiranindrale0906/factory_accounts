<tr>
  <?php 
  $reference_account_name=($report_type == 'Account Ledger')?$record['reference_account_name'] : "";
  
  if ($report_type == 'Vadotar Report'): ?>
    <td><?= $record['receipt_type'];?></td>
  <?php endif; ?>
  <?php if ($report_type != 'Account Ledger'): ?>
    <td><?= $record['account_name'];?></td>
  <?php endif; ?>
  <td><?= date('d-m-y', strtotime($record['str_voucher_date'])); ?></td>
  <?php if (!in_array($report_type, array("Export Purchase Ledger","Domestic Purchase Ledger","Domestic Sale Ledger","Export Sale Ledger"))): ?>
  <td><?= '#'.$record['chitti_no'].' '.remove_duplicates_in_string($record['narration']).' '.$record['description'].' '.$reference_account_name; ?>
    <?php if(isset($record['chitti_no']) && $record['chitti_no']!=0) { ?>
      <a class=""  href='<?= base_url() ?>argold/chittis/view/<?=$record['chitti_no']?>'>view</a>
      <!-- <?php //if ($record['account_name'] == 'OUTSIDE PARTY') { ?>
        | <a class="" href='<?//= base_url() ?>argold/change_account_names/index?chitti_no=<?//=$record['chitti_no']?>&account_name=SS1'>SS1</a>
      <?php //} ?>  --> 
    <?php } ?>
  </td>
  <?php endif; ?>
  <td class="text-right"><a class=""  href='<?= base_url() ?>argold/voucher_details/view/<?=$record['chitti_no']?>'><?= four_decimal($record['debit_weight'], '-') ?></a></td>
  <td class="text-right"><?= four_decimal($record['factory_purity'], '-')?></td>
  <td class="text-right"><?= four_decimal($record['factory_fine'], '-'); ?></td>
  <?php if (!in_array($report_type, array("Export Purchase Ledger","Domestic Purchase Ledger","Domestic Sale Ledger","Export Sale Ledger"))): ?>
  <td class="text-right"><?= four_decimal($record['purity'], '-') ?></td>
  <?php endif; ?>
  <td class="text-right"><?= four_decimal($record['fine'], '-'); ?></td>
  <?php if($report_type == "Gross Profit Report"):?>
    <td class="text-right">0</td>
  <?php endif; ?>
  <?php if ($report_type == 'Vadotar Report' || $report_type == 'Production Report'): ?>
    <td class="text-right"><?= four_decimal($record['fine']-$record['factory_fine'], '-'); ?></td>
    <?php if ($record['debit_weight'] != 0) { ?>
      <td class="text-right"><?= four_decimal(($record['fine']-$record['factory_fine']) / $record['debit_weight'] * 100, '-'); ?></td>
    <?php } else { ?>
      <td>-</td>
    <?php } ?>
  <?php endif; ?>
  <?php if ($report_type == 'Domestic Labour Ledger' || $report_type == 'Export Labour Ledger' ||$report_type == 'Account Ledger' || $report_type == 'Purchase Labour Ledger' || $report_type == 'Vadotar Report' ||$report_type == 'Purchase Sales Ledger'): ?>
    <td class="text-right"><a class=""  href='<?= base_url() ?>argold/voucher_details/view/<?=$record['chitti_no']?>'><?= four_decimal($record['debit_amount'], '-'); ?></a></td>
    <td class="text-right"><?= four_decimal($record['usd_debit_amount'], '-') ?></td>
    <?php if($report_type == 'Purchase Sales Ledger'){ ?>
        <td class="text-right"><?= four_decimal($record['chitti_credit_weight'], '-') ?></td>
        <td class="text-right"><?= @($record['chitti_account_name']) ?></td>
      <?php } ?>
    <?php if($report_type == 'Account Ledger'){ ?>
        <td class="text-right"><?= ($reference_account_name) ?></td>
      <?php } ?>
  
  <?php endif; ?>
</tr>
