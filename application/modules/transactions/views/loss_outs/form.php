<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th></th>
        <th class="">Date</th>
        <th class="text-right">Site Name</th>
        <th class="text-right">Weight</th>
        <th class="text-right">Melting</th>
        <th class="text-right">Fine</th>
        <th class="text-right">Factory Melting</th>
        <th class="text-right">Factory Fine</th>
        <th class="text-right">Description</th>
        <th class="text-right">Total Out Weight</th>
        <th class="text-right">Out Weight</th>
        <th class="text-right">Purity</th>
        <th class="text-right">Action</th>
      </tr>
    </thead>
    <tbody>
    <?php 
      $sum_weight=$sum_fine=$sum_factory_fine=$sum_receipt_weight=$sum_receipt_weight=0;
     foreach ($loss_out_details as $index => $loss_out_detail) {
      $sum_weight+=$loss_out_detail['credit_weight'];
      $sum_fine+=$loss_out_detail['fine'];
      $sum_factory_fine+=$loss_out_detail['factory_fine'];
      $sum_receipt_weight+=$loss_out_detail['receipt_weight'];
      $sum_factory_fine+=$loss_out_detail['factory_fine'];
      $parent_id=parent_id_exist($loss_out_detail['id']);

      ?>
      <tr>
        <td><?=$index+1?></td>
        <td><?=date('d M Y',strtotime($loss_out_detail['created_at']));?></td>
        <td><?=$loss_out_detail['site_name'];?></td>
        <td class="text-right"><?= $loss_out_detail['credit_weight']; ?></td>
        <td class="text-right"><?= $loss_out_detail['purity'] ?></td>
        <td class="text-right"><?=$loss_out_detail['fine'] ?></td>
        <td class="text-right"><?=$loss_out_detail['factory_purity'] ?></td>
        <td class="text-right"><?=$loss_out_detail['factory_fine'] ?></td>
        <td class="text-right"><?=$loss_out_detail['description'] ?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['narration']) ?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['receipt_weight']) ?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['receipt_purity']) ?></td>
        <td class="text-right">
        <?php //if($parent_id==0){ ?>
          <a href=<?= base_url()."transactions/metal_receipt_vouchers?receipt_type=Metal&parent_id=".$loss_out_detail['id'] ?> target='_blank'>create metal receipt</a>
          <?php //}?>
        </td>
      </tr>

    <?php }?>
      <tr class="bg_gray bold">
    <td>Total</td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_weight);?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_fine);?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_factory_fine);?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_receipt_weight);?></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td></td>
  </tr>
    </tbody>
  </table>
</div>