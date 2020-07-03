<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th></th>
        <th>Itam Name</th>
        <th class="text-right">Gross</th>
        <th class="text-right">Melting</th>
        <th class="text-right">Wastage</th>
        <th class="text-right">Net wt</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    if(!empty($metal_vouchers)){
      $sum_weight=$sum_fine=0;
     foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
      $sum_weight+=$metal_voucher_detail['credit_weight'];
      $sum_fine+=$metal_voucher_detail['factory_fine'];

      ?>
      <tr>
        <td><?=$index+1?></td>
        <td><?= $metal_voucher_detail['narration'] ?></td>
        <td class="text-right"><?= $metal_voucher_detail['credit_weight']; ?></td>
        <td class="text-right"><?= $metal_voucher_detail['chitti_purity'] ?></td>
        <td class="text-right"><?= four_decimal($metal_voucher_detail['factory_purity'] - $metal_voucher_detail['chitti_purity']) ?></td>
        <td class="text-right"><?=$metal_voucher_detail['factory_fine'] ?></td>
      </tr>

    <?php }?>
      <tr class="bg_gray bold">
    <td>Total</td>
    <td></td>
    <td class="text-right"><?=four_decimal($sum_weight);?></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_fine);?></td>
  </tr>
   <?php } ?>
    </tbody>
  </table>
</div>
