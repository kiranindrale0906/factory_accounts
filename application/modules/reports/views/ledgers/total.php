<tr class="bold">
  <td><?= $label ?></td>
  <?php if ($report != 'account ledger'): ?>
      <th></th>
    <?php endif; ?>
  <td></td>
  <td class="text-right"><?= four_decimal($weight, '-'); ?></td>
  <td></td>
  <td class="text-right"><?= four_decimal($fine, '-') ?></td>
  <td></td>
  <td class="text-right"><?= four_decimal($factory_fine, '-') ?></td>
  <?php //if ($report != 'account ledger'): ?>
    <td class="text-right"><?= four_decimal($weight_difference, '-'); ?></td>
  <?php //endif; ?>
</tr>
