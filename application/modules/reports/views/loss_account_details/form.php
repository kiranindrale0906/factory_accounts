<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th></th>
        <th class="">Date</th>
        <th class="text-right">Site Name</th>
        <th class="text-right">Total Out Weight</th>
        <th class="text-right">Receipt  Weight</th>
        <th class="text-right">Receipt Melting</th>
        <th class="text-right">Receipt Fine</th>
        <th class="text-right">Issue Weight</th>
        <th class="text-right">Issue Purity</th>
        <th class="text-right">Issue Fine</th>
        <th class="text-right">Total Fine</th>
      </tr>
    </thead>
    <tbody>
    <?php 
      $sum_weight=$sum_fine=$sum_factory_fine=$sum_receipt_weight=$sum_receipt_weight=$sum_total_fine=$sum_receipt_fine=0;
     foreach ($loss_out_details as $index => $loss_out_detail) {
      $sum_weight+=$loss_out_detail['credit_weight'];
      $sum_fine+=$loss_out_detail['fine'];
      $sum_receipt_fine+=$loss_out_detail['receipt_fine'];
      $sum_receipt_weight+=$loss_out_detail['receipt_weight'];
      $sum_total_fine+=$loss_out_detail['total_fine'];

      ?>
      <tr>
        <td><?=$index+1?></td>
        <td><?=date('d M Y',strtotime($loss_out_detail['created_at']));?></td>
        <td><?=$loss_out_detail['site_name'];?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['narration']) ?></td>
        <td class="text-right"><?= $loss_out_detail['credit_weight']; ?></td>
        <td class="text-right"><?= $loss_out_detail['purity'] ?></td>
        <td class="text-right"><?=$loss_out_detail['fine'] ?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['receipt_weight']) ?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['receipt_purity']) ?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['receipt_fine']) ?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['total_fine']) ?></td>
      </tr>

    <?php }?>
      <tr class="bg_gray bold">
    <td>Total</td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_weight);?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_fine);?></td>
    <td class="text-right"><?=four_decimal($sum_receipt_weight);?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_receipt_fine);?></td>
    <td class="text-right"><?=four_decimal($sum_total_fine);?></td>
    <td></td>
  </tr>
    </tbody>
  </table>
</div>