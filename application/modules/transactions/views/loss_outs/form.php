<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th></th>
        <th class="">Date</th>
        <th class="text-right">Weight</th>
        <th class="text-right">Melting</th>
        <th class="text-right">Fine</th>
        <th class="text-right">Factory Melting</th>
        <th class="text-right">Factory Fine</th>
        <th class="text-right">Action</th>
      </tr>
    </thead>
    <tbody>
    <?php 
      $sum_weight=$sum_fine=$sum_factory_fine=0;
     foreach ($loss_out_details as $index => $loss_out_detail) {
      $sum_weight+=$loss_out_detail['credit_weight'];
      $sum_fine+=$loss_out_detail['fine'];
      $sum_factory_fine+=$loss_out_detail['factory_fine'];

      ?>
      <tr>
        <td><?=$index+1?></td>
        <td><?=date('d M Y',strtotime($loss_out_detail['created_at']));?></td>
        <td class="text-right"><?= $loss_out_detail['credit_weight']; ?></td>
        <td class="text-right"><?= $loss_out_detail['purity'] ?></td>
        <td class="text-right"><?=$loss_out_detail['fine'] ?></td>
        <td class="text-right"><?=$loss_out_detail['factory_purity'] ?></td>
        <td class="text-right"><?=$loss_out_detail['factory_fine'] ?></td>
        <td class="text-right"><a href=<?= base_url()."transactions/metal_receipt_vouchers" ?> target='_blank'>create metal receipt voucher</a></td>
      </tr>

    <?php }?>
      <tr class="bg_gray bold">
    <td>Total</td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_weight);?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_fine);?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_factory_fine);?></td>
    <td></td>
  </tr>
    </tbody>
  </table>
</div>
</div>