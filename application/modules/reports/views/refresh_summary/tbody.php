<tbody>
  <tr>
    <td><?= $record['created_at'] ?></td>
    <td>
      <?= $record['item_name'] ?> 
      <?php 
        $refresh_ids = explode(",", $record['refresh_id']);
        $refresh_weights = explode(",", $record['refresh_weight']);
        foreach ($refresh_ids as $index => $refresh_id) { ?>
          <a href='<?= base_url() ?>argold/refresh/view/<?=$refresh_id?>'><?= decimal_number_format($refresh_weights[$index], 2) ?></a>
          <?php 
        } 
      ?>    
    </td>
    <td><?= four_decimal($record['factory_purity']) ?></td>
    <td><?= four_decimal($record['purity']) ?></td>
    <td class='text-right'><?= four_decimal($record['weight']) ?></td>
    <td class='text-right'><?= four_decimal($record['weight'] * ($record['purity'] - $record['factory_purity']) / 100) ?></td>
  </tr>
</thead>