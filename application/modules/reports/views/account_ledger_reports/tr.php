<tr>
  <td><?= $record['url'];?></td>
  <td><?= $record['product_name'] ?></td>
  <td><?= $record['issue_type'];?></td>
  <td><?= $record['description'];?></td>
  <td class="text-right"><?= $record['weight'] ?></td>
  <td class="text-right"><?= four_decimal($record['purity']); ?></td>
  <td class="text-right"><?= four_decimal($record['fine']); ?></td>
  <td><?= $record['created_at']; ?></td>
</tr>