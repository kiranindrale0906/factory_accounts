<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th class="">Date</th>
        <th class="text-right">Loss Period</th>
        <th class="text-right">In Loss Gross</th>
        <th class="text-right">Purity</th>
        <th class="text-right">In Loss Fine</th>
        <th class="text-right">Melting Production</th>
        <th class="text-right">Loss % Before Recovery</th>
        <th class="text-right">Product Production</th>
        <th class="text-right">Metal Receive After Recovery</th>
        <th class="text-right">Purity</th>
        <th class="text-right">Fine</th>
        <th class="text-right">Loss</th>
        <th class="text-right">Loss % After Recovery</th>
        <th class="text-right">Loss % On Product Production</th>
        <th class="text-right">Action</th>
      </tr>
    </thead>
    <tbody>
    <?php 
      $sum_weight=$sum_fine=$sum_factory_fine=$sum_receipt_weight=$sum_receipt_weight=$sum_total_fine=$sum_receipt_fine=$sum_loss_befor_recovery=$sum_melting_production=$sum_production=$sum_after_recovery=$sum_after_fine=$sum_loss=0;
     foreach ($loss_details as $index => $loss_out_detail) {
      $sum_weight+=$loss_out_detail->in_weight;
      $sum_fine+=($loss_out_detail->in_weight*$loss_out_detail->in_lot_purity/100);
      $sum_melting_production+=($loss_out_detail->out_weight);
      $sum_production+=($loss_out_detail->production);
      $sum_after_recovery+=($loss_out_detail->after_recovery);
      $sum_after_fine+=($loss_out_detail->fine);
      $sum_loss+=(($loss_out_detail->in_weight*$loss_out_detail->in_lot_purity/100)-($loss_out_detail->fine));
      $sum_loss_befor_recovery+=!empty($loss_out_detail->out_weight)?(($loss_out_detail->in_weight*$loss_out_detail->in_lot_purity/100)/$loss_out_detail->out_weight):0;
      ?>
      <tr>
        <td><?=date('d-m-Y',strtotime($loss_out_detail->created_at));?></td>
        <td><?=date('d-m-Y',strtotime($loss_out_detail->first_date)).' To '.date('d-m-Y',strtotime($loss_out_detail->last_date)); ?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail->in_weight)?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail->in_lot_purity)?></td>
        <td class="text-right"><?=$fine=four_decimal($loss_out_detail->in_weight*$loss_out_detail->in_lot_purity/100);?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail->out_weight);?></td>
        <td class="text-right"><?=!empty($loss_out_detail->out_weight)?four_decimal($fine/$loss_out_detail->out_weight):0;?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail->production);?></td>
        <td class="text-right">
          <a href=<?= base_url()."ac_vouchers/voucher_listing?parent_id=".$loss_out_detail->parent_id ?> target='_blank'><?=four_decimal($loss_out_detail->after_recovery);?></a></td>
        <td class="text-right"><?=four_decimal($loss_out_detail->purity);?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail->fine);?></td>
        <td class="text-right"><?=$loss=four_decimal($fine-$loss_out_detail->fine);?></td>
        <td class="text-right"><?=!empty($loss_out_detail->out_weight)?four_decimal($loss/$loss_out_detail->out_weight):0;?></td>
        <td class="text-right"><?=!empty($loss_out_detail->production)?four_decimal($loss/$loss_out_detail->production):0;?></td>
        <td class="text-right">
        <?php //if($parent_id==0){ ?>
          <a href=<?= base_url()."transactions/metal_receipt_vouchers?receipt_type=Metal&parent_id=".$loss_out_detail->parent_id ?> target='_blank'>create metal receipt</a>
          <?php //}?>
        </td>
      </tr>

    <?php }?>
      <tr class="bg_gray bold">
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_weight)?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_fine)?></td>
    <td class="text-right"><?=four_decimal($sum_melting_production)?></td>
    <td class="text-right"><?=four_decimal($sum_loss_befor_recovery)?></td>
    <td class="text-right"><?=four_decimal($sum_production)?></td>
    <td class="text-right"><?=four_decimal($sum_after_recovery)?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_after_fine)?></td>
    <td class="text-right"><?=four_decimal($sum_loss)?></td>
    <td class="text-right"><?=four_decimal($sum_loss/$sum_melting_production)?></td>
    <td class="text-right"><?=four_decimal($sum_loss/$sum_production)?></td>
    <td class="text-right"></td>
    <td></td>
  </tr>
    </tbody>
  </table>
</div>