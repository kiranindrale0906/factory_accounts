<?php $category=$_GET['category'];
?>

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
        <th class="text-right">Unrecoverable</th>
        <th class="text-right">Loss % After Recovery</th>
        <th class="text-right">Loss % On Product Production</th>
        <th class="text-right">Action</th>
        <th class="text-right"></th>
      </tr>
    </thead>
    <tbody>
    <?php 
      $sum_weight=$sum_fine=$sum_factory_fine=$sum_receipt_weight=$sum_receipt_weight=$sum_total_fine=$sum_receipt_fine=$sum_loss_befor_recovery=$sum_melting_production=$sum_production=$sum_after_recovery=$sum_after_fine=$sum_loss=$sum_unrecoverable=0;
     foreach ($loss_details as $index => $loss_out_detail) {
      $sum_weight+=$loss_out_detail['in_weight'];
      $sum_fine+=($loss_out_detail['in_weight']*$loss_out_detail['in_lot_purity']/100);
      $sum_melting_production+=($loss_out_detail['out_weight']);
      $sum_production+=($loss_out_detail['production']);
      $sum_after_recovery+=($loss_out_detail['after_recovery']);
      $sum_unrecoverable+=($loss_out_detail['unrecovery']);
      $sum_after_fine+=($loss_out_detail['fine']);
      $sum_loss+=(($loss_out_detail['in_weight']*$loss_out_detail['in_lot_purity']/100)-($loss_out_detail['fine'])-($loss_out_detail['unrecovery']));
      $sum_loss_befor_recovery+=!empty($loss_out_detail['out_weight'])?(($loss_out_detail['in_weight']*$loss_out_detail['in_lot_purity']/100)/$loss_out_detail['out_weight']*1000):0;
      ?>
      <tr>
        <td><?=date('d-m-Y',strtotime($loss_out_detail['created_at']));?></td>
        <td><?=date('d-m-Y',strtotime($loss_out_detail['first_date'])).' To '.date('d-m-Y',strtotime($loss_out_detail['last_date'])); ?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['in_weight'])?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['in_lot_purity'])?></td>
        <td class="text-right"><?=$fine=four_decimal($loss_out_detail['in_weight']*$loss_out_detail['in_lot_purity']/100);?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['out_weight']);?></td>
        <td class="text-right"><?=!empty($loss_out_detail['out_weight'])?eight_decimal($fine/$loss_out_detail['out_weight']*1000):0;?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['production']);?></td>
        <td class="text-right">
          <a href=<?= base_url()."ac_vouchers/voucher_listing?parent_id=".$loss_out_detail['parent_id'] ?> target='_blank'><?=four_decimal($loss_out_detail['after_recovery']);?></a></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['purity']);?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['fine']);?></td>
        <td class="text-right"><?=$loss=four_decimal($fine-$loss_out_detail['fine']-$loss_out_detail['unrecovery']);?></td>
        <td class="text-right"><?=!empty($loss_out_detail['unrecovery'])?eight_decimal(-$loss_out_detail['unrecovery']):0;?></td>
        <td class="text-right"><?=!empty($loss_out_detail['out_weight'])?eight_decimal($loss/$loss_out_detail['out_weight']*1000):0;?></td>
        <td class="text-right"><?=!empty($loss_out_detail['production'])?four_decimal($loss/$loss_out_detail['production']*1000):0;?></td>
        <td class="text-right">
        <?php //if($parent_id==0){ ?>
          <a href=<?= base_url()."transactions/metal_receipt_vouchers?receipt_type=Metal&parent_id=".$loss_out_detail['parent_id'] ?> target='_blank'>create metal receipt</a>
          <?php //}?>
        </td>
        <td class="text-right">
        <?php if(empty($loss_out_detail->unrecovery)){ ?>
          <a href=<?= base_url()."argold/unrecovarable_account_records/store?from=view&account_name=Unrecovarable&credit_weight=".$loss."&narration=".urlencode($category)."&parent_id=".$loss_out_detail['parent_id'] ?> target='_blank'>Unrecovarable</a>
          <?php }?>
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
    <td class="text-right"><?=eight_decimal($sum_loss_befor_recovery)?></td>
    <td class="text-right"><?=four_decimal($sum_production)?></td>
    <td class="text-right"><?=four_decimal($sum_after_recovery)?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_after_fine)?></td>
    <td class="text-right"><?=four_decimal($sum_loss)?></td>
    <td class="text-right"><?=four_decimal($sum_unrecoverable)?></td>
    <td class="text-right"><?=!empty($sum_melting_production)?eight_decimal($sum_loss/$sum_melting_production):0?></td>
    <td class="text-right"><?=!empty($sum_production)?four_decimal($sum_loss/$sum_production*1000):0?></td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td></td>
  </tr>
    </tbody>
  </table>
</div>