<h6 class="heading blue bold text-uppercase mb-0">Loss Summary</h6>
  <hr>
<div class="row"> 
  <div class="col-md-6">
    <div class="form-group container"> 
      <h5> Select Quator:
        <?php
          $quators=array_column($quators, 'name');
          foreach ($quators as $index => $quator) { ?>
            <a class="ml-5 <?= ($quator_name== $quator) ? 'bold black underline' : '' ?>" 
               href='<?= base_url().'reports/loss_summaries' ?>?quator=<?= $quator?>'><?= $quator ?></a>
          <?php }
        ?>
      </h5>
    </div>
  </div>
</div>

<hr>  
<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th class=""></th>
        <th class="text-right">Total Production</th>
        <th class="text-right">GPC Powder</th>
        <th class="text-right">GPC Vodator</th>
        <th class="text-right">Unrecoverable Loss</th>
        <th class="text-right">Final Loss</th>
        <th class="text-right">Per Kg Loss</th>
        <th class="text-right">Total Loss</th>
        <th class="text-right">Without Recovery Per KG Loss</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    ?>
      <tr>
        <td class="">AR Gold</td>
        
        <td class="text-right"><?=$arg_total_production=!empty($arg_total_production)?four_decimal(abs($arg_total_production)):0?></td>
        <td class="text-right"><?=$arg_gpc_powder=!empty($arg_gpc_powder)?four_decimal($arg_gpc_powder):0?></td>
        <td class="text-right"><?=$arg_gpc_vodator=!empty($arg_gpc_vodator)?four_decimal($arg_gpc_vodator):0?></td>
        <td class="text-right"><?=$arg_unrecoverable_loss=!empty($arg_unrecoverable_loss)?four_decimal($arg_unrecoverable_loss):0?></td>
        <td class="text-right"><?=$arg_final_loss=four_decimal($arg_gpc_powder
                                                  +$arg_unrecoverable_loss
                                                  -$arg_gpc_vodator)?>
        </td>
        <td class="text-right"><?=$arg_per_kg_loss=!empty($arg_total_production)?four_decimal($arg_final_loss/$arg_total_production):0?></td>
        <td class="text-right"><?=$arg_loss=(!empty($arg_total_loss)||!empty($arg_gpc_powder)||!empty($arg_gpc_vodator))?four_decimal($arg_total_loss+$arg_gpc_powder-$arg_gpc_vodator):0?></td>
        <td class="text-right"><?=$arg_without_recovery_per_kg_loss=!empty($arg_total_production)?four_decimal($arg_total_loss/$arg_total_production):0?></td>
      </tr><tr>
        <td class="">ARF</td>
        <td class="text-right"><?=$arf_total_production=!empty($arf_total_production)?four_decimal(abs($arf_total_production)):0?></td>
        <td class="text-right"><?=$arf_gpc_powder=!empty($arf_gpc_powder)?four_decimal($arf_gpc_powder):0?></td>
        <td class="text-right"><?=$arf_gpc_vodator=!empty($arf_gpc_vodator)?four_decimal($arf_gpc_vodator):0?></td>
        <td class="text-right"><?=$arf_unrecoverable_loss=!empty($arf_unrecoverable_loss)?four_decimal($arf_unrecoverable_loss):0?></td>
        <td class="text-right"><?=$arf_final_loss=four_decimal($arf_gpc_powder
                                                  +$arf_unrecoverable_loss
                                                  -$arf_gpc_vodator)?></td>
        <td class="text-right"><?=$arf_per_kg_loss=!empty($arf_total_production)?four_decimal($arf_final_loss/$arf_total_production):0?></td>
        <td class="text-right"><?=$arf_loss=(!empty($arf_total_loss)||!empty($arf_gpc_powder)||!empty($arf_gpc_vodator))?four_decimal($arf_total_loss+$arf_gpc_powder-$arf_gpc_vodator):0?></td>
        <td class="text-right"><?=$arf_without_recovery_per_kg_loss=!empty($arf_total_production)?four_decimal($arf_total_loss/$arf_total_production):0?></td>
      </tr><tr>
        <td class="">ARC</td>
        <td class="text-right"><?=$arc_total_production=!empty($arc_total_production)?four_decimal(abs($arc_total_production)):0?></td>
        <td class="text-right"><?=$arc_gpc_powder=!empty($arc_gpc_powder)?four_decimal($arc_gpc_powder):0?></td>
        <td class="text-right"><?=$arc_gpc_vodator=!empty($arc_gpc_vodator)?four_decimal($arc_gpc_vodator):0?></td>
        <td class="text-right"><?=$arc_unrecoverable_loss=!empty($arc_unrecoverable_loss)?four_decimal($arc_unrecoverable_loss):0?></td>
        <td class="text-right"><?=$arc_final_loss=four_decimal($arc_gpc_powder
                                                  +$arc_unrecoverable_loss
                                                  -$arc_gpc_vodator)?></td>
        <td class="text-right"><?=$arc_per_kg_loss=!empty($arc_total_production)?four_decimal($arc_final_loss/$arc_total_production):0?></td>
        <td class="text-right"><?=$arc_loss=(!empty($arc_total_loss)||!empty($arc_gpc_powder)||!empty($arc_gpc_vodator))?four_decimal($arc_total_loss+$arc_gpc_powder-$arc_gpc_vodator):0?></td>
        <td class="text-right"><?=$arc_without_recovery_per_kg_loss=!empty($arc_total_production)?four_decimal($arc_total_loss/$arc_total_production):0?></td>
      </tr>
      <tr class="bg_gray bold">
        <td>Total</td>
        <td class="text-right"><?=four_decimal($arg_total_production
                                 +$arf_total_production
                                 +$arc_total_production)?></td>
        <td class="text-right"><?=four_decimal($arg_gpc_powder
                                 +$arf_gpc_powder
                                 +$arc_gpc_powder)?></td>
        <td class="text-right"><?=four_decimal($arg_gpc_vodator
                                 +$arf_gpc_vodator
                                 +$arc_gpc_vodator)?></td>
        <td class="text-right"><?=four_decimal($arg_unrecoverable_loss
                                 +$arf_unrecoverable_loss
                                 +$arc_unrecoverable_loss)?></td>
        <td class="text-right"><?=four_decimal($arg_final_loss
                                 +$arf_final_loss
                                 +$arc_final_loss)?></td>
        <td class="text-right"><?=four_decimal($arg_per_kg_loss
                                 +$arf_per_kg_loss
                                 +$arc_per_kg_loss)?></td>
        <td class="text-right"><?=four_decimal($arg_loss
                                 +$arf_loss
                                 +$arc_loss)?></td>
        <td class="text-right"><?=four_decimal($arg_without_recovery_per_kg_loss
                                 +$arf_without_recovery_per_kg_loss
                                 +$arc_without_recovery_per_kg_loss)?></td>
                                 

      </tr>
    </tbody>
  </table>
