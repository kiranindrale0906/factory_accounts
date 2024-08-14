<tbody>
  <tr>
<?php $wastage_percentage=!empty($record['wastage_percentage'])?$record['wastage_percentage']:0; ?>
    <td><?= $record['created_at'] ?></td>
    <td><?= $record['product_name'] ?></td>
    <td><?= four_decimal($record['in_purity']) ?></td>
    <td><?= $out_purity=four_decimal($record['out_purity']+$wastage_percentage) ?></td>
    <td><?= $record['account_name'] ?></td>
    <td><?= $record['category_one'] ?></td>
    <td><?= @$record['machine_size'] ?></td>
    <td><?= @$record['design_code'] ?></td>
    <td class='text-right'><?= four_decimal($record['issue_gpc_out']) ?></td>
    <td class='text-right'><?= four_decimal($record['issue_gpc_out'] * ($out_purity - $record['in_purity']) / 100) ?></td>
  </tr>
</thead>
