<?php $category=$_GET['category']; ?>

<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th class="">Date</th>
        <th class="text-right">Loss Period</th>
        <th class="text-right">In Loss Gross</th>
        <th class="text-right">Purity</th>
        <th class="text-right">In Loss Fine</th>
        <th class="text-right">Out Weight</th>
        <th class="text-right">Per Kg Loss</th>
        <th class="text-right">Metal Receive After Recovery</th>
        <th class="text-right">Recovered Fine</th>
        <th class="text-right">Per Kg Loss After Recovery</th>
        <th class="text-right">Unrecoverable</th>
        <th class="text-right">Balance Loss</th>
        <th class="text-right">%Recovered</th>
        <!-- <th class="text-right">Loss % On Product Production</th> -->
        <th class="text-right">Action</th>
        <th class="text-right"></th>
        <th class="text-right"></th>
      </tr>
    </thead>
    <tbody>
    <?php 
      $sum_weight=$sum_fine=$sum_factory_fine=$sum_receipt_weight=$sum_receipt_weight=$sum_total_fine=$sum_receipt_fine=$sum_loss_before_recovery=$sum_melting_production=$sum_production=$sum_after_recovery=$sum_after_fine=$sum_loss=$sum_unrecoverable=$sum_recoverd_fine=0;
     foreach ($loss_details as $index => $loss_out_detail) {
      $sum_weight+=$loss_out_detail['in_weight'];
      $sum_fine+=($loss_out_detail['in_weight']*$loss_out_detail['in_lot_purity']/100);
      $sum_melting_production+=($loss_out_detail['out_weight']);
      $sum_recoverd_fine+=($loss_out_detail['recoverd_loss_fine']);
      $sum_after_recovery+=($loss_out_detail['after_recovery']);
      $sum_unrecoverable+=($loss_out_detail['unrecoverable_loss']);
      $sum_after_fine+=0;//($loss_out_detail['fine']);
      $sum_loss+=($loss_out_detail['balance']);//(($loss_out_detail['in_weight']*$loss_out_detail['in_lot_purity']/100)-($loss_out_detail['fine'])-($loss_out_detail['unrecovery']));
      // $sum_loss_before_recovery+=four_decimal(($loss_out_detail['loss_fine']/$loss_out_detail['out_weight']*100));//!empty($loss_out_detail['out_weight'])?(($loss_out_detail['in_weight']*$loss_out_detail['in_lot_purity']/100)/$loss_out_detail['out_weight']*1000):0;
      ?>
      <tr>
        <td><?=date('d-m-Y',strtotime($loss_out_detail['created_at']));?></td>
        <td><?=date('d-m-Y',strtotime($loss_out_detail['first_date'])).' To '.date('d-m-Y',strtotime($loss_out_detail['last_date'])); ?></td>
        <td class="text-right"><?=!empty($loss_out_detail['in_weight'])?four_decimal($loss_out_detail['in_weight']):'-'?></td>
        <td class="text-right"><?=four_decimal($loss_out_detail['in_lot_purity'])?></td>
        <td class="text-right"><?=$fine=!empty($loss_out_detail['loss_fine'])?four_decimal($loss_out_detail['loss_fine']):'-';?></td>
        <td class="text-right"><?=(!empty($loss_out_detail['out_weight'])&& $loss_out_detail['out_weight']!=0)?four_decimal($loss_out_detail['out_weight']):'-';?></td>

        <td class="text-right"><?=(!empty($loss_out_detail['out_weight'])&& $loss_out_detail['out_weight']!=0)?four_decimal(($loss_out_detail['loss_fine']/$loss_out_detail['out_weight']*1000)):'-';?></td>


        <!-- <td class="text-right"><?//=four_decimal($loss_out_detail['production']);?></td> -->
        <td class="text-right">
          <a href=<?= base_url()."ac_vouchers/voucher_listing?parent_id=".$loss_out_detail['parent_id'] ?> target='_blank'><?=!empty($loss_out_detail['after_recovery'])?four_decimal($loss_out_detail['after_recovery']):0;?></a></td>
         <td class="text-right"><?=!empty($loss_out_detail['recoverd_loss_fine'])?four_decimal($loss_out_detail['recoverd_loss_fine']):'-';?></td>

        <td class="text-right"><?=(!empty($loss_out_detail['out_weight']) && $loss_out_detail['out_weight']!=0)?four_decimal((($loss_out_detail['loss_fine']-$loss_out_detail['recoverd_loss_fine'])/$loss_out_detail['out_weight']*1000)):'-';?></td>
        <td class="text-right"><?=!empty($loss_out_detail['unrecoverable_loss'])?four_decimal($loss_out_detail['unrecoverable_loss']):'-';?></td>
        <!-- <td class="text-right"><?//=!empty($loss_out_detail['production'])?four_decimal($loss/$loss_out_detail['production']*1000):0;?></td> -->
        <td class="text-right"><?=$loss=!empty($loss_out_detail['balance'])?four_decimal($loss_out_detail['balance']):'-';?></td>
        <td class="text-right"><?=(!empty($loss_out_detail['loss_fine'])&&!empty($loss_out_detail['after_recovery']))?four_decimal($loss_out_detail['after_recovery']/$loss_out_detail['loss_fine']*100):'-';?></td>
         
        <td class="text-right">
        <?php //if($parent_id==0){ ?>
          <a href=<?= base_url()."transactions/metal_receipt_vouchers?receipt_type=Metal&parent_id=".$loss_out_detail['parent_id'] ?> target='_blank'>create metal receipt</a>
          <?php //}?>
        </td>
        <td class="text-right">
        <?php if(!empty($loss_out_detail['balance']) && four_decimal($loss_out_detail['balance'])!=0){ ?>
          <a href=<?= base_url()."argold/unrecovarable_account_records/store?from=view&account_name=".urlencode("Loss Account")."&factory=Unrecovarable&credit_weight=".$loss."&narration=".urlencode($category)."&parent_id=".$loss_out_detail['parent_id'] ?> target='_blank' onclick="return confirm('Do you want to add this in Unrecovarable?')" >Unrecovarable</a>
          <?php }?>
        </td>
        <?php if(!empty($loss_out_detail['id'])){
          if($loss_out_detail['receipt_type']=='Ghiss Melting Loss'){ ?>
            <td class="text-right">
            <a href=<?= $factory_url."issue_departments/issue_department_quators/edit/".$loss_out_detail['id'] ?> target='_blank' >Add Quartor</a>
          </td>
          <?php }else{
          ?>
          <td class="text-right">
            <a href=<?= $factory_url."processes/process_quators/edit/".$loss_out_detail['id'] ?> target='_blank' >Add Quartor</a>
          </td>
        <?php }?>
         
      </tr>

    <?php }?>
      <tr class="bg_gray bold">
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_weight)?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_fine)?></td>
    <td class="text-right"><?=four_decimal($sum_melting_production)?></td>
    <td class="text-right"><?=!empty($sum_melting_production)?four_decimal($sum_fine/$sum_melting_production*1000):0?></td>
    <td class="text-right"><?=four_decimal($sum_after_recovery)?></td>
    <td class="text-right"><?=four_decimal($sum_recoverd_fine)?></td>
    <td class="text-right"><?=!empty($sum_melting_production)?four_decimal(($sum_fine-$sum_recoverd_fine)/$sum_melting_production*1000):0?></td>
    <td class="text-right"><?=four_decimal($sum_unrecoverable)?></td>
    <td class="text-right"><?=four_decimal($sum_loss)?></td>
    <td class="text-right"><?=!empty($sum_fine)?four_decimal($sum_after_recovery/$sum_fine*100):'-'?></td>
    <td class="text-right"></td>
    <td></td>
    <td></td>
  </tr>
    </tbody>
  </table>
</div>