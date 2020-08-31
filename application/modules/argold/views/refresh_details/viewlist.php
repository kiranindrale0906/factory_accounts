<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th></th>
        <th class="text-right">Weight</th>
        <th class="text-right">Melting</th>
        <th class="text-right">Fine</th>
        <th class="text-right">Factory Melting</th>
        <th class="text-right">Factory Fine</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    if(!empty($refresh_details)){
      $sum_weight=$sum_fine=$sum_factory_fine=0;
     foreach ($refresh_details as $index => $refresh_detail) {
      $sum_weight+=$refresh_detail['weight'];
      $sum_fine+=$refresh_detail['fine'];
      $sum_factory_fine+=$refresh_detail['factory_fine'];

      ?>
      <tr>
        <td><?=$index+1?></td>
        <td class="text-right"><?= $refresh_detail['weight']; ?></td>
        <td class="text-right"><?= $refresh_detail['purity'] ?></td>
        <td class="text-right"><?=$refresh_detail['fine'] ?></td>
        <td class="text-right"><?=$refresh_detail['factory_purity'] ?></td>
        <td class="text-right"><?=$refresh_detail['factory_fine'] ?></td>
      </tr>

    <?php }?>
      <tr class="bg_gray bold">
    <td>Total</td>
    <td class="text-right"><?=four_decimal($sum_weight);?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_fine);?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_factory_fine);?></td>
  </tr>
   <?php } ?>
    </tbody>
  </table>
</div>