</div>
<h5>Production Report</h5>
<hr>
<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th class=""></th>
        <?php foreach ($month_record as $key => $value) { ?>
        <th class="text-right"><?=date('M',strtotime($value))?></th>
        <?php 
        } ?>
      </tr>
    </thead>
    <tbody>
    <?php 
    ?>
      <tr>
        <td class="">AR Gold</td>
        <?php foreach ($month_record as $month_key => $month) { ?>
                <td class="text-right"><?=!empty($argold_production_report)&&!empty($argold_production_report[$month])?abs($argold_production_report[$month]['balance']):0?></td>
                 
        <?php }?>
      </tr>
      <tr>
        <td class="">ARF</td>
        <?php foreach ($month_record as $month_key => $month) {?>
                <td class="text-right"><?=!empty($arf_production_report)&&!empty($arf_production_report[$month])?abs($arf_production_report[$month]['balance']):0?></td>
                 
        <?php }?>
      </tr><tr>
        <td class="">ARC</td>
        <?php foreach ($month_record as $month_key => $month) {?>
                <td class="text-right"><?=!empty($arc_production_report)&&!empty($arc_production_report[$month])?abs($arc_production_report[$month]['balance']):0?></td>
                 
        <?php }?>
      </tr>
    </tbody>
  </table>
</div>