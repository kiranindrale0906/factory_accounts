<tbody>
  <tr>
    <td><?= $record['created_at'] ?></td>
    <td><?= $record['product_name'] ?></td>
    <td><?= $record['in_purity'] ?></td>
    <td><?= $record['out_purity'] ?></td>
    <td><?= $record['account_name'] ?></td>
    <td><?= $record['category_one'] ?></td>
    <td><?= @$record['machine_size'] ?></td>
    <td><?= @$record['design_code'] ?></td>
    <td class='text-right'><?= four_decimal($record['issue_gpc_out']) ?></td>
    <td class='text-right'><?= four_decimal($record['issue_gpc_out'] * ($record['out_purity'] - $record['in_purity']) / 100) ?></td>
  </tr>
</thead>