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
        
        <td class="text-right"><?=!empty($arg_total_production)?$arg_total_production:0?></td>
        <td class="text-right"><?=!empty($arg_gpc_powder)?$arg_gpc_powder:0?></td>
        <td class="text-right"><?=!empty($arg_gpc_vodator)?$arg_gpc_vodator:0?></td>
        <td class="text-right"><?=!empty($arg_unrecoverable_loss)?$arg_unrecoverable_loss:0?></td>
        <td class="text-right"><?=$arg_final_loss=($arg_gpc_powder
                                                  +$arg_unrecoverable_loss
                                                  -$arg_gpc_vodator)?>
        </td>
        <td class="text-right"><?=$arg_per_kg_loss=!empty($arg_total_production)?($arg_final_loss/$arg_total_production):0?></td>
        <td class="text-right"><?=$arg_total_loss=(0+$arg_gpc_powder-$arg_gpc_vodator)?></td>
        <td class="text-right"><?=!empty($arg_without_recovery_per_kg_loss)?$arg_without_recovery_per_kg_loss:0?></td>
      </tr><tr>
        <td class="">ARF</td>
        <td class="text-right"><?=!empty($arf_total_production)?$arf_total_production:0?></td>
        <td class="text-right"><?=!empty($arf_gpc_powder)?$arf_gpc_powder:0?></td>
        <td class="text-right"><?=!empty($arf_gpc_vodator)?$arf_gpc_vodator:0?></td>
        <td class="text-right"><?=!empty($arf_unrecoverable_loss)?$arf_unrecoverable_loss:0?></td>
        <td class="text-right"><?=$arf_final_loss=($arf_gpc_powder
                                                  +$arf_unrecoverable_loss
                                                  -$arf_gpc_vodator)?></td>
        <td class="text-right"><?=$arf_per_kg_loss=!empty($arf_total_production)?($arf_final_loss/$arf_total_production):0?></td>
        <td class="text-right"><?=$arf_total_loss=(0+$arf_gpc_powder-$arf_gpc_vodator)?></td>
        <td class="text-right"><?=!empty($arf_without_recovery_per_kg_loss)?$arf_without_recovery_per_kg_loss:0?></td>
      </tr><tr>
        <td class="">ARC</td>
        <td class="text-right"><?=!empty($arc_total_production)?$arc_total_production:0?></td>
        <td class="text-right"><?=!empty($arc_gpc_powder)?$arc_gpc_powder:0?></td>
        <td class="text-right"><?=!empty($arc_gpc_vodator)?$arc_gpc_vodator:0?></td>
        <td class="text-right"><?=!empty($arc_unrecoverable_loss)?$arc_unrecoverable_loss:0?></td>
        <td class="text-right"><?=$arc_final_loss=($arc_gpc_powder
                                                  +$arc_unrecoverable_loss
                                                  -$arc_gpc_vodator)?></td>
        <td class="text-right"><?=$arc_per_kg_loss=!empty($arc_total_production)?($arc_final_loss/$arc_total_production):0?></td>
        <td class="text-right"><?=$arc_total_loss=(0+$arc_gpc_powder-$arc_gpc_vodator)?></td>
        <td class="text-right"><?=!empty($arc_without_recovery_per_kg_loss)?$arc_without_recovery_per_kg_loss:0?></td>
      </tr>
      <tr class="bg_gray bold">
        <td>Total</td>
        <td class="text-right"><?=$arg_total_production
                                 +$arf_total_production
                                 +$arc_total_production?></td>
        <td class="text-right"><?=$arg_gpc_powder
                                 +$arf_gpc_powder
                                 +$arc_gpc_powder?></td>
        <td class="text-right"><?=$arg_gpc_vodator
                                 +$arf_gpc_vodator
                                 +$arc_gpc_vodator?></td>
        <td class="text-right"><?=$arg_unrecoverable_loss
                                 +$arf_unrecoverable_loss
                                 +$arc_unrecoverable_loss?></td>
        <td class="text-right"><?=$arg_final_loss
                                 +$arf_final_loss
                                 +$arc_final_loss?></td>
        <td class="text-right"><?=$arg_per_kg_loss
                                 +$arf_per_kg_loss
                                 +$arc_per_kg_loss?></td>
        <td class="text-right"><?=$arg_total_loss
                                 +$arf_total_loss
                                 +$arc_total_loss?></td>
        <td class="text-right"><?=$arg_without_recovery_per_kg_loss
                                 +$arf_without_recovery_per_kg_loss
                                 +$arc_without_recovery_per_kg_loss?></td>
                                 

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
        <th class="text-right">Month 1</th>
        <th class="text-right">Month 2</th>
        <th class="text-right">Month 3</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    ?>
      <tr>
        <td class="">AR Gold</td>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right"></td>
      </tr><tr>
        <td class="">ARF</td>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right"></td>
      </tr><tr>
        <td class="">ARC</td>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right"></td>
      </tr>
      <tr class="bg_gray bold">
        <td>Total</td>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right"></td>
      </tr>
    </tbody>
  </table>
</div>