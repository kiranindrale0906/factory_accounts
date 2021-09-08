<tbody>
  <tr>
    <td><?= $record['created_at'] ?></td>
    <td><?= $record['item_name'] ?></td>
    <td><?= four_decimal($record['factory_purity']) ?></td>
    <td><?= four_decimal($record['purity']) ?></td>
    <td class='text-right'><?= four_decimal($record['weight']) ?></td>
    <td class='text-right'><?= four_decimal($record['weight'] * ($record['purity'] - $record['factory_purity']) / 100) ?></td>
  </tr>
</thead>