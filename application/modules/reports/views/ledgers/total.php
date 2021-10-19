<?php if (( @$record['credit_weight'] + @$record['debit_weight'] 
          + $record['fine'] + $record['factory_fine'] 
          + @$record['credit_amount'] + @$record['debit_amount']) != 0) { ?>
  <tr class="bold">
    <td></td>
    <td><?= $label ?></td>
    <?php if ($report_type == 'Vadotar Report'): ?>
      <td></td>
      <td></td>
    <?php endif; ?>
    <?php if ($report_type == 'Production Report'): ?>
      <td></td>
    <?php endif; ?>
    <?php if ($type=='issue') {?>  
      <td class="text-right"><?= four_decimal($record['credit_weight'], '-'); ?></td>
   <td></td>
      <td class="text-right"><?= four_decimal($record['fine'], '-') ?></td>
      <td></td>
      <td class="text-right"><?= four_decimal($record['factory_fine'], '-') ?></td>
    <?php } else { ?>  
      <td class="text-right"><?= four_decimal($record['debit_weight'], '-'); ?></td>
      <?php if (!in_array($report_type, array("Export Purchase Ledger","Domestic Purchase Ledger","Domestic Sale Ledger","Export Sale Ledger"))): ?>
  
      <td></td>
    <?php endif;?>
      <td class="text-right"><?= four_decimal($record['factory_fine'], '-') ?></td>
      <td></td>
      <td class="text-right"><?= four_decimal($record['fine'], '-') ?></td>
    <?php } ?>
    <?php if ($report_type == 'Vadotar Report' || $report_type == 'Production Report'): 
      if (isset($record['credit_weight']) && $record['credit_weight'] > 0): ?>
        <td class="text-right"><?= four_decimal($record['factory_fine'] - $record['fine'], '-'); ?></td>
        <td class="text-right"><?= four_decimal(($record['factory_fine'] - $record['fine']) / $record['credit_weight'] * 100, '-'); ?></td>
      <?php elseif (isset($record['debit_weight']) && $record['debit_weight'] > 0): ?>
        <td class="text-right"><?= four_decimal($record['fine'] - $record['factory_fine'], '-'); ?></td>
        <td class="text-right"><?= four_decimal(($record['fine'] - $record['factory_fine']) / $record['debit_weight'] * 100, '-'); ?></td>
      <?php else: ?>
        <td></td>
        <td></td> 
      <?php endif; ?>
    <?php endif; ?>
    <?php if ($report_type == 'Account Ledger' || $report_type == 'Vadotar Report'): ?>
      <?php if ($type=='issue') { ?>
        <td class="text-right"><?= four_decimal($record['credit_amount'], '-') ?></td>
        <td class="text-right"><?= four_decimal($record['usd_credit_amount'], '-') ?></td>
      <?php } else { ?> 
        <td class="text-right"><?= four_decimal($record['debit_amount'], '-') ?></td>
        <td class="text-right"><?= four_decimal($record['usd_debit_amount'], '-') ?></td>
      <?php } ?>
    <?php endif; ?>
  </tr>
<?php } ?>